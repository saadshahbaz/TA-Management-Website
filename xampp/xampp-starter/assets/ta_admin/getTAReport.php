<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

$entered = 'entered';
// Create connection
// $conn = new mysqli($servername, $username, $password, $db);
$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);
// Check connection
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }

$ta_email = $_POST['email'];
$student_id = $_POST['student_id'];

if ($ta_email == 'null') {
    die('NO TA SELECTED');
}

// if (strcmp($student_id, '') == 0) {
//     echo '<p>' . $entered . '</p>';
// }

// if (strcmp($ta_email, '') != 0 and strcmp($student_id, '') != 0) {
$sql = $conn->prepare('SELECT * FROM TA WHERE email=:email');
// $sql->bind_param('ss', $ta_email, $student_id);
$sql->bindValue(':email', $ta_email);
$result = $sql->execute();
//$result = $sql->get_result();

$sql2 = $conn->prepare(
    'SELECT FORMAT(AVG(TA_Ratings.rating),2) as ta_rating_average FROM TA_Ratings WHERE TA_Ratings.ta_email = (SELECT DISTINCT email FROM TA where ta.email = :email)'
);

$sql2->bindValue(':email', $ta_email);

// $sql2->bind_param('ss', $student_id, $ta_email);
$ta_averges = $sql2->execute();

// $ta_averges = $sql2->get_result();

$sql3 = $conn->prepare(
    'SELECT COUNT(course) as total_courses FROM `TA` WHERE email = :email'
);

$sql3->bindValue(':email', $ta_email);
// $sql3->bind_param('ss', $ta_email, $student_id);
$num_crs = $sql3->execute();
// $num_crs = $sql3->get_result();

$ta = $result->fetchArray();
$average = $ta_averges->fetchArray();
$total_courses = $num_crs->fetchArray();

echo '<h3 style="color:rgb(167, 37, 48);" >' .
    $ta['ta_name'] .
    ' Summary  </h3>';

echo '<table>';
echo '<tr>
    <th class="red-label">Email</th>
    <th class="red-label">Student ID</th>
    <th class="red-label">Name</th>
    <th class="red-label">Total Assigned Courses</th>
    <th class="red-label">Average Feedback</th>
    </tr>';

echo '<tr>
    <td>' .
    $ta['email'] .
    '</td>
    <td>' .
    $ta['student_id'] .
    '</td>
    <td>' .
    $ta['ta_name'] .
    '</td>
    <td>' .
    $total_courses['total_courses'] .
    '</td>
    <td>' .
    $average['ta_rating_average'] .
    '</td>
        </tr>';

if ($ta['email'] == '') {
    echo '<p style="display:flex;
                    justify-content:center;
                        align-item:center;
                        margin-top: 20px;
                        color: rgb(167, 37, 48);
                        font-weight: bold;
                        font-size: 18px;">' .
        $NotFound .
        '</p>';
    die();
}

echo '</table>';
// echo '<p>' . $average['ta_rating_average'] . '</p>';

// echo '<p>' . $ta['email'] . '</p>';

// First we need to get the TA Credentials
// We can have to two tables
// A summarized report with their First Name, Last Name, email, Rating Average, Course

// We then need the
$conn->close();
?>

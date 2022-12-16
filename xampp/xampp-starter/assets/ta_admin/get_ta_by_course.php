<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
$course = $_POST['course'];
$year = $_POST['year'];
$term = $_POST['term'];

$NotFound = 'No Entry Found!';
$Found = ' Entry Found!';

if ($course == 'null') {
    die('NO COURSE SELECTED');
}

if ($term != 'null' and $year != 'null') {
    $sql = $conn->prepare(
        'SELECT * FROM TA WHERE course= ? AND term= ? AND years= ?'
    );
    $sql->bind_param('sss', $course, $term, $year);
    $sql->execute();
    $result = $sql->get_result();

    $sql2 = $conn->prepare(
        'SELECT * FROM course WHERE courseNumber= ? AND term= ? AND year= ?'
    );
    $sql2->bind_param('sss', $course, $term, $year);
    $sql2->execute();
    $result2 = $sql2->get_result();
} elseif ($term == 'null' and $year != 'null') {
    $sql = $conn->prepare('SELECT * FROM TA WHERE course= ? AND years= ?');
    $sql->bind_param('ss', $course, $year);
    $sql->execute();
    $result = $sql->get_result();

    $sql2 = $conn->prepare(
        'SELECT * FROM course WHERE courseNumber= ? AND year= ?'
    );
    $sql2->bind_param('ss', $course, $year);
    $sql2->execute();
    $result2 = $sql2->get_result();
} elseif ($term != 'null' and $year == 'null') {
    $sql = $conn->prepare('SELECT * FROM TA WHERE course= ? AND term= ?');
    $sql->bind_param('ss', $course, $term);
    $sql->execute();
    $result = $sql->get_result();

    $sql2 = $conn->prepare(
        'SELECT * FROM course WHERE courseNumber= ? AND term= ?'
    );
    $sql2->bind_param('ss', $course, $term);
    $sql2->execute();
    $result2 = $sql2->get_result();
} else {
    $sql = $conn->prepare('SELECT * FROM TA WHERE course= ?');
    $sql->bind_param('s', $course);
    $sql->execute();
    $result = $sql->get_result();

    $sql2 = $conn->prepare('SELECT * FROM course WHERE courseNumber= ?');
    $sql2->bind_param('s', $course);
    $sql2->execute();
    $result2 = $sql2->get_result();
}
echo '<h3 style="color:rgb(167, 37, 48);" > Course Information </h3>';
echo '<table>';
echo '<tr>
    <th class="red-label">Course Number</th>
    <th class="red-label">Term & Year</th>
    <th class="red-label">Total Credits</th>
    <th class="red-label">Course Enrollement Number </th>
    <th class="red-label">TA Quota</th>
    <th class="red-label">Student to TA Ratio</th>
    <th class="red-label">Flagged</th>
    </tr>';

if (mysqli_num_rows($result2) == 0) {
    echo '</table>';
    echo '<p style="display:flex; 
                        justify-content:center;
                         align-item:center;
                         margin-top: 20px;
                         color: rgb(167, 37, 48);
                         font-weight: bold;
                         font-size: 18px;">' .
        $NotFound .
        '</p>';
}

while ($ta = $result2->fetch_assoc()) {
    $query = $conn->prepare(
        'SELECT * FROM Course_Quota WHERE course_num = ? AND term_year = ?'
    );
    $term_year = $ta['term'] . ' ' . $ta['year'];
    $query->bind_param('ss', $ta['courseNumber'], $term_year);
    $query->execute();
    $res = $query->get_result();
    $user = $res->fetch_assoc();

    // $query2 = $conn->prepare(
    //     'SELECT FORMAT(course_enrollement_num / ta_quota, 2) as ratio from Course_Quota WHERE course_num = ? AND term_year = ?'
    // );
    // $query2->bind_param('ss', $ta['course'], $term_year);
    // $query2->execute();
    // $res2 = $query2->get_result();
    // $user2 = $res2->fetch_assoc();

    echo '<tr>
    <td>' .
        $ta['courseNumber'] .
        '</td>
        <td>' .
        $ta['term'] .
        ' ' .
        $ta['year'] .
        '</td>
    <td>' .
        $user['course_type'] .
        '</td>
    <td>' .
        $user['course_enrollement_num'] .
        '   </td>
    <td>' .
        $user['ta_quota'] .
        '   </td>
        <td>' .
        $user['ratio'] .
        '   </td>
        <td style="color:rgb(167, 37, 48);">' .
        strtoupper($user['flagged']) .
        '   </td>

</tr>';
}

echo '</table> <br /><br />';

echo '<h3 style="color:rgb(167, 37, 48);" > TA Information </h3>';
echo '<table>';
echo '<tr>
    <th class="red-label">Email</th>
    <th class="red-label">Student ID</th>
    <th class="red-label">Name</th>
    <th class="red-label">Term & Year</th>
    <th class="red-label">Hours Assigned</th>
    </tr>';

if (mysqli_num_rows($result) == 0) {
    echo '</table>';
    echo '<p style="display:flex; 
                    justify-content:center;
                     align-item:center;
                     margin-top: 20px;
                     color: rgb(167, 37, 48);
                     font-weight: bold;
                     font-size: 18px;">' .
        $NotFound .
        '</p>';
}
while ($ta = $result->fetch_assoc()) {
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
        $ta['term'] .
        ' ' .
        $ta['years'] .
        '</td>
        <td>' .
        $ta['assigned_hours'] .
        '</td>

</tr>';
}

echo '</table>';

?>

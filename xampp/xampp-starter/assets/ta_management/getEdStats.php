<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
$NotFound = 'No Entry Found!';

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = $conn->prepare(
    'SELECT DISTINCT term_year, email, `name`, `role`, sis_id,enrolled FROM ed_stats'
);
$sql->execute();
$result = $sql->get_result();

echo '<table id="myTable">';
echo '<tr>

    <th class="red-label">Term & Year</th>
    <th class="red-label">Name & Email</th>
    <th class="red-label">Role</th>
    <th class="red-label">SIS ID</th>
    <th class="red-label">Enrolled</th>
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

$i = 1;

while ($ta = $result->fetch_assoc()) {
    echo '<tr>
    
    <td>' .
        $ta['term_year'] .
        '</td>
    <td>' .
        $ta['name'] .
        ': ' .
        $ta['email'] .
        '</td>

    <td>' .
        $ta['role'] .
        '</td>
    <td>' .
        $ta['sis_id'] .
        '</td>
        <td>' .
        $ta['enrolled'] .
        '</td>


</tr>';
}

$sql2 = $conn->prepare('SELECT * FROM ed_stats');
$sql2->execute();
$result2 = $sql2->get_result();

echo '</table> <br /> <br />';
echo '<table id="myTable">';
echo '<tr>

    <th class="red-label">Term & Year</th>
    <th class="red-label">Name</th>
    <th class="red-label">Questions</th>
    <th class="red-label">Posts</th>
    <th class="red-label">Announcements</th>
    <th class="red-label">Comments</th>
    <th class="red-label">Answers</th>
    <th class="red-label">Accepted Answers</th>
    <th class="red-label">Hearts</th>
    <th class="red-label">Endorsements</th>
    <th class="red-label">Declines</th>
    <th class="red-label">Declines Given</th>
    <th class="red-label">Days Active</th>
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

$i = 1;

while ($ta2 = $result2->fetch_assoc()) {
    echo '<tr>
    
    <td>' .
        $ta2['term_year'] .
        '</td>
    <td>' .
        $ta2['name'] .
        '</td>
    <td>' .
        $ta2['questions'] .
        '</td>
    <td>' .
        $ta2['posts'] .
        '   </td>
    <td>' .
        $ta2['announcements'] .
        '</td>
        <td>' .
        $ta2['comments'] .
        '</td>
        <td>' .
        $ta2['answers'] .
        '</td>
        <td>' .
        $ta2['accepted_answers'] .
        '</td>
        <td>' .
        $ta2['hearts'] .
        '</td>
        <td>' .
        $ta2['endorsements'] .
        '</td>
        <td>' .
        $ta2['declines'] .
        '</td>
        <td>' .
        $ta2['declines_given'] .
        '</td>
        <td>' .
        $ta2['days_active'] .
        '</td>


</tr>';
}
echo '</table> <br /> <br />';

?>

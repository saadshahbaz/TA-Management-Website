<?php
$servername = "localhost"; // Change accordingly
$username = "root"; // Change accordingly
$password = ""; // Change accordingly
$db = "xampp_starter"; // Change accordingly

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = $conn->prepare("SELECT * FROM Course");
$sql->execute();
$result = $sql->get_result();

echo '<table>';
echo'<tr>
    <th class="red-label">Course Number</th>
    <th class="red-label">Course Name</th>
    <th class="red-label">Course Description</th>
    <th class="red-label">Course Semester</th>
    <th class="red-label">Course Year</th>
    <th class="red-label">Course Instructor</th>
    </tr>';


while ($course = $result->fetch_assoc()) {

    // create comma-separated list of account types
    $query = $conn->prepare("SELECT * FROM User WHERE email = ?");
    $query->bind_param('s', $course['courseInstructor']);
    $query->execute();
    $res = $query->get_result();
    $user = $res->fetch_assoc();
    echo 
    '<tr>
        <td>'. $course['courseNumber'] .'</td>
        <td>'. $course['courseName'] .'</td>
        <td>'. $course['courseDesc'] .'</td>
        <td>'. $course['term'] .'</td>
        <td>'. $course['year'] .'</td>
        <td>'. $user['firstName'] . ' ' . $user['lastName'] . '</td>
    </tr>';
}

echo '</table>';
$conn->close();
?>
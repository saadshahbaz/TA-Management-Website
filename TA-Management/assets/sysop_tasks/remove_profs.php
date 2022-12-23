<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
// $conn = new mysqli($servername, $username, $password, $db);
// // Check connection
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

$instructor_email = $_POST['professor'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];
$course_number = $_POST['course'];

$sql = $conn->prepare('SELECT * FROM Professor WHERE professor = :email');
// $sql->bind_param('s', $email);
$sql->bindValue(':email', $instructor_email);
$result = $sql->execute();
// $result = $sql->get_result();
$user = $result->fetchArray();
$sql = $conn->prepare(
    'DELETE FROM Professor WHERE professor = :professor AND faculty = :faculty AND department = :department AND course = :course'
);
$sql->bindValue(':professor', $instructor_email);
$sql->bindValue(':faculty', $faculty);
$sql->bindValue(':department', $department);
$sql->bindValue(':course', $course_number);

// $sql->bind_param(
//     'ssss',
//     $instructor_email,
//     $faculty,
//     $department,
//     $course_number,
// );
$result = $sql->execute();
$conn->close();

if ($result) {
    echo '<p>Professor successfully removed!</p>';
} else {
    echo '<p>Professor could not removed...</p>';
}
?>

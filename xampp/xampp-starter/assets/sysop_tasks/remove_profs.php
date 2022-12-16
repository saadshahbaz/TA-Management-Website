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

$instructor_email = $_POST['professor'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];
$course_number = $_POST['course'];

$sql = $conn->prepare('SELECT * FROM Professor WHERE professor = ?');
$sql->bind_param('s', $email);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();
$sql = $conn->prepare(
'DELETE FROM Professor WHERE professor = ? AND faculty = ? AND department = ? AND course = ?'
);
$sql->bind_param(
    'ssss',
    $instructor_email,
    $faculty,
    $department,
    $course_number,
);
$result = $sql->execute();
$conn->close();

if ($result) {
    echo '<p>Professor successfully removed!</p>';
} else {
    echo '<p>Professor could not removed...</p>';
}
?>
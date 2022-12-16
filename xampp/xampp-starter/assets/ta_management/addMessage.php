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
session_start();
$email = $_SESSION['email'];
$course = $_POST['course'];
$term = $_POST['term'];
$year = $_POST['year'];
$time = $_POST['time'];
$message = $_POST['message'];
$tag = $_POST['tag'];
echo $tag;

$sql = $conn->prepare(
    'INSERT INTO message (user, course, term, year, time, message, tag) VALUES (?, ?, ?, ?, ?, ?, ?)'

);
$sql->bind_param(
    'sssssss',
    $email,
    $course,
    $term,
    $year,
    $time,
    $message,
    $tag
);
$result = $sql->execute();
$conn->close();
// }

if ($result) {
    echo '<p>Message successfully added!</p>';
} else {
    echo '<p>Message was not added...</p>';
}
?>


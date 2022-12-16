<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$email = $_POST['email'];
$term = $_POST['term'];
$course = $_POST['course'];

session_start();
$prof_email = $_SESSION['email'];

// GET prof user name

$sql1 = $conn->prepare('SELECT firstName,lastName FROM User WHERE email = ?');
$sql1->bind_param('s', $prof_email);
$sql1->execute();
$result = $sql1->get_result();
$user = $result->fetch_assoc();
$prof_name = $user['firstName'] . ' ' . $user['lastName'];

$sql2 = $conn->prepare('SELECT firstName,lastName FROM User WHERE email = ?');
$sql2->bind_param('s', $email);
$sql2->execute();
$result2 = $sql2->get_result();
$user2 = $result2->fetch_assoc();
$TA_name = $user2['firstName'] . ' ' . $user2['lastName'];

$sql = $conn->prepare(
    'INSERT INTO ta_wishlist (ta_email, term_year, course_num, prof_name, ta_name) VALUES (?, ?, ?, ?, ? )'
);
$sql->bind_param('sssss', $email, $term, $course, $prof_name, $TA_name);
$sql->execute();
$sql->close();

echo '<h4 style=
"color: rgb(237, 27, 47);display:flex;
justify-content: center;
align-items: center;"> Thank you for adding ' .
    $TA_name .
    ' to you wishlist!</h4>';
?>

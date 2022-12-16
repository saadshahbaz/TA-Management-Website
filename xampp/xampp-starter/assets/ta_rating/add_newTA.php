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

// echo '<p> Noice </p>'

$ta_email = $_POST['email'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];
$course_number = $_POST['course'];
$term = $_POST['term'];
$year = $_POST['year'];

$sql = $conn->prepare('SELECT * FROM TA WHERE email = ?');
$sql->bind_param('s', $email);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();

// if ($user) {
//     echo "<div class='error'>The Professor already exists.</div>";
//     $conn->close();
//     die();
// } else {
$hashed_pass = password_hash($password, PASSWORD_DEFAULT);
$sql = $conn->prepare(
    'INSERT INTO TA (email, faculty, department, course,term, years) VALUES (?, ?, ?, ?, ?, ?)'
);
$sql->bind_param(
    'ssssss',
    $ta_email,
    $faculty,
    $department,
    $course_number,
    $term,
    $year
);
$result = $sql->execute();
$conn->close();
// }

if ($result) {
    echo '<p>TA successfully added!</p>';
} else {
    echo '<p>TA was not added...</p>';
}
?>


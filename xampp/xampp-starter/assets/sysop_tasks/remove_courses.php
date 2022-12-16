<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// $conn = new mysqli($servername, $username, $password, $db);
// // Check connection
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

$course_number = $_POST['courseNumber'];
$course_term = $_POST['term'];
$course_year = $_POST['year'];
$course_instructor_email = $_POST['instrEmail'];

$sql = $conn->prepare(
    'SELECT * FROM Course WHERE term = :term AND year = :years AND courseNumber = :courseNumber AND courseInstructor = :courseInstructor'
);
// $sql->bind_param('ssss', $course_term, $course_year, $course_number, $email);
$sql->bindValue(':term', $course_term);
$sql->bindValue(':years', $course_year);
$sql->bindValue(':courseNumber', $course_number);
$sql->bindValue(':courseInstructor', $course_instructor_email);
$result = $sql->execute();
// $sql->execute();
// $result = $sql->get_result();
$user = $result->fetchArray();
$sql = $conn->prepare(
    'DELETE FROM COURSE WHERE term = :term AND year = :years AND courseNumber = :courseNumber AND courseInstructor = :courseInstructor'
);
// $sql->bind_param(
//     'ssss',
//     $course_term,
//     $course_year,
//     $course_number,
//     $course_instructor_email
// );
$sql->bindValue(':term', $course_term);
$sql->bindValue(':years', $course_year);
$sql->bindValue(':courseNumber', $course_number);
$sql->bindValue(':courseInstructor', $course_instructor_email);

$result = $sql->execute();
$conn->close();

if ($result) {
    echo '<p>Course successfully removed!</p>';
} else {
    echo '<p>Course could not be removed...</p>';
}
?>

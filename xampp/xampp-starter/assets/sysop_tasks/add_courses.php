<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

//Introduction to Databases including SQL, SCHEMAS ETC
// Create connection
// $conn = new mysqli($servername, $username, $password, $db);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

// define all fields to add to the database
$course_number = $_POST['courseNumber'];
$course_name = $_POST['courseName'];
$course_description = $_POST['courseDescription'];
$course_term = $_POST['term'];
$course_year = $_POST['year'];
$course_instructor_email = $_POST['instrEmail'];

$sql = $conn->prepare(
    'SELECT * FROM Course WHERE courseNumber = ? AND term = :term AND year = :years AND courseInstructor = :courseInstructor'
);
// $sql->bind_param('ssss', $course_number, $course_term, $course_year, $course_instructor_email);
$sql->bindValue(':term', $course_term);
$sql->bindValue(':years', $course_year);
$sql->bindValue(':courseNumber', $course_number);
$sql->bindValue(':courseInstructor', $course_instructor_email);

$result = $sql->execute();
// $result = $sql->get_result();
$course = $result->fetchArray();

if ($course) {
    echo "<div class='error'>The course already exists.</div>";
    $conn->close();
    die();
} else {
    $sql = $conn->prepare(
        'INSERT INTO Course (courseName, courseDesc, term, year, courseNumber, courseInstructor) VALUES (:courseName, :courseDesc, :term, :years,:courseNumber, :courseInstructor)'
    );
    // $sql->bind_param('ssssss', $course_name, $course_description, $course_term, $course_year, $course_number, $course_instructor_email);
    $sql->bindValue(':courseName', $course_name);
    $sql->bindValue(':courseDesc', $course_description);
    $sql->bindValue(':term', $course_term);
    $sql->bindValue(':years', $course_year);
    $sql->bindValue(':courseNumber', $course_number);
    $sql->bindValue(':courseInstructor', $course_instructor_email);

    $result = $sql->execute();
    $conn->close();
}

if ($result) {
    echo '<p>Course created successfully!</p>';
} else {
    echo '<p>Course creation failed...</p>';
}
?>

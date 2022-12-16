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

// define all fields to add to the database
$course_number = $_POST['courseNumber'];
$course_name = $_POST['courseName'];
$course_description = $_POST['courseDescription'];
$course_term = $_POST['term'];
$course_year = $_POST['year'];
$course_instructor_email = $_POST['instrEmail'];

$sql = $conn->prepare("SELECT * FROM Course WHERE courseNumber = ? AND term = ? AND year = ? AND courseInstructor = ?");
$sql->bind_param('ssss', $course_number, $course_term, $course_year, $course_instructor_email);
$sql->execute();
$result = $sql->get_result();
$course = $result->fetch_assoc();

if ($course) {
    echo "<div class='error'>The course already exists.</div>";
    $conn->close();
    die();
} else {
    $sql = $conn->prepare("INSERT INTO Course (courseName, courseDesc, term, year, courseNumber, courseInstructor) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param('ssssss', $course_name, $course_description, $course_term, $course_year, $course_number, $course_instructor_email);
    $result = $sql->execute();

    $query = $conn->prepare("SELECT * FROM Prof_Info WHERE email = ?");
    $query->bind_param('s', $course_instructor_email);
    $query->execute();
    $res = $query->get_result();
    $user = $res->fetch_assoc();
    $fac = $user['faculty'];
    $dep = $user['department'];



    $sql1 = $conn->prepare("INSERT INTO Professor (professor, faculty, department, course) VALUES (?, ?, ?, ?)");
    $sql1->bind_param('ssss', $course_instructor_email, $fac, $dep, $course_number);
    $sql1->execute();
    $conn->close();
}



if ($result) {
    echo "<p>Course created successfully!</p>";
} else {
    echo "<p>Course creation failed...</p>";
} 
?>
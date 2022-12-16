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
$instructor_email = $_POST['professor'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];
$course_number = $_POST['course'];

$sql = $conn->prepare("SELECT * FROM Professor WHERE professor = ?");
$sql->bind_param('s', $email);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo "<div class='error'>The Professor already exists.</div>";
    $conn->close();
    die();
} else {
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = $conn->prepare("INSERT INTO Professor (professor, faculty, department, course) VALUES (?, ?, ?, ?)");
    $sql->bind_param('ssss', $instructor_email, $faculty, $department, $course_number);
    $result = $sql->execute();

    $query = $conn->prepare("SELECT * FROM Course WHERE courseNumber = ?");
    $query->bind_param('s', $course_number);
    $query->execute();
    $res = $query->get_result();
    $thecourse = $res->fetch_assoc();

    $course_name = $thecourse['courseName'];
    $course_description = $thecourse['courseDesc'];
    $course_term = $thecourse['term'];
    $course_year = $thecourse['year'];

    $sql6 = $conn->prepare("INSERT INTO Course (courseName, courseDesc, term, year, courseNumber, courseInstructor) VALUES (?, ?, ?, ?, ?, ?)");
    $sql6->bind_param('ssssss', $course_name, $course_description, $course_term, $course_year, $course_number, $instructor_email);
    $sql6->execute();


    $conn->close();
}

if ($result) {
    echo "<p>Professor added successfully!</p>";
} else {
    echo "<p>Professor addition failed...</p>";
} 
?>
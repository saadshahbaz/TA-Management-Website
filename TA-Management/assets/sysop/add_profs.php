<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
// $conn = new mysqli($servername, $username, $password, $db);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

// define all fields to add to the database
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

if ($user) {
    echo "<div class='error'>The Professor already exists.</div>";
    $conn->close();
    die();
} else {
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = $conn->prepare(
        'INSERT INTO Professor (professor, faculty, department, course) VALUES (:professor, :faculty, :department, :course)'
    );
    // $sql->bind_param('ssss', $instructor_email, $faculty, $department, $course_number);
    $sql->bindValue(':professor', $instructor_email);
    $sql->bindValue(':faculty', $faculty);
    $sql->bindValue(':department', $department);
    $sql->bindValue(':course', $course_number);

    $result = $sql->execute();

    $query = $conn->prepare(
        'SELECT * FROM Course WHERE courseNumber = :courseNumber'
    );
    // $query->bind_param('s', $course_number);
    $query->bindValue(':courseNumber', $course_number);
    $res = $query->execute();
    // $res = $query->get_result();
    $thecourse = $res->fetchArray();

    $course_name = $thecourse['courseName'];
    $course_description = $thecourse['courseDesc'];
    $course_term = $thecourse['term'];
    $course_year = $thecourse['year'];

    $sql6 = $conn->prepare(
        'INSERT INTO Course (courseName, courseDesc, term, year, courseNumber, courseInstructor) VALUES (:courseName, :courseDesc, :term, :years, :courseNumber, :courseInstructor)'
    );
    $sql6->bindValue(':courseName', $course_name);
    $sql6->bindValue(':courseDesc', $course_description);
    $sql6->bindValue(':term', $course_term);
    $sql6->bindValue(':years', $course_year);
    $sql6->bindValue(':courseNumber', $course_number);
    $sql6->bindValue(':courseInstructor', $instructor_email);
    $result6 = $sql6->execute();

    $conn->close();
}

if ($result) {
    echo '<p>Professor added successfully!</p>';
} else {
    echo '<p>Professor addition failed...</p>';
}
?>

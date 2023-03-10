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
// Missing a lot of error checks
if (isset($_FILES['file'])) {
    $file_content = file($_FILES['file']['tmp_name']);
    foreach ($file_content as $row) {
        $items = explode(',', trim($row));
        $course_number = $items[4];
        $course_name = $items[0];
        $course_description = $items[1];
        $course_term = $items[2];
        $course_year = $items[3];
        $course_instructor_email = $items[5];

        $sql = $conn->prepare(
            'INSERT INTO Course (courseName, courseDesc, term, year, courseNumber, courseInstructor) VALUES (:courseName, :courseDesc, :term, :years, :courseNumber, :courseInstructor)'
        );
        // $sql->bind_param('ssssss', $course_name, $course_description, $course_term, $course_year, $course_number, $course_instructor_email);
        $sql->bindValue(':courseName', $course_name);
        $sql->bindValue(':courseDesc', $course_description);
        $sql->bindValue(':term', $course_term);
        $sql->bindValue(':years', $course_year);
        $sql->bindValue(':courseNumber', $course_number);
        $sql->bindValue(':courseInstructor', $course_instructor_email);

        $result = $sql->execute();
    }
}
$conn->close();
?>

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

if(isset($_FILES['file'])){
    $file_content = file($_FILES['file']['tmp_name']);
    foreach($file_content as $row) {
        $items = explode(",", trim($row));
        $instructor_email = $items[0];
        $faculty = $items[1];
        $department = $items[2];
        $course_number = $items[3];

        $sql = $conn->prepare("INSERT INTO Professor (professor, faculty, department, course) VALUES (?, ?, ?, ?)");
        $sql->bind_param('ssss', $instructor_email, $faculty, $department, $course_number);
        $result = $sql->execute();
    }
}
$conn->close();
?>
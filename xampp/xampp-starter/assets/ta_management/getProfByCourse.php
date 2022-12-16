<?php

$servername = "localhost"; // Change accordingly
$username = "root"; // Change accordingly
$password = ""; // Change accordingly
$db = "xampp_starter"; // Change accordingly

$conn = new mysqli($servername, $username, $password, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function getProf($year, $term, $course)
    {
        global $conn;
        $sql = $conn->prepare("SELECT * FROM Course WHERE year= ? AND term= ? AND courseNumber= ?");
        echo $course;
        echo $term;
        echo $year;
        $sql->bind_param('sss', $year, $term, $course);
        $sql->execute();
        $result = $sql->get_result();

        echo '<option value="" selected disabled> Select a Professor... </option>';
        while ($ta = $result->fetch_assoc()) {
            $sql2 = $conn->prepare("SELECT * FROM User WHERE email= ?");
            $sql2->bind_param('s', $ta['courseInstructor']);
            $sql2->execute();
            $result2 = $sql2->get_result();
            $user = $result2->fetch_assoc();
            echo '<option value="' .
                $ta['courseInstructor'] .
                '">' .
                $user['firstName'] .
                ' ' .
                $user['lastName'] .
                '</option>';
        };

        $conn->close();
    }

$term = $_GET['term'];
$year = $_GET['year'];
$course = $_GET['course'];

getProf($year, $term, $course);
    

<?php

$servername = "localhost"; // Change accordingly
$username = "root"; // Change accordingly
$password = ""; // Change accordingly
$db = "xampp_starter"; // Change accordingly

$conn = new mysqli($servername, $username, $password, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function getTA($year, $term, $course)
    {
        global $conn;
        $sql = $conn->prepare("SELECT * FROM TA WHERE years= ? AND term= ? AND course= ?");
        echo $course;
        echo $term;
        echo $year;
        $sql->bind_param('sss', $year, $term, $course);
        $sql->execute();
        $result = $sql->get_result();

        echo '<option value="" selected disabled> Select a TA... </option>';
        while ($ta = $result->fetch_assoc()) {
            $sql2 = $conn->prepare("SELECT * FROM User WHERE email= ?");
            $sql2->bind_param('s', $ta['email']);
            $sql2->execute();
            $result2 = $sql2->get_result();
            $user = $result2->fetch_assoc();
            echo '<option value="' .
                $ta['email'] .
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

getTA($year, $term, $course);
    

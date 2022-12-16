<?php

$servername = "localhost"; // Change accordingly
$username = "root"; // Change accordingly
$password = ""; // Change accordingly
$db = "xampp_starter"; // Change accordingly

$conn = new mysqli($servername, $username, $password, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function fillEmail($year, $term, $course, $role)
    {
        global $conn;
        
        if (strcmp($role, 'ta') == 0) {
            $sql = $conn->prepare("SELECT * FROM TA WHERE years= ? AND term= ? AND course= ?");
            $sql->bind_param('sss', $year, $term, $course);
        } else {
            $sql = $conn->prepare("SELECT * FROM Professor WHERE course= ?");
            $sql->bind_param('s', $course);
        }
        $sql->execute();
        $result = $sql->get_result();
        

       echo '<option value="" selected disabled> Select email... </option>';
        while ($ta = $result->fetch_assoc()) {
            $sql2 = $conn->prepare("SELECT * FROM User WHERE email= ?");
            if (strcmp($role, 'ta') == 0) {
                $sql2->bind_param('s', $ta['email']);
            } else {
                $sql2->bind_param('s', $ta['professor']);
            }
            $sql2->execute();
            $result2 = $sql2->get_result();
            $user = $result2->fetch_assoc();
            if (strcmp($role, 'ta') == 0) {
                echo '<option value="' .
                $ta['email'] .
                '">' .
                $ta['email'] .
                '</option>';
            }
            else {
                echo '<option value="' .
                $ta['professor'] .
                '">' .
                $ta['professor'] .
                '</option>';
            }
            
        };

        $conn->close();
    }

$term = $_GET['term'];
$year = $_GET['year'];
$course = $_GET['course'];
$role = $_GET['role'];

fillEmail($year, $term, $course, $role);
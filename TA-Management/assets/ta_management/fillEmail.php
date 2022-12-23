<?php

$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// $conn = new mysqli($servername, $username, $password, $db);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

function fillEmail($year, $term, $course, $role)
{
    global $conn;

    if (strcmp($role, 'ta') == 0) {
        $sql = $conn->prepare(
            'SELECT * FROM TA WHERE years= :years AND term= :term AND course= :course'
        );
        // $sql->bind_param('sss', $year, $term, $course);
        $sql->bindValue(':years', $year);
        $sql->bindValue(':term', $term);
        $sql->bindValue(':course', $course);
    } else {
        $sql = $conn->prepare('SELECT * FROM Professor WHERE course= :course');
        // $sql->bind_param('s', $course);
        $sql->bindValue(':course', $course);
    }
    $result = $sql->execute();
    // $result = $sql->get_result();

    echo '<option value="" selected disabled> Select email... </option>';
    while ($ta = $result->fetchArray()) {
        $sql2 = $conn->prepare('SELECT * FROM User WHERE email= :email');
        if (strcmp($role, 'ta') == 0) {
            // $sql2->bind_param('s', $ta['email']);
            $sql2->bindValue(':email', $ta['email']);
        } else {
            // $sql2->bind_param('s', $ta['professor']);
            $sql2->bindValue(':email', $ta['professor']);
        }
        $result2 = $sql2->execute();
        //$result2 = $sql2->get_result();
        $user = $result2->fetchArray();
        if (strcmp($role, 'ta') == 0) {
            echo '<option value="' .
                $ta['email'] .
                '">' .
                $ta['email'] .
                '</option>';
        } else {
            echo '<option value="' .
                $ta['professor'] .
                '">' .
                $ta['professor'] .
                '</option>';
        }
    }

    $conn->close();
}

$term = $_GET['term'];
$year = $_GET['year'];
$course = $_GET['course'];
$role = $_GET['role'];

fillEmail($year, $term, $course, $role);

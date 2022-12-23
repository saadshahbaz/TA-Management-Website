<?php

$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// $conn = new mysqli($servername, $username, $password, $db);

// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

function getProf($year, $term, $course)
{
    global $conn;
    $sql = $conn->prepare(
        'SELECT * FROM Course WHERE year= :years AND term= :term AND courseNumber= :courseNumber'
    );
    echo $course;
    echo $term;
    echo $year;
    // $sql->bind_param('sss', $year, $term, $course);
    $sql->bindValue(':years', $year);
    $sql->bindValue(':term', $term);
    $sql->bindValue(':courseNumber', $course);
    $result = $sql->execute();
    //$result = $sql->get_result();

    echo '<option value="" selected disabled> Select a Professor... </option>';
    while ($ta = $result->fetchArray()) {
        $sql2 = $conn->prepare('SELECT * FROM User WHERE email= :email');
        // $sql2->bind_param('s', $ta['courseInstructor']);
        $sql2->bindValue(':email', $ta['courseInstructor']);
        $result2 = $sql2->execute();

        $user = $result2->fetchArray();
        echo '<option value="' .
            $ta['courseInstructor'] .
            '">' .
            $user['firstName'] .
            ' ' .
            $user['lastName'] .
            '</option>';
    }

    $conn->close();
}

$term = $_GET['term'];
$year = $_GET['year'];
$course = $_GET['course'];

getProf($year, $term, $course);

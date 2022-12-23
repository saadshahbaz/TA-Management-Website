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

function getTA($year, $term, $course)
{
    global $conn;
    $sql = $conn->prepare(
        'SELECT * FROM TA WHERE years= :years AND term= :term AND course= :course'
    );
    echo $course;
    echo $term;
    echo $year;
    // $sql->bind_param('sss', $year, $term, $course);
    $sql->bindValue(':years', $year);
    $sql->bindValue(':term', $term);
    $sql->bindValue(':course', $course);

    $result = $sql->execute();
    // $result = $sql->get_result();

    echo '<option value="" selected disabled> Select a TA... </option>';
    while ($ta = $result->fetchArray()) {
        $sql2 = $conn->prepare('SELECT * FROM User WHERE email= :email');
        $sql2->bindValue(':email', $ta['email']);

        // $sql2->bind_param('s', $ta['email']);
        $result2 = $sql2->execute();
        //$result2 = $sql2->get_result();
        $user = $result2->fetchArray();
        echo '<option value="' .
            $ta['email'] .
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

getTA($year, $term, $course);

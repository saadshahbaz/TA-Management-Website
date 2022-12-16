<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// TODO: ADD CHECK IF THE USER ALREADY DID A REVIEW
session_start();
// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// echo '<p> Noice </p>'

$ta_email = $_POST['ta_email'];
$student_email = $_SESSION['email'];
$course_number = $_POST['course'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];
$year = $_POST['year'];
$term = $_POST['term'];

$conn = new mysqli($servername, $username, $password, $db);
$sql = $conn->prepare('SELECT * FROM User WHERE email = ?');
$sql->bind_param('s', $_SESSION['email']);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();

$sql = $conn->prepare("SELECT UserType.userType FROM UserType INNER JOIN User_UserType 
            ON UserType.idx=User_UserType.userTypeId WHERE User_UserType.userId = ?");
$sql->bind_param('s', $_SESSION['email']);
$sql->execute();
$result = $sql->get_result();
$userTypes = $result->fetch_all();

$username = $user[0] . ' ' . $user[1];

$userArray = [];

foreach ($userTypes as $userType) {
    array_push($userArray, $userType[0]);
}

if (
    in_array('sysop', $userArray) ||
    in_array('admin', $userArray) ||
    in_array('professor', $userArray) ||
    in_array('ta', $userArray) ||
    in_array('student', $userArray)
) {
    // $sql = $conn->prepare('SELECT * FROM TA WHERE email = ?');
    // $sql->bind_param('s', $email);
    // $sql->execute();
    // $result = $sql->get_result();
    // $user = $result->fetch_assoc();

    // if ($user) {
    //     echo "<div class='error'>The Professor already exists.</div>";
    //     $conn->close();
    //     die();
    // } else {

    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = $conn->prepare(
        'INSERT INTO TA_Ratings (student_email, ta_email, rating, Notes,course, term, years) VALUES (?, ?, ?, ?, ?, ?, ?)'
    );
    $sql->bind_param(
        'sssssss',
        $student_email,
        $ta_email,
        $rating,
        $comment,
        $course_number,
        $term,
        $year
    );
    try {
        $result = $sql->execute();
        $conn->close();
    } catch (Exception $e) {
        echo '<h4 style=
        "color: rgb(237, 27, 47);display:flex;
        justify-content: center;
        align-items: center;">You already submitted a review for ' .
            $ta_email .
            ' for ' .
            $course_number .
            ' for ' .
            $term .
            ' ' .
            $year .
            '</h4>';
        die();
    }

    echo '<h4 style=
    "color: rgb(237, 27, 47);display:flex;
    justify-content: center;
    align-items: center;"> Thank you for your feedback!</h4>';
    // // }
} else {
    echo '<h4 style=
    "color: rgb(237, 27, 47);display:flex;
    justify-content: center;
    align-items: center;">You are not allowed to access this page!</h4>';
}
?>


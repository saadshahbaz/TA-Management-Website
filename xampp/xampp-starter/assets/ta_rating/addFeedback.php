<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// TODO: ADD CHECK IF THE USER ALREADY DID A REVIEW
session_start();
// Create connection
// $conn = new mysqli($servername, $username, $password, $db);
// // Check connection
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }
$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);
// echo '<p> Noice </p>'

$ta_email = $_POST['ta_email'];
$student_email = $_SESSION['email'];
$course_number = $_POST['course'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];
$year = $_POST['year'];
$term = $_POST['term'];

// $conn = new mysqli($servername, $username, $password, $db);
$sql = $conn->prepare('SELECT * FROM User WHERE email = :email');
$sql->bindValue(':email', $student_email);
$result = $sql->execute();
// $result = $sql->get_result();
$user = $result->fetchArray();

$sql = $conn->prepare("SELECT UserType.userType FROM UserType INNER JOIN User_UserType 
            ON UserType.idx=User_UserType.userTypeId WHERE User_UserType.userId = :email");

$sql->bindValue(':email', $student_email);
// $sql->bind_param('s', $_SESSION['email']);
$result = $sql->execute();
// $result = $sql->get_result();
$userArray = [];
while ($userTypes = $result->fetchArray()) {
    $userArray[] = $userTypes['userType'];
}

$username = $user['firstName'] . ' ' . $user['lastName'];

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

    $sql = $conn->prepare(
        'SELECT * FROM TA_Ratings WHERE student_email = :student_email AND ta_email = :ta_email AND course = :course AND term = :term AND years = :years'
    );
    $sql->bindValue(':student_email', $student_email);
    $sql->bindValue(':ta_email', $ta_email);
    $sql->bindValue(':course', $course_number);
    $sql->bindValue(':term', $term);
    $sql->bindValue(':years', $year);
    $result = $sql->execute();

    $checkif = $result->fetchArray();
    if ($checkif) {
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
    } else {
        $sql = $conn->prepare(
            'INSERT INTO TA_Ratings (student_email, ta_email, rating, Notes,course, term, years) VALUES (:student_email, :ta_email, :rating, :Notes,:course, :term, :years)'
        );
        $sql->bindValue(':student_email', $student_email);
        $sql->bindValue(':ta_email', $ta_email);
        $sql->bindValue(':rating', $rating);
        $sql->bindValue(':Notes', $comment);
        $sql->bindValue(':course', $course_number);
        $sql->bindValue(':term', $term);
        $sql->bindValue(':years', $year);

        // $sql->bind_param(
        //     'sssssss',
        //     $student_email,
        //     $ta_email,
        //     $rating,
        //     $comment,
        //     $course_number,
        //     $term,
        //     $year
        // );
        $result = $sql->execute();
        $conn->close();

        echo '<h4 style=
        "color: rgb(237, 27, 47);display:flex;
        justify-content: center;
        align-items: center;"> Thank you for your feedback!</h4>';
    }

    // // }
} else {
    echo '<h4 style=
    "color: rgb(237, 27, 47);display:flex;
    justify-content: center;
    align-items: center;">You are not allowed to access this page!</h4>';
}
?>


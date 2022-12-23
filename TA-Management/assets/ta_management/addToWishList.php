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

$email = $_POST['email'];
$term = $_POST['term'];
$course = $_POST['course'];

session_start();
$prof_email = $_SESSION['email'];

// GET prof user name

$sql1 = $conn->prepare(
    'SELECT firstName,lastName FROM User WHERE email = :email'
);
// $sql1->bind_param('s', $prof_email);
$sql1->bindValue(':email', $prof_email);
$result = $sql1->execute();
// $result = $sql1->get_result();
$user = $result->fetchArray();
$prof_name = $user['firstName'] . ' ' . $user['lastName'];

$sql2 = $conn->prepare(
    'SELECT firstName,lastName FROM User WHERE email = :email'
);
// $sql2->bind_param('s', $email);
$sql2->bindValue(':email', $email);
$result2 = $sql2->execute();
// $result2 = $sql2->get_result();
$user2 = $result2->fetchArray();
$TA_name = $user2['firstName'] . ' ' . $user2['lastName'];

$sql3 = $conn->prepare(
    'SELECT * FROM ta_wishlist WHERE ta_email = :ta_email AND term_year = :term_year AND course_num = :course_num'
);
$sql3->bindValue(':ta_email', $email);
$sql3->bindValue(':term_year', $term);
$sql3->bindValue(':course_num', $course);

$result3 = $sql3->execute();
$test = $result3->fetchArray();

if ($test) {
    echo '<h4 style=
"color: rgb(237, 27, 47);display:flex;
justify-content: center;
align-items: center;"> You have already added ' .
        $TA_name .
        ' to your wishlist!</h4>';
    exit();
} else {
    $sql = $conn->prepare(
        'INSERT INTO ta_wishlist (ta_email, term_year, course_num, prof_name, ta_name) VALUES (:ta_email, :term_year, :course_num, :prof_name, :ta_name)'
    );
    // $sql->bind_param('sssss', $email, $term, $course, $prof_name, $TA_name);
    $sql->bindValue(':ta_email', $email);
    $sql->bindValue(':term_year', $term);
    $sql->bindValue(':course_num', $course);
    $sql->bindValue(':prof_name', $prof_name);
    $sql->bindValue(':ta_name', $TA_name);

    $sql->execute();
    $sql->close();

    echo '<h4 style=
    "color: rgb(237, 27, 47);display:flex;
    justify-content: center;
    align-items: center;"> Thank you for adding ' .
        $TA_name .
        ' to you wishlist!</h4>';
}

?>

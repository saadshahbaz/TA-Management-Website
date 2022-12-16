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
$comments = $_POST['comments'];
$time_stamp = date('Y-m-d H:i:s');

// get TA NAME
$sql2 = $conn->prepare(
    'SELECT firstName,lastName FROM User WHERE email = :email'
);
// $sql2->bind_param('s', $email);
$sql2->bindValue(':email', $email);
$result2 = $sql2->execute();
//$result2 = $sql2->get_result();
$user2 = $result2->fetchArray();
$TA_name = $user2['firstName'] . ' ' . $user2['lastName'];

$sql = $conn->prepare(
    'INSERT INTO ta_performance_log (ta_email, term_year, course_num, ta_name , comment, time_stamp) VALUES (:email, :term, :course, :TA_name, :comments, :time_stamp )'
);
// $sql->bind_param(
//     'ssssss',
//     $email,
//     $term,
//     $course,
//     $TA_name,
//     $comments,
//     $time_stamp
// );

$sql->bindValue(':email', $email);
$sql->bindValue(':term', $term);
$sql->bindValue(':course', $course);
$sql->bindValue(':TA_name', $TA_name);
$sql->bindValue(':comments', $comments);
$sql->bindValue(':time_stamp', $time_stamp);

$sql->execute();
$sql->close();

echo '<h4 style=
"color: rgb(237, 27, 47);display:flex;
justify-content: center;
align-items: center;"> Thank you for your feedback!</h4>';

?>

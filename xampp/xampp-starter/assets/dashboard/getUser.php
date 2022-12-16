<?php
//session_save_path('/home/2020/sshahb5/sessions');
session_start();
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);
// $sql = $conn->prepare('SELECT * FROM User WHERE email = ?');
// $sql->bind_param('s', $_SESSION['email']);
// $sql->execute();
// $result = $sql->get_result();
// $user = $result->fetch_assoc();

$sql = $conn->prepare('SELECT * FROM User WHERE email = :email');
$sql->bindValue(':email', $_SESSION['email']);
// $sql->bind_param('s', $_SESSION['email']);
$result = $sql->execute();
// $result = $sql->get_result();
$user = $result->fetchArray();

echo '<a
class="nav-item nav-link active"
style="color:rgb(167, 37, 48);"
data-toggle="tab"
href="#nav-profs"
role="tab"> Welcome, ' .
    $user['firstName'] .
    ' ' .
    $user['lastName'] .
    ' !</a>';

?>

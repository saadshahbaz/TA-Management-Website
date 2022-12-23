<?php
session_start();
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
// $conn = new mysqli($servername, $username, $password, $db);
$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);
$sql = $conn->prepare('SELECT * FROM User WHERE email = :email');
// $sql->bind_param('s', $_SESSION['email']);
$sql->bindValue(':email', $_SESSION['email']);
$result = $sql->execute();
//$result = $sql->get_result();
$user = $result->fetchArray();

echo '<p>From: ' . $user['firstName'] . ' ' . $user['lastName'];

?>

<?php
session_start();
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
$sql = $conn->prepare('SELECT * FROM User WHERE email = ?');
$sql->bind_param('s', $_SESSION['email']);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();

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

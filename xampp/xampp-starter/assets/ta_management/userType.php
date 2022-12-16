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

$sql = $conn->prepare("SELECT UserType.userType FROM UserType INNER JOIN User_UserType 
            ON UserType.idx=User_UserType.userTypeId WHERE User_UserType.userId = ?");
$sql->bind_param('s', $_SESSION['email']);
$sql->execute();
$result = $sql->get_result();
$userTypes = $result->fetch_all();
$conn->close();

$userArray = [];
foreach ($userTypes as $userType) {
    array_push($userArray, $userType[0]);
}

function ta()
{
    echo 'ta';
}

function professor()
{
    echo 'prof';
}

// echo '<p>' . userTypes[0] . ' </p>';

if (in_array('professor', $userArray) || in_array('admin', $userArray) || in_array('sysop', $userArray)) {
    professor();
} else {
    ta();
}

?>

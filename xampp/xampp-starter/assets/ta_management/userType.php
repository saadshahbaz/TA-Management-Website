<?php
session_start();

// $servername = 'localhost'; // Change accordingly
// $username = 'root'; // Change accordingly
// $password = ''; // Change accordingly
// $db = 'xampp_starter'; // Change accordingly

// // Create connection
// $conn = new mysqli($servername, $username, $password, $db);
$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);
$sql = $conn->prepare('SELECT * FROM User WHERE email = :email');
// $sql->bind_param('s', $_SESSION['email']);
$sql->bindValue(':email', $_SESSION['email']);
$result = $sql->execute();
// $result = $sql->get_result();
$user = $result->fetchArray();

$sql = $conn->prepare("SELECT UserType.userType FROM UserType INNER JOIN User_UserType 
            ON UserType.idx=User_UserType.userTypeId WHERE User_UserType.userId = :email");
// $sql->bind_param('s', $student_email);
$sql->bindValue(':email', $_SESSION['email']);
$result = $sql->execute();
// $result = $sql->get_result();
$userArray = [];
while ($userTypes = $result->fetchArray()) {
    $userArray[] = $userTypes['userType'];
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

if (
    in_array('professor', $userArray) ||
    in_array('admin', $userArray) ||
    in_array('sysop', $userArray)
) {
    professor();
} else {
    ta();
}

?>

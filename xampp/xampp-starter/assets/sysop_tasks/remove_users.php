<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// define all fields to add to the database
$email = $_POST['email'];
$account_types = $_POST['accounttypes'];

$sql = $conn->prepare('SELECT * FROM User WHERE email = ?');
$sql->bind_param('s', $email);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();

$sql1 = $conn->prepare('SELECT idx FROM userType WHERE userType = ?');
$sql1->bind_param('s', $account_types);
$sql1->execute();
$result2 = $sql1->get_result();
$user2 = $result2->fetch_assoc();

$sql = $conn->prepare(
    'DELETE FROM User_UserType WHERE userId = ? AND userTypeId = ?'
);
$sql->bind_param('ss', $email, $user2['idx']);

$result = $sql->execute();

// if user type empty string, d
$sql2 = $conn->prepare(
    'SELECT userId FROM User_UserType WHERE userId = ? AND userTypeId = ? '
);
$sql2->bind_param('ss', $email, $user2['idx']);
$sql2->execute();
$result3 = $sql2->get_result();
$user3 = $result3->fetch_assoc();

$working = 'user is empty';
//if (is_null($user3['userId']))
if (is_null($user3)) {
    $sql4 = $conn->prepare('DELETE FROM User WHERE email = ?');
    $sql4->bind_param('s', $email);
    $sql4->execute();
}

$conn->close();

if ($result) {
    echo '<p>User removed successfully!</p>';
} else {
    echo '<p>User removal failed...</p>';
}
?>


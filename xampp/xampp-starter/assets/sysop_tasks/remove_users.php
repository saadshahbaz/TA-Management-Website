<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
// $conn = new mysqli($servername, $username, $password, $db);
// // Check connection
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);
// define all fields to add to the database
$email = $_POST['email'];
$account_types = $_POST['accounttypes'];

$sql = $conn->prepare('SELECT * FROM User WHERE email = :email');
// $sql->bind_param('s', $email);
$sql->bindValue(':email', $email);
$result = $sql->execute();
// $result = $sql->get_result();
$user = $result->fetchArray();

$sql1 = $conn->prepare('SELECT idx FROM userType WHERE userType = :userType');
// $sql1->bind_param('s', $account_types);
$sql1->bindValue(':userType', $account_types);
$result2 = $sql1->execute();
// $result2 = $sql1->get_result();
$user2 = $result2->fetchArray();

$sql = $conn->prepare(
    'DELETE FROM User_UserType WHERE userId = :userID AND userTypeId = :userTypeId'
);
// $sql->bind_param('ss', $email, $user2['idx']);
$sql->bindValue(':userID', $email);
$sql->bindValue(':userTypeId', $user2['idx']);

$result = $sql->execute();

// if user type empty string, d
$sql2 = $conn->prepare(
    'SELECT userId FROM User_UserType WHERE userId = :userID AND userTypeId = :userTypeId '
);
// $sql2->bind_param('ss', $email, $user2['idx']);
$sql2->bindValue(':userID', $email);
$sql2->bindValue(':userTypeId', $user2['idx']);
$result3 = $sql2->execute();
// $result3 = $sql2->get_result();

$count = 0;

while ($row = $result3->fetchArray()) {
    $count++;
}
//if (is_null($user3['userId']))
if ($count == 0) {
    $sql4 = $conn->prepare('DELETE FROM User WHERE email = :email');
    // $sql4->bind_param('s', $email);
    $sql4->bindValue(':email', $email);
    $sql4->execute();
}

$conn->close();

if ($result) {
    echo '<p>User removed successfully!</p>';
} else {
    echo '<p>User removal failed...</p>';
}
?>


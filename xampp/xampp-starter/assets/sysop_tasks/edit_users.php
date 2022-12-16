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

$email = $_POST['email'];
$account_types = $_POST['accounttypes'];
$studentId = $_POST['studentId'];
$fac = $_POST['fac'];
$dep = $_POST['dep'];

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

if (!empty($studentId)) {
    $query = $conn->prepare('UPDATE User SET studentId = ? WHERE email = ?');
    $query->bind_param('ss', $studentId, $email);
    $query->execute();
}

$sql = $conn->prepare(
    'INSERT INTO User_UserType (userId, userTypeId) VALUES (?, ?)'
);
$sql->bind_param('si', $email, $user2['idx']);

$result = $sql->execute();

if (!empty($fac) and !empty($dep)) {
    $query = $conn->prepare('SELECT * FROM Prof_Info WHERE email = ?');
    $query->bind_param('s', $email);
    $query->execute();

    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if (empty($user)) {
        $query = $conn->prepare(
            'INSERT INTO Prof_Info (email, faculty, department) VALUES (?, ?, ?)'
        );
        $query->bind_param('sss', $email, $fac, $dep);
        $query->execute();
    } else {
        $query = $conn->prepare(
            'UPDATE Prof_Info SET faculty = ?, department = ? WHERE email = ?'
        );
        $query->bind_param('sss', $fac, $dep, $email);
        $query->execute();
    }
}
$conn->close();

// if ($result) {
//     echo "<p>User updated successfully!</p>";
// } else {
//     echo "<p>User update failed...</p>";
// }

?>

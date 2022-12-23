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

$email = $_POST['email'];
$account_types = $_POST['accounttypes'];
$studentId = $_POST['studentId'];
$fac = $_POST['fac'];
$dep = $_POST['dep'];

$sql = $conn->prepare('SELECT * FROM User WHERE email = :email');
// $sql->bind_param('s', $email);
$sql->bindValue(':email', $email);
$result = $sql->execute();
// $result = $sql->get_result();
$user = $result->fetchArray();

$sql1 = $conn->prepare('SELECT idx FROM userType WHERE userType = :userType');
$sql1->bindValue(':userType', $account_types);
// $sql1->bind_param('s', $account_types);
$result2 = $sql1->execute();
// $result2 = $sql1->get_result();
$user2 = $result2->fetchArray();

if (!empty($studentId)) {
    $query = $conn->prepare(
        'UPDATE User SET studentId = :studentId WHERE email = :email'
    );
    // $query->bind_param('ss', $studentId, $email);
    $query->bindValue(':studentId', $studentId);
    $query->bindValue(':email', $email);
    $query->execute();
}

$sql = $conn->prepare(
    'INSERT INTO User_UserType (userId, userTypeId) VALUES (:email, :userTypeId)'
);
$sql->bindValue(':email', $email);
$sql->bindValue(':userTypeId', $user2['idx']);
// $sql->bind_param('si', $email, $user2['idx']);

$result = $sql->execute();

if (!empty($fac) and !empty($dep)) {
    $query = $conn->prepare('SELECT * FROM Prof_Info WHERE email = :email');
    // $query->bind_param('s', $email);
    $query->bindValue(':email', $email);
    $result = $query->execute();

    // $result = $query->get_result();
    $user = $result->fetchArray();

    if (empty($user)) {
        $query = $conn->prepare(
            'INSERT INTO Prof_Info (email, faculty, department) VALUES (:email, :faculty, :department)'
        );
        // $query->bind_param('sss', $email, $fac, $dep);
        $query->bindValue(':email', $email);
        $query->bindValue(':faculty', $fac);
        $query->bindValue(':department', $dep);
        $query->execute();
    } else {
        $query = $conn->prepare(
            'UPDATE Prof_Info SET faculty = :faculty, department = :department WHERE email = :email'
        );
        $query->bindValue(':faculty', $fac);
        $query->bindValue(':department', $dep);
        $query->bindValue(':email', $email);
        // $query->bind_param('sss', $fac, $dep, $email);
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

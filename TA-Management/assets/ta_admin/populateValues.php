<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// $conn = new mysqli($servername, $username, $password, $db);

// // Check connection
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }
$action = $_GET['actions'];
$email = $_GET['email'];
$id_name = $_GET['id_name'];

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

if ($action == 'studentID') {
    $sql = $conn->prepare(
        'SELECT DISTINCT studentId FROM user where email = :email'
    );
    $sql->bindValue(':email', $email);
    $result = $sql->execute();

    $ta = $result->fetchArray();

    echo '<input class="form-control" placeholder="' .
        $ta['studentId'] .
        '" value="' .
        $ta['studentId'] .
        '" type="text" name="ta-student-id" id="ta-student-' .
        $id_name .
        '" disabled/><br />';
    $sql->close();
} elseif ($action == 'name') {
    $sql = $conn->prepare(
        'SELECT DISTINCT firstName, lastName FROM user where email = :email'
    );
    $sql->bindValue(':email', $email);
    $result = $sql->execute();

    $ta = $result->fetchArray();

    echo '<input class="form-control" placeholder="' .
        $ta['firstName'] .
        ' ' .
        $ta['lastName'] .
        '" value="' .
        $ta['firstName'] .
        ' ' .
        $ta['lastName'] .
        '" type="text" name="ta-name" id="ta-name-' .
        $id_name .
        '"  disabled/><br />';
    $sql->close();
}

?>

<?php
$servername = "localhost"; // Change accordingly
$username = "root"; // Change accordingly
$password = ""; // Change accordingly
$db = "xampp_starter"; // Change accordingly

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// define all fields to add to the database
$password = $_POST['password'];
$hashed_pass = password_hash($password, PASSWORD_DEFAULT);
$email = $_POST['email'];
$first_name = $_POST['firstname'];
$last_name = $_POST['lastname'];
$usernamezort = $_POST['usernamezort'];
$studentId = $_POST['studentId'];
$fac = $_POST['fac'];
$dep = $_POST['dep'];
$account_types = $_POST['accounttypes'];
$account_types = json_decode($account_types, true); // convert JSON to array of account types

$sql = $conn->prepare("SELECT * FROM User WHERE email = ?");
$sql->bind_param('s', $email);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo "<div class='error'>The username already exists.</div>";
    $conn->close();
    die();
} else {
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = $conn->prepare("INSERT INTO User (firstName, lastName, email, password, username, studentId) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param('ssssss', $first_name, $last_name, $email, $hashed_pass, $usernamezort, $studentId);

    $sql4 = $conn->prepare("INSERT INTO Prof_Info (email, faculty, department) VALUES (?, ?, ?)");
    $sql4->bind_param('sss', $email, $fac, $dep);
    $sql4->execute();

    if ($sql->execute()) {
        foreach ($account_types as $account_type) {
            $user_type_sql = $conn->prepare("INSERT INTO User_UserType (userId, userTypeId) VALUES (?, ?)");
            $user_type_sql->bind_param('si', $email, $account_type);
            $user_type_sql->execute();
        }
    }
    $conn->close();
}

if ($result) {
    echo "<p>User created successfully!</p>";
} else {
    echo "<p>User creation failed...</p>";
} 
?>
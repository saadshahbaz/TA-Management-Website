<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
// $conn = new mysqli($servername, $username, $password, $db);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

// define all fields to add to the database
$password = $_POST['password'];
$hashed_pass = password_hash($password, PASSWORD_DEFAULT);
$email = $_POST['email'];
$first_name = $_POST['firstname'];
$last_name = $_POST['lastname'];
$usernamezort = $_POST['usernamezort'];
$account_types = $_POST['accounttypes'];
$account_types = json_decode($account_types, true); // convert JSON to array of account types

$sql = $conn->prepare('SELECT * FROM User WHERE email = :email');
$sql->bindValue(':email', $email);
// $sql->bind_param('s', $email);
$result = $sql->execute();
// $result = $sql->get_result();
$user = $result->fetchArray();

if ($user) {
    echo "<div class='error'>The username already exists.</div>";
    $conn->close();
    die();
} else {
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = $conn->prepare(
        'INSERT INTO User (firstName, lastName, email, password, username) VALUES (:firstName, :lastName, :email, :passwords, :username)'
    );
    $sql->bindValue(':firstName', $first_name);
    $sql->bindValue(':lastName', $last_name);
    $sql->bindValue(':email', $email);
    $sql->bindValue(':passwords', $hashed_pass);
    $sql->bindValue(':username', $usernamezort);

    // $sql->bind_param('sssss', $first_name, $last_name, $email, $hashed_pass, $usernamezort);
    if ($sql->execute()) {
        foreach ($account_types as $account_type) {
            $user_type_sql = $conn->prepare(
                'INSERT INTO User_UserType (userId, userTypeId) VALUES (:userId, :userTypeId)'
            );
            $user_type_sql->bindValue(':userId', $email);
            $user_type_sql->bindValue(':userTypeId', $account_type);
            // $user_type_sql->bind_param('si', $email, $account_type);
            $user_type_sql->execute();
        }
    }
    $conn->close();
}

if ($result) {
    echo '<p>User created successfully!</p>';
} else {
    echo '<p>User creation failed...</p>';
}
?>

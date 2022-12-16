<?php

// Nice resource for PHP & MySQL: https://phpdelusions.net/mysqli

$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
$conn = new SQLite3(
    '../assets/database/ta_management.db',
    SQLITE3_OPEN_READWRITE
);

$email = $_POST['email'];
$sql = $conn->prepare('SELECT * FROM User WHERE email = :email');
$sql->bindValue(':email', $email);
// $sql->bind_param('s', $email);
$result = $sql->execute();
// $result = $sql->get_result();
$user = $result->fetchArray();
$conn->close();

if ($user) {
    // retrieve password from database
    $hashed_pass = $user['password'];
    // check against the user input password
    $login_success = password_verify($_POST['password'], $hashed_pass);
    if ($login_success) {
        session_start();
        $_SESSION['email'] = $email;
        echo "<script>function redirect() { 
                window.location.replace('../assets/dashboard/dashboard.html'); 
            }</script>";
    } else {
        echo '<text style="color: #FF0000;">Incorrect Password!</text>';
    }
} else {
    echo '<text style="color: #FF0000;">Username does not exist.</text>';
    return;
}
?>

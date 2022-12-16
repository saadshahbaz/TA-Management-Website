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

function user_role_id_map($role)
{
    $user_roles = [
        1 => 'student',
        2 => 'professor',
        3 => 'ta',
        4 => 'admin',
        5 => 'sysop',
    ];
    $key = array_search($role, $user_roles);
    return $key;
}

// Missing a lot of error checks
if (isset($_FILES['file'])) {
    $file_content = file($_FILES['file']['tmp_name']);
    foreach ($file_content as $row) {
        $items = explode(',', trim($row));
        $first_name = $items[0];
        $last_name = $items[1];
        $email = $items[2];
        $password = $items[3];

        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
        $account_types = explode('/', $items[4]);
        $account_types = array_map('user_role_id_map', $account_types);
        $sql = $conn->prepare(
            'INSERT INTO User (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :passwords)'
        );
        // $sql->bind_param('ssss', $first_name, $last_name, $email, $hashed_pass);
        $sql->bindValue(':firstName', $first_name);
        $sql->bindValue(':lastName', $last_name);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':passwords', $hashed_pass);

        if ($sql->execute()) {
            foreach ($account_types as $account_type) {
                $user_type_sql = $conn->prepare(
                    'INSERT INTO User_UserType (userId, userTypeId) VALUES (:userId, :userTypeId)'
                );
                // $user_type_sql->bind_param('si', $email, $account_type);
                $user_type_sql->bindValue(':userId', $email);
                $user_type_sql->bindValue(':userTypeId', $account_type);
                $user_type_sql->execute();
            }
        }
    }
}
$conn->close();
?>

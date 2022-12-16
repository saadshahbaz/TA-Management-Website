<?php

//session_save_path('/home/2020/sshahb5/sessions');
session_start();

echo '<p> Welcome: ' . $_SESSION['email'] . '</p>';

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

$sql = $conn->prepare('SELECT * FROM User WHERE email = :email');
$sql->bindValue(':email', $_SESSION['email']);
// $sql->bind_param('s', $_SESSION['email']);
$result = $sql->execute();
// $result = $sql->get_result();
$user = $result->fetchArray();

$sql = $conn->prepare("SELECT UserType.userType FROM UserType INNER JOIN User_UserType 
            ON UserType.idx=User_UserType.userTypeId WHERE User_UserType.userId = :email");
// $sql->bind_param('s', $_SESSION['email']);
$sql->bindValue(':email', $_SESSION['email']);
$result = $sql->execute();
// $result = $sql->get_result();
$userArray = [];
while ($userTypes = $result->fetchArray()) {
    $userArray[] = $userTypes['userType'];
}

$username = $user['firstName'] . ' ' . $user['lastName'];

function sysop()
{
    echo '<option value="" selected disabled>Select...</option>';
    echo '<option value="../dashboard/dashboard.html" >Dashboard</option>';
    echo '<option value="../sysop_tasks/dashboard.html" >System Operations</option>';
    echo '<option value="../ta_admin/dashboard.html" >TA Administration</option>';
    echo '<option value="../ta_management/dashboard.html" >TA Management</option>';
    echo '<option value="../ta_rating/dashboard.html" >TA Rating</option>';
}

function ta()
{
    echo '<option value="" selected disabled>Select...</option>';
    echo '<option value="../dashboard/dashboard.html" >Dashboard</option>';
    echo '<option value="../ta_management/dashboard.html" >TA Management</option>';
    echo '<option value="../ta_rating/dashboard.html" >TA Rating</option>';
}

function student()
{
    echo '<option value="" selected disabled>Select...</option>';
    echo '<option value="../dashboard/dashboard.html" >Dashboard</option>';
    echo '<option value="../ta_rating/dashboard.html" >TA Rating</option>';
}

function professor()
{
    echo '<option value="" selected disabled>Select...</option>';
    echo '<option value="../dashboard/dashboard.html" >Dashboard</option>';
    echo '<option value="../ta_management/dashboard.html" >TA Management</option>';
    echo '<option value="../ta_rating/dashboard.html" >TA Rating</option>';
}

function admin()
{
    echo '<option value="" selected disabled>Select...</option>';
    echo '<option value="../dashboard/dashboard.html" >Dashboard</option>';
    echo '<option value="../ta_admin/dashboard.html" >TA Administration</option>';
    echo '<option value="../ta_management/dashboard.html" >TA Management</option>';
    echo '<option value="../ta_rating/dashboard.html" >TA Rating</option>';
}
// echo '<p>' . userTypes[0] . ' </p>';
if (in_array('sysop', $userArray)) {
    sysop();
} elseif (in_array('admin', $userArray)) {
    admin();
} elseif (in_array('professor', $userArray)) {
    professor();
} elseif (in_array('ta', $userArray)) {
    ta();
} elseif (in_array('student', $userArray)) {
    student();
}

// We have 5 options
// 1. sysop
// 2. prof
// 3. student
// 4. admin
// 5. ta

?>

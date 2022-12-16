<?php
session_start();

echo '<p> Welcome: ' . $_SESSION['email'] . '</p>';

$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
$sql = $conn->prepare('SELECT * FROM User WHERE email = ?');
$sql->bind_param('s', $_SESSION['email']);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();

$sql = $conn->prepare("SELECT UserType.userType FROM UserType INNER JOIN User_UserType 
            ON UserType.idx=User_UserType.userTypeId WHERE User_UserType.userId = ?");
$sql->bind_param('s', $_SESSION['email']);
$sql->execute();
$result = $sql->get_result();
$userTypes = $result->fetch_all();
$conn->close();

$username = $user[0] . ' ' . $user[1];

$userArray = [];

foreach ($userTypes as $userType) {
    array_push($userArray, $userType[0]);
}

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

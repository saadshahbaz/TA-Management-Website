<?php
session_start();

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

$username = $user['firstName'] . ' ' . $user['lastName'];

$userArray = [];

foreach ($userTypes as $userType) {
    array_push($userArray, $userType[0]);
}

echo '<br /> <br /> <br /> <br /> <br />';

function sysop()
{
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href = \'../sysop_tasks/dashboard.html\'">
    <i class="fa fa-external-link"></i> System Operation </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_admin/dashboard.html\'">
    <i class="fa fa-external-link"></i> TA Administration </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_management/dashboard.html\'">
    <i class="fa fa-external-link"></i> TA Management </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_rating/dashboard.html\'">
    <i class="fa fa-external-link"></i> Rate a TA </button>';
}

function ta()
{
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_management/dashboard.html\'">
    <i class="fa fa-external-link"></i> TA Management </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_rating/dashboard.html\'">
    <i class="fa fa-external-link"></i> Rate a TA </button>';
}

function student()
{
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_rating/dashboard.html\'">
    <i class="fa fa-external-link"></i> Rate a TA </button>';
}

function professor()
{
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_management/dashboard.html\'">
    <i class="fa fa-external-link"></i> TA Management </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_rating/dashboard.html\'">
    <i class="fa fa-external-link"></i> Rate a TA </button>';
}

function admin()
{
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_admin/dashboard.html\'">
    <i class="fa fa-external-link"></i> TA Administration </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_management/dashboard.html\'">
    <i class="fa fa-external-link"></i> TA Management </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_rating/dashboard.html\'">
    <i class="fa fa-external-link"></i> Rate a TA </button>';
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

<?php
//session_save_path('/home/2020/sshahb5/sessions');
session_start();

$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
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
$sql->bindValue(':email', $user['email']);
$result = $sql->execute();
// $result = $sql->get_result();
$userArray = [];
while ($userTypes = $result->fetchArray()) {
    $userArray[] = $userTypes['userType'];
}

$username = $user['firstName'] . ' ' . $user['lastName'];

echo '<br /> <br /> <br /> <br /> <br />';

function sysop()
{
    // echo '<div class = "section" style="background-color:rgba(255,0,0,0.0);">';
    echo ' <div class="row">
    <div class="col-12 col-s-4 col-">';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href = \'../sysop_tasks/dashboard.html\'">
    <i class="fa fa-cog"></i> System Operation </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_admin/dashboard.html\'">
    <i class="fa fa-sliders"></i> TA Administration </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_management/dashboard.html\'">
    <i class="fa fa-book"></i> TA Management </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_rating/dashboard.html\'">
    <i class="fa fa-thumbs-up"></i> Rate a TA </button>';

    echo '</div> </div>';
}

function ta()
{
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_management/dashboard.html\'">
    <i class="fa fa-book"></i> TA Management </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_rating/dashboard.html\'">
    <i class="fa fa-thumbs-up"></i> Rate a TA </button>';
}

function student()
{
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_rating/dashboard.html\'">
    <i class="fa fa-external-link"></i> Rate a TA </button>';
}

function professor()
{
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_management/dashboard.html\'">
    <i class="fa fa-book"></i> TA Management </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_rating/dashboard.html\'">
    <i class="fa fa-thumbs-up"></i> Rate a TA </button>';
}

function admin()
{
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_admin/dashboard.html\'">
    <i class="fa fa-sliders"></i> TA Administration </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_management/dashboard.html\'">
    <i class="fa fa-book"></i> TA Management </button>';
    echo '<button type="button" class="btn btn-danger mr-4" data-toggle="modal" data-target="#import-profs" onclick="window.location.href =  \'../ta_rating/dashboard.html\'">
    <i class="fa fa-thumbs-up"></i> Rate a TA </button>';
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

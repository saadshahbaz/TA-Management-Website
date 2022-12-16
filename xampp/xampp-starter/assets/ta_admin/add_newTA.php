<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
$hashed_pass = password_hash($password, PASSWORD_DEFAULT);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// echo '<p> Noice </p>'

$ta_email = $_POST['email'];
$student_id = $_POST['student_id'];
$assigned_hours = $_POST['assigned_hours'];
$course_number = $_POST['course'];
$term = $_POST['term'];
$year = $_POST['year'];
$name = $_POST['name'];

if (
    empty($ta_email) ||
    empty($student_id) ||
    empty($assigned_hours) ||
    empty($course_number) ||
    empty($term) ||
    empty($year) ||
    empty($name)
) {
    echo '<p class="text-danger"> Please fill out all fields! </p>';
    $conn->close();
    die();
}

$sql1 = $conn->prepare(
    'SELECT * FROM TA WHERE email = ? AND term = ? and `years` = ? and course = ?'
);
$sql1->bind_param('ssss', $ta_email, $term, $year, $course_number);
$sql1->execute();
$result1 = $sql1->get_result();

if (mysqli_num_rows($result1) != 0) {
    echo '<p class="text-danger"> ' .
        $name .
        ' already exists! Please Try again!</p>';
    $conn->close();
    die();
} else {
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = $conn->prepare(
        'INSERT INTO TA (email, student_id, assigned_hours, ta_name ,course,term, years) VALUES (?, ?, ?, ?, ?, ?, ?)'
    );
    $sql->bind_param(
        'sssssss',
        $ta_email,
        $student_id,
        $assigned_hours,
        $name,
        $course_number,
        $term,
        $year
    );
    $result = $sql->execute();

    $userTypeID = 3;

    $sql2 = $conn->prepare(
        'SELECT * FROM User_UserType WHERE userId = ? AND userTypeId = ?'
    );
    $sql2->bind_param('si', $ta_email, $userTypeID);
    $sql2->execute();
    $result2 = $sql2->get_result();

    if (mysqli_num_rows($result2) == 0) {
        $sql1 = $conn->prepare(
            'INSERT INTO User_UserType (userId, userTypeId) VALUES (?, ?)'
        );
        $sql1->bind_param('si', $ta_email, $userTypeID);
        $result1 = $sql1->execute();
    }

    $conn->close();
    // }

    if ($result) {
        echo '<p class="text-success" >' .
            $name .
            ' was successfully added!</p>';
    } else {
        echo '<p class="text-danger" >TA was not added...</p>';
    }
}
?>


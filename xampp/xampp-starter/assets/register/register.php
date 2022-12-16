<?php
//creating connection
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

//getting data from the form
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$username = $_POST['username'];
$studentId = $_POST['studentId'];
$password = $_POST['password'];
$password_hashed = password_hash($password, PASSWORD_DEFAULT);
$t = $_POST['type'];
$types = explode(',', $t);
if (isset($_POST['course'])) {
    $c = $_POST['course'];
    $course = explode(',', $c);
    $arrayLength = count($course);
}
$userLength = count($types);
$userTypes = [];
$i = 0;
$j = 0;

//checking if all fields entered
if (
    empty($fname) ||
    empty($lname) ||
    empty($email) ||
    empty($password) ||
    empty($username)
) {
    echo '<text style="color: #FF0000;">Please fill in all fields.</text>';
    return;
}

//check if email already exists
$sql = $conn->prepare('SELECT * FROM User WHERE email = :email');
$sql->bindValue(':email', $email);
// $sql->bind_param('s', $email);
$result = $sql->execute();
// $result = $sql->get_result();
$user = $result->fetchArray();

if ($user) {
    echo '<text>Email already exists.</text>';
    die();
}

//add to users table
$sql = $conn->prepare(
    'INSERT INTO User (firstName, lastName, email, password, studentId, username) VALUES (:firstName, :lastName, :email, :passwords, :studentId, :username)'
);
$sql->bindValue(':firstName', $fname);
$sql->bindValue(':lastName', $lname);
$sql->bindValue(':email', $email);
$sql->bindValue(':passwords', $password_hashed);
$sql->bindValue(':studentId', $studentId);
$sql->bindValue(':username', $username);
// $sql->bind_param('ssssss', $fname, $lname, $email, $password_hashed, $studentId, $username);
$sql->execute();
$sql->close();
//add to user type table - can be multiple types
while ($j < $userLength) {
    $type = $types[$j];
    if (strcmp($type, 'Student') == 0) {
        $userTypeId = 1;
        $studentId = $_POST['studentId'];
    } elseif (strcmp($type, 'Professor') == 0) {
        $userTypeId = 2;
    } elseif (strcmp($type, 'TA') == 0) {
        $userTypeId = 3;
        $studentId = $_POST['studentId'];
    } elseif (strcmp($type, 'TA Administrator') == 0) {
        $userTypeId = 4;
    } elseif (strcmp($type, 'System Operator') == 0) {
        $userTypeId = 5;
    } else {
        echo 'Error: User type not found.';
        return;
    }
    $sql2 = $conn->prepare(
        'INSERT INTO User_UserType (userId, userTypeId) VALUES (:userID, :userTypeId)'
    );
    $sql2->bindValue(':userID', $email);
    $sql2->bindValue(':userTypeId', $userTypeId);

    // $sql2->bind_param('ss', $email, $userTypeId);
    $sql2->execute();
    $userTypes[] = $userTypeId;
    $j++;
}
$sql2->close();

// if student, add to student_course table for registered courses

if (in_array(1, $userTypes)) {
    while ($i < $arrayLength) {
        $courseId = $course[$i];
        $sql3 = $conn->prepare(
            'INSERT INTO Student_Course (studentId, courseId) VALUES (:studentId, :courseId)'
        );
        $sql3->bindValue(':studentId', $email);
        $sql3->bindValue(':courseId', $courseId);
        // $sql3->bind_param('ss', $email, $courseId);
        $sql3->execute();
        $i++;
    }
    $conn->close();
}

// if success, redirect to dashboard
session_start();
$_SESSION['email'] = $email;
echo "<script>window.location.replace('../dashboard/dashboard.html'); </script>";
?>

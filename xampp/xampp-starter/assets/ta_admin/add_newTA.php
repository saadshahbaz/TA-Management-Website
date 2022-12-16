<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);
// $conn = new mysqli($servername, $username, $password, $db);
// $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
// Check connection
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }

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
    'SELECT * FROM TA WHERE email = :emailValue AND term = :termValue and `years` = :yearValue and course = :courseValue'
);
// $sql1->bindParam('ssss', $ta_email, $term, $year, $course_number);
$sql1->bindValue(':emailValue', $ta_email);
$sql1->bindValue(':termValue', $term);
$sql1->bindValue(':yearValue', $year);
$sql1->bindValue(':courseValue', $course_number);

$result = $sql1->execute();
$number_of_rows = 0; //for now

while ($row = $result->fetchArray()) {
    $number_of_rows += 1;
}

if ($number_of_rows != 0) {
    echo '<p class="text-danger"> ' .
        $name .
        ' already exists! Please Try again!</p>';
    $conn->close();
    die();
} else {
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = $conn->prepare(
        'INSERT INTO TA (email, student_id, assigned_hours, ta_name ,course,term, years) VALUES (:email, :student_id, :assigned_hours, :ta_name ,:course,:term, :years)'
    );
    $sql->bindValue(':email', $ta_email);
    $sql->bindValue(':student_id', $student_id);
    $sql->bindValue(':assigned_hours', $assigned_hours);
    $sql->bindValue(':ta_name', $name);
    $sql->bindValue(':course', $course_number);
    $sql->bindValue(':term', $term);
    $sql->bindValue(':years', $year);

    // $sql->bindParam(
    //     'sssssss',
    //     $ta_email,
    //     $student_id,
    //     $assigned_hours,
    //     $name,
    //     $course_number,
    //     $term,
    //     $year
    // );
    $result = $sql->execute();

    $userTypeID = 3;

    $sql2 = $conn->prepare(
        'SELECT * FROM User_UserType WHERE userId = :userID AND userTypeId = :userTypeID'
    );
    $sql2->bindValue(':userID', $ta_email);
    $sql2->bindValue(':userTypeID', $userTypeID);
    // $sql2->bindParam('si', $ta_email, $userTypeID);
    $results = $sql2->execute();
    $number_of_rows = 0; //for now

    while ($row = $results->fetchArray()) {
        $number_of_rows += 1;
    }

    if ($number_of_rows == 0) {
        $sql1 = $conn->prepare(
            'INSERT INTO User_UserType (userId, userTypeId) VALUES (:userID, :userTypeID)'
        );
        $sql1->bindValue(':userID', $ta_email);
        $sql1->bindValue(':userTypeID', $userTypeID);
        // $sql1->bindParam('si', $ta_email, $userTypeID);
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



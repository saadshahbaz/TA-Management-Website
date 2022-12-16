<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

$ta_email = $_POST['email'];
$student_id = $_POST['student_id'];
$name = $_POST['name'];
$course_number = $_POST['course'];
$term = $_POST['term'];
$year = $_POST['year'];

if (
    empty($ta_email) ||
    empty($student_id) ||
    empty($course_number) ||
    empty($term) ||
    empty($year) ||
    empty($name)
) {
    echo '<p class="text-danger"> Please fill out all fields! </p>';
    $conn->close();
    die();
}

$sql = $conn->prepare(
    'DELETE FROM TA WHERE email = :email AND student_id = :studentID AND ta_name = :ta_name AND course = :course AND term = :term AND years = :years'
);
$sql->bindValue(':email', $ta_email);
$sql->bindValue(':studentID', $student_id);
$sql->bindValue(':ta_name', $name);
$sql->bindValue(':course', $course_number);
$sql->bindValue(':term', $term);
$sql->bindValue(':years', $year);
// $sql->bind_param(
//     'ssssss',
//     $ta_email,
//     $student_id,
//     $name,
//     $course_number,
//     $term,
//     $year
// );
$result = $sql->execute();

$userTypeID = 3;

$sql1 = $conn->prepare('SELECT * FROM TA WHERE email = :email');
$sql1->bindValue(':email', $ta_email);
// $sql1->bind_param('s', $ta_email);
$result1 = $sql1->execute();

$number_of_rows = 0; //for now

while ($row = $result1->fetchArray()) {
    $number_of_rows += 1;
}
// $result1 = $sql1->get_result();

if ($number_of_rows == 0) {
    echo '<p>' . $entered . '</p>';
    $sql2 = $conn->prepare(
        'SELECT * FROM User_UserType WHERE userId = :userID AND userTypeId = :userTypeId'
    );
    $sql2->bindValue(':userID', $ta_email);
    $sql2->bindValue(':userTypeId', $userTypeID);
    // $sql2->bind_param('si', $ta_email, $userTypeID);
    $result2 = $sql2->execute();
    // $result2 = $sql2->get_result();
    $number_of_rows = 0; //for now

    while ($row = $result2->fetchArray()) {
        $number_of_rows += 1;
    }
    if ($number_of_rows == 0) {
        $sql1 = $conn->prepare(
            'DELETE FROM User_UserType where userId = :userID AND userTypeId = :userTypeId'
        );
        $sql1->bindValue(':userID', $ta_email);
        $sql1->bindValue(':userTypeId', $userTypeID);
        $result1 = $sql1->execute();
    }
}

$conn->close();

if ($result) {
    echo '<p class="text-success" >' . $name . ' was successfully Removed!</p>';
} else {
    echo '<p class="text-danger" >TA was not Removed...</p>';
}
?>



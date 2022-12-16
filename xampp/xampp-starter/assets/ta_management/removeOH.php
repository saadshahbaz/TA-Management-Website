<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
// $conn = new mysqli($servername, $username, $password, $db);
// // Check connection
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }
$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

$email = $_POST['email'];
$location = $_POST['location'];
$day = $_POST['day'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$courseNumber = $_POST['courseNumber'];
$term = $_POST['term'];
$year = $_POST['year'];
$position = $_POST['position'];
$responsibilities = $_POST['responsibilities'];

echo $email;
echo $location;
echo $day;
echo $start_time;
echo $end_time;
echo $courseNumber;
echo $term;
echo $year;
echo $position;
echo $responsibilities;

$sql = $conn->prepare(
    'DELETE FROM OfficeHours WHERE email = :email AND location = :locations AND day = :dayss AND start_time = :start_time AND end_time = :end_time AND course = :course AND term = :term AND year = :years AND position = :position AND responsibilities = :responsibilities'
);
// $sql->bind_param(
//     'ssssssssss',
//     $email,
//     $location,
//     $day,
//     $start_time,
//     $end_time,
//     $courseNumber,
//     $term,
//     $year,
//     $position,
//     $responsibilities
// );
$sql->bindValue(':email', $email);
$sql->bindValue(':locations', $location);
$sql->bindValue(':dayss', $day);
$sql->bindValue(':start_time', $start_time);
$sql->bindValue(':end_time', $end_time);
$sql->bindValue(':course', $courseNumber);
$sql->bindValue(':term', $term);
$sql->bindValue(':years', $year);
$sql->bindValue(':position', $position);
$sql->bindValue(':responsibilities', $responsibilities);

$result = $sql->execute();
$conn->close();

if ($result) {
    echo '<p>OH successfully removed!</p>';
} else {
    echo '<p>OH was not added...</p>';
}
?>

<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

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
    'DELETE FROM OfficeHours WHERE email = ? AND location = ? AND day = ? AND start_time = ? AND end_time = ? AND course = ? AND term = ? AND year = ? AND position = ? AND responsibilities = ?'
);
$sql->bind_param(
    'ssssssssss',
    $email,
    $location,
    $day,
    $start_time,
    $end_time,
    $courseNumber,
    $term,
    $year,
    $position,
    $responsibilities
);
$result = $sql->execute();
$conn->close();

if ($result) {
    echo '<p>OH successfully removed!</p>';
} else {
    echo '<p>OH was not added...</p>';
}
?>

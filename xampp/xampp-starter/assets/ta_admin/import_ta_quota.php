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

$target_dir = 'csvs/';
$file = $_FILES['file']['name'];
$path = pathinfo($file);
$filename = $path['filename'];
$ext = $path['extension'];
$temp_name = $_FILES['file']['tmp_name'];

$path_filename_ext = $target_dir . $filename . '.' . $ext;
move_uploaded_file($temp_name, $path_filename_ext);
$ta_cohort = fopen($path_filename_ext, 'r');
$noice = fgetcsv($ta_cohort);

$sql0 = $conn->prepare('DELETE FROM Course_Quota');
$result0 = $sql0->execute();

while (($items = fgetcsv($ta_cohort)) != false) {
    $term_year = $items[0];
    $course_num = $items[1];
    $course_type = $items[2];
    $course_name = $items[3];
    $instructor_name = $items[4];
    $course_enrollement_num = $items[5];
    $ta_quota = $items[6];
    $ratio = $course_enrollement_num / $ta_quota;

    echo '<p>' . $ratio . '</p>';

    $flagged = 'false';

    if ($ratio < 30 or $ratio > 45) {
        $flagged = 'true';
    }

    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    $sql = $conn->prepare(
        'INSERT INTO Course_Quota (term_year, course_num, course_type, course_name, instructor_name, course_enrollement_num, ta_quota, ratio, flagged) VALUES (:term_year, :course_num, :course_type, :course_name, :instructor_name, :course_enrollement_num, :ta_quota, :ratio, :flagged)'
    );

    $sql->bindValue(':term_year', $term_year);
    $sql->bindValue(':course_num', $course_num);
    $sql->bindValue(':course_type', $course_type);
    $sql->bindValue(':course_name', $course_name);
    $sql->bindValue(':instructor_name', $instructor_name);
    $sql->bindValue(':course_enrollement_num', $course_enrollement_num);
    $sql->bindValue(':ta_quota', $ta_quota);
    $sql->bindValue(':ratio', $ratio);
    $sql->bindValue(':flagged', $flagged);

    // $sql->bind_param(
    //     'sssssssss',
    //     $term_year,
    //     $course_num,
    //     $course_type,
    //     $course_name,
    //     $instructor_name,
    //     $course_enrollement_num,
    //     $ta_quota,
    //     $ratio,
    //     $flagged
    // );
    $result = $sql->execute();
}

fclose($ta_cohort);

$conn->close();
?>

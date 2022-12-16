<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
// $conn = new mysqli($servername, $username, $password, $db);
$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);
// Check connection
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }

$target_dir = 'csvs/';
$file = $_FILES['file']['name'];
$path = pathinfo($file);
$filename = $path['filename'];
$ext = $path['extension'];
$temp_name = $_FILES['file']['tmp_name'];

$sql0 = $conn->prepare('DELETE FROM TA_COHORT');
$result0 = $sql0->execute();

$path_filename_ext = $target_dir . $filename . '.' . $ext;
move_uploaded_file($temp_name, $path_filename_ext);
$ta_cohort = fopen($path_filename_ext, 'r');
$noice = fgetcsv($ta_cohort);

while (($items = fgetcsv($ta_cohort)) != false) {
    $term_year = $items[0];
    $ta_name = $items[1];
    $student_id = $items[2];
    $legal_name = $items[3];
    $email = $items[4];
    $grad_ugrad = $items[5];
    $supervisor_name = $items[6];
    $priority = $items[7];
    $hours = $items[8];
    $date_applied = $items[9];
    $location = $items[10];
    $phone = $items[11];
    $degree = $items[12];
    $course_applied = $items[13];
    $open_to_other_courses = $items[14];
    $Notes = $items[15];

    echo '<p>' . $term_year . '</p>';

    // $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = $conn->prepare(
        'INSERT INTO TA_COHORT (term_year, ta_name, student_id, legal_name, email, grad_ugrad, supervisor_name, priority, hours_allocated, date_applied,location_assigned, phone, degree, course_applied, open_to_other_courses, Notes) VALUES (:term_year, :ta_name, :student_id, :legal_name, :email, :grad_ugrad, :supervisor_name, :priority, :hours_allocated, :date_applied,:location_assigned, :phone, :degree, :course_applied, :open_to_other_courses, :Notes)'
    );
    echo '<p>' . $term_year . '</p>';
    echo '<p>' . $ta_name . '</p>';
    echo '<p>' . $student_id . '</p>';
    echo '<p>' . $legal_name . '</p>';
    echo '<p>' . $grad_ugrad . '</p>';
    echo '<p>' . $supervisor_name . '</p>';
    echo '<p>' . $priority . '</p>';
    echo '<p>' . $hours . '</p>';
    echo '<p>' . $date_applied . '</p>';
    echo '<p>' . $location . '</p>';
    echo '<p>' . $phone . '</p>';
    echo '<p>' . $degree . '</p>';
    echo '<p>' . $course_applied . '</p>';
    echo '<p>' . $open_to_other_courses . '</p>';
    echo '<p>' . $Notes . '</p>';

    $sql->bindParam(':term_year', $term_year);
    $sql->bindParam(':ta_name', $ta_name);
    $sql->bindParam(':student_id', $student_id);
    $sql->bindParam(':legal_name', $legal_name);
    $sql->bindParam(':email', $email);
    $sql->bindParam(':grad_ugrad', $grad_ugrad);
    $sql->bindParam(':supervisor_name', $supervisor_name);
    $sql->bindParam(':priority', $priority);
    $sql->bindParam(':hours_allocated', $hours);
    $sql->bindParam(':date_applied', $date_applied);
    $sql->bindParam(':location_assigned', $location);
    $sql->bindParam(':phone', $phone);
    $sql->bindParam(':degree', $degree);
    $sql->bindParam(':course_applied', $course_applied);
    $sql->bindParam(':open_to_other_courses', $open_to_other_courses);
    $sql->bindParam(':Notes', $Notes);

    // $sql->bind_param(
    //     'ssssssssssssssss',
    //     $term_year,
    //     $ta_name,
    //     $student_id,
    //     $legal_name,
    //     $email,
    //     $grad_ugrad,
    //     $supervisor_name,
    //     $priority,
    //     $hours,
    //     $date_applied,
    //     $location,
    //     $phone,
    //     $degree,
    //     $course_applied,
    //     $open_to_other_courses,
    //     $Notes
    // );

    $result = $sql->execute();
}

fclose($ta_cohort);

$conn->close();
?>

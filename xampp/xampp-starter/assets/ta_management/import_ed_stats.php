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

$currentCourse = $_POST['course'];
$curentTermYear = $_POST['term'];

echo '<p>' . $currentCourse . '</p>';
echo '<p>' . $curentTermYear . '</p>';

$target_dir = 'csvs/';
$file = $_FILES['file']['name'];
$path = pathinfo($file);
$filename = $path['filename'];
$ext = $path['extension'];
$temp_name = $_FILES['file']['tmp_name'];

// $sql0 = $conn->prepare('DELETE FROM ed_stats');
// $result0 = $sql0->execute();

$path_filename_ext = $target_dir . $filename . '.' . $ext;
move_uploaded_file($temp_name, $path_filename_ext);
$ta_cohort = fopen($path_filename_ext, 'r');
$noice = fgetcsv($ta_cohort);

while (($items = fgetcsv($ta_cohort)) != false) {
    $term_year = $curentTermYear;
    $course = $currentCourse;
    $name = $items[0];
    $email = $items[1];
    $role = $items[2];
    $tutorial = $items[3];
    $sis_id = $items[4];
    $questions = $items[5];
    $posts = $items[6];
    $announcements = $items[7];
    $comments = $items[8];
    $answers = $items[9];
    $accepted_answers = $items[10];
    $hearts = $items[11];
    $endorsements = $items[12];
    $decline = $items[13];
    $declines_given = $items[14];
    $days_active = $items[15];
    $last_active = $items[16];
    $enrolled = $items[17];

    echo '<p>' . $term_year . '</p>';

    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = $conn->prepare(
        'INSERT INTO ed_stats (`course_num`, `term_year`,`name`, email, `role`, tutorial, sis_id, questions, posts, announcements, comments, answers, accepted_answers, hearts,endorsements, declines, declines_given, days_active, last_active, enrolled ) VALUES (?, ? , ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?)'
    );
    // echo '<p>' . $term_year . '</p>';
    // echo '<p>' . $ta_name . '</p>';
    // echo '<p>' . $student_id . '</p>';
    // echo '<p>' . $legal_name . '</p>';
    // echo '<p>' . $grad_ugrad . '</p>';
    // echo '<p>' . $supervisor_name . '</p>';
    // echo '<p>' . $priority . '</p>';
    // echo '<p>' . $hours . '</p>';
    // echo '<p>' . $date_applied . '</p>';
    // echo '<p>' . $location . '</p>';
    // echo '<p>' . $phone . '</p>';
    // echo '<p>' . $degree . '</p>';
    // echo '<p>' . $course_applied . '</p>';
    // echo '<p>' . $open_to_other_courses . '</p>';
    // echo '<p>' . $Notes . '</p>';

    $sql->bind_param(
        'ssssssssssssssssssss',
        $course,
        $term_year,
        $name,
        $email,
        $role,
        $tutorial,
        $sis_id,
        $questions,
        $posts,
        $announcements,
        $comments,
        $answers,
        $accepted_answers,
        $hearts,
        $endorsements,
        $decline,
        $declines_given,
        $days_active,
        $last_active,
        $enrolled
    );

    $result = $sql->execute();
}

fclose($ta_cohort);

$conn->close();
?>

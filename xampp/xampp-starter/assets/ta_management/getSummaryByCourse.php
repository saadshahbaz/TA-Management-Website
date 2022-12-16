<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

$entered = 'entered';
$NotFound = 'No Entry Found!';
// Create connection
// $conn = new mysqli($servername, $username, $password, $db);
// // Check connection
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }
$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);
$currentPost = $_POST['course'];
$currentTerm = $_POST['term'];
$currentYear = $_POST['year'];

$sql2 = $conn->prepare(
    'SELECT * FROM TA WHERE course=:course AND term=:term AND years=:years'
);
// $sql2->bind_param('sss', $currentPost, $currentTerm, $currentYear);
$sql2->bindValue(':course', $currentPost);
$sql2->bindValue(':term', $currentTerm);
$sql2->bindValue(':years', $currentYear);
$ta_details = $sql2->execute();
// $ta_details = $sql2->get_result();

// $ta2 = $ta_details->fetch_assoc();

echo '<h3 style="color:rgb(167, 37, 48);" > Previous Course Details  </h3>';
echo '<table>';
echo '<tr>
        <th class="red-label">TA Name</th>
        <th class="red-label">TA Email</th>
        <th class="red-label">Term & Year</th>
        <th class="red-label">Course Code</th>
        <th class="red-label">Course Name</th>
        <th class="red-label">Course Instructor</th>
        <th class="red-label">Assigned Hours</th>

        </tr>';

while ($ta2 = $ta_details->fetchArray()) {
    // We need course information
    $sql3 = $conn->prepare(
        'SELECT * FROM course WHERE courseNumber=:courseNumber AND term=:term AND `year`=:years'
    );
    $sql3->bindValue(':courseNumber', $ta2['course']);
    $sql3->bindValue(':term', $ta2['term']);
    $sql3->bindValue(':years', $ta2['years']);

    // $sql3->bind_param('sss', $ta2['course'], $ta2['term'], $ta2['years']);
    $course = $sql3->execute();
    // $course = $sql3->get_result();
    $course_details = $course->fetchArray();
    // Professor information
    $sql4 = $conn->prepare(
        'SELECT * FROM USER where email in (SELECT Distinct courseInstructor FROM course WHERE courseNumber=:courseNumber AND term=:term AND `year`=:years)'
    );
    $sql4->bindValue(':courseNumber', $ta2['course']);
    $sql4->bindValue(':term', $ta2['term']);
    $sql4->bindValue(':years', $ta2['years']);
    // $sql4->bind_param('sss', $ta2['course'], $ta2['term'], $ta2['years']);
    $prof = $sql4->execute();
    // $prof = $sql4->get_result();
    $profDetails = $prof->fetchArray();
    echo '<tr>
    <td>' .
        $ta2['email'] .
        '</td>
    <td>' .
        $ta2['ta_name'] .
        '</td>
        <td>' .
        $ta2['term'] .
        ' ' .
        $ta2['years'] .
        '</td>
        <td>' .
        $ta2['course'] .
        '</td>
        <td>' .
        $course_details['courseName'] .
        '</td>
        <td>' .
        $profDetails['firstName'] .
        ' ' .
        $profDetails['lastName'] .
        '</td>
        <td>' .
        $ta2['assigned_hours'] .
        '</td>
        </tr>';
}

echo '</table><br /> <br />';

$sql8 = $conn->prepare(
    'SELECT * FROM TA_PERFORMANCE_LOG WHERE course_num=:course_num AND term_year=:term_year'
);
$term_year = $currentTerm . ' ' . $currentYear;
$sql8->bindValue(':course_num', $currentPost);
$sql8->bindValue(':term_year', $term_year);
// $sql8->bind_param('ss', $currentPost, $term_year);
$ta_performance = $sql8->execute();
// $ta_performance = $sql8->get_result();
// $sql8 = $conn->prepare('SELECT * FROM TA_PERFORMANCE_LOG WHERE course_num=?');
// $sql8->bind_param('s', $course);
// $sql8->execute();
// $ta_performance = $sql8->get_result();

echo '<h3 style="color:rgb(167, 37, 48);" > Performance Logs </h3>';

echo '<table>';
echo '<tr>
    <th class="red-label">Term & Year</th>
    <th class="red-label">TA Email</th>
    <th class="red-label">Course</th>
    <th class="red-label">Professor</th>
    <th class="red-label">Date & Time</th>
    <th class="red-label">Comments</th>

    </tr>';

$count = 0;
while ($ta8 = $ta_performance->fetchArray()) {
    $count++;
    $sql11 = $conn->prepare(
        'SELECT firstName, lastName from user where email in ( Select courseInstructor from course where term=:term and `year`=:years and courseNumber=:courseNumber)'
    );
    $term_year = explode(' ', $ta8['term_year']);
    $currentTerm = $term_year[0];
    $currentYear = $term_year[1];

    $sql11->bindValue(':term', $currentTerm);
    $sql11->bindValue(':years', $currentYear);
    $sql11->bindValue(':courseNumber', $ta8['course_num']);

    // $sql11->bind_param(
    //     'sss',
    //     $currentTerm,
    //     $currentYear,
    //     $ta8['course_num']
    // );
    $prof_info = $sql11->execute();
    // $prof_info = $sql11->get_result();
    $profDetails = $prof_info->fetchArray();

    $prof_name = $profDetails['firstName'] . ' ' . $profDetails['lastName'];

    echo '<tr>
        <td>' .
        $ta8['term_year'] .
        '</td>
        <td>' .
        $ta8['ta_email'] .
        '</td>
        <td>' .
        $ta8['course_num'] .
        '</td>
            <td>' .
        $prof_name .
        '</td>
        <td>' .
        $ta8['time_stamp'] .
        '</td>
            <td>' .
        $ta8['comment'] .
        '</td>
        </tr>';
}

if ($count == 0) {
    echo '</table>';
    echo '<p style="display:flex;
                        justify-content:center;
                            align-item:center;
                            margin-top: 20px;
                            color: rgb(167, 37, 48);
                            font-weight: bold;
                            font-size: 18px;">' .
        $NotFound .
        '</p>';
} else {
    echo '</table><br /> <br />';
}

$sql5 = $conn->prepare(
    'SELECT * FROM TA_Ratings WHERE course=:course AND term=:term AND years=:years'
);
$sql5->bindValue(':course', $currentPost);
$sql5->bindValue(':term', $currentTerm);
$sql5->bindValue(':years', $currentYear);
// $sql5->bind_param('sss', $currentPost, $currentTerm, $currentYear);
$ta_feed = $sql5->execute();
// $ta_feed = $sql5->get_result();

echo '<h3 style="color:rgb(167, 37, 48);" >  Feedback from Students  </h3>';

echo '<table>';
echo '<tr>
    <th class="red-label">Term & Year</th>
    <th class="red-label">Student Email</th>
    <th class="red-label">TA Email</th>
    <th class="red-label">Rating</th>
    <th class="red-label">Notes</th>
    </tr>';

$count = 0;
while ($ta3 = $ta_feed->fetchArray()) {
    $count++;
    echo '<tr>
    <td>' .
        $ta3['term'] .
        ' ' .
        $ta3['years'] .
        '</td>
    <td>' .
        $ta3['student_email'] .
        '</td>
    <td>' .
        $ta3['ta_email'] .
        '</td>
    <td>' .
        $ta3['rating'] .
        '</td>
    <td>' .
        $ta3['Notes'] .
        '</td>
    </tr>';
}

if ($count == 0) {
    echo '</table>';
    echo '<p style="display:flex;
                        justify-content:center;
                            align-item:center;
                            margin-top: 20px;
                            color: rgb(167, 37, 48);
                            font-weight: bold;
                            font-size: 18px;">' .
        $NotFound .
        '</p>';
} else {
    echo '</table><br /> <br />';
}

$conn->close();
?>

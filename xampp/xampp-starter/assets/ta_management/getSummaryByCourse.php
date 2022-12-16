<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

$entered = 'entered';
$NotFound = 'No Entry Found!';
// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$currentPost = $_POST['course'];
$currentTerm = $_POST['term'];
$currentYear = $_POST['year'];

$sql2 = $conn->prepare(
    'SELECT * FROM TA WHERE course=? AND term=? AND years=?'
);
$sql2->bind_param('sss', $currentPost, $currentTerm, $currentYear);
$sql2->execute();
$ta_details = $sql2->get_result();

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

while ($ta2 = $ta_details->fetch_assoc()) {
    // We need course information
    $sql3 = $conn->prepare(
        'SELECT * FROM course WHERE courseNumber=? AND term=? AND `year`=?'
    );
    $sql3->bind_param('sss', $ta2['course'], $ta2['term'], $ta2['years']);
    $sql3->execute();
    $course = $sql3->get_result();
    $course_details = $course->fetch_assoc();
    // Professor information
    $sql4 = $conn->prepare(
        'SELECT * FROM USER where email in (SELECT Distinct courseInstructor FROM course WHERE courseNumber=? AND term=? AND `year`=?)'
    );
    $sql4->bind_param('sss', $ta2['course'], $ta2['term'], $ta2['years']);
    $sql4->execute();
    $prof = $sql4->get_result();
    $profDetails = $prof->fetch_assoc();
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
    'SELECT * FROM TA_PERFORMANCE_LOG WHERE course_num=? AND term_year=?'
);
$term_year = $currentTerm . ' ' . $currentYear;
$sql8->bind_param('ss', $currentPost, $term_year);
$sql8->execute();
$ta_performance = $sql8->get_result();
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

if (mysqli_num_rows($ta_performance) == 0) {
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
    while ($ta8 = $ta_performance->fetch_assoc()) {
        $sql11 = $conn->prepare(
            'SELECT firstName, lastName from user where email in ( Select courseInstructor from course where term=? and `year`=? and courseNumber=?)'
        );
        $term_year = explode(' ', $ta8['term_year']);
        $currentTerm = $term_year[0];
        $currentYear = $term_year[1];
        $sql11->bind_param(
            'sss',
            $currentTerm,
            $currentYear,
            $ta8['course_num']
        );
        $sql11->execute();
        $prof_info = $sql11->get_result();
        $profDetails = $prof_info->fetch_assoc();

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

    echo '</table><br /> <br />';
}

$sql5 = $conn->prepare(
    'SELECT * FROM TA_Ratings WHERE course=? AND term=? AND years=?'
);
$sql5->bind_param('sss', $currentPost, $currentTerm, $currentYear);
$sql5->execute();
$ta_feed = $sql5->get_result();

echo '<h3 style="color:rgb(167, 37, 48);" >  Feedback from Students  </h3>';

echo '<table>';
echo '<tr>
    <th class="red-label">Term & Year</th>
    <th class="red-label">Student Email</th>
    <th class="red-label">TA Email</th>
    <th class="red-label">Rating</th>
    <th class="red-label">Notes</th>
    </tr>';

if (mysqli_num_rows($ta_feed) == 0) {
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
    while ($ta3 = $ta_feed->fetch_assoc()) {
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
}

echo '</table><br /> <br />';

$conn->close();
?>

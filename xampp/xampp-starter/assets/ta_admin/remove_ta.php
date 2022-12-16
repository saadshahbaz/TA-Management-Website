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

$sql = $conn->prepare('SELECT * FROM TA WHERE email = ?');
$sql->bind_param('s', $email);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();
echo '<p>' . $user . '</p>';
$hashed_pass = password_hash($password, PASSWORD_DEFAULT);
$sql = $conn->prepare(
    'DELETE FROM TA WHERE email = ? AND student_id = ? AND ta_name = ? AND course = ? AND term = ? AND years = ?'
);
$sql->bind_param(
    'ssssss',
    $ta_email,
    $student_id,
    $name,
    $course_number,
    $term,
    $year
);
$result = $sql->execute();
$userTypeID = 3;

$sql1 = $conn->prepare('SELECT * FROM TA WHERE email = ?');
$sql1->bind_param('s', $ta_email);
$sql1->execute();
$result1 = $sql1->get_result();

if (mysqli_num_rows($result1) == 0) {
    $sql2 = $conn->prepare(
        'SELECT * FROM User_UserType WHERE userId = ? AND userTypeId = ?'
    );
    $sql2->bind_param('si', $ta_email, $userTypeID);
    $sql2->execute();
    $result2 = $sql2->get_result();

    if (mysqli_num_rows($result2) != 0) {
        $sql1 = $conn->prepare(
            'DELETE FROM User_UserType where userId= ? and  userTypeId = ?'
        );
        $sql1->bind_param('si', $ta_email, $userTypeID);
        $result1 = $sql1->execute();
    }
}

$conn->close();

// if (!$user) {
//     echo "<div class='error'>The Professor already exists.</div>";
//     $conn->close();
//     die();
// }
// } else {
//     echo '<p>' . $ta_email . '</p>'
// }
//     $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
//     $sql = $conn->prepare(
//         'INSERT INTO TA (email, faculty, department, course,term, years) VALUES (?, ?, ?, ?, ?, ?)'
//     );
//     $sql->bind_param(
//         'ssssss',
//         $ta_email,
//         $faculty,
//         $department,
//         $course_number,
//         $term,
//         $year
//     );
//     $result = $sql->execute();
//     $conn->close();
//     getTaAccounts();
// }

if ($result) {
    echo '<p class="text-success" >' . $name . ' was successfully Removed!</p>';
} else {
    echo '<p class="text-danger" >TA was not Removed...</p>';
}
?>

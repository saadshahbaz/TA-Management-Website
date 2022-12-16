<?php 
//creating connection
$servername = "localhost"; // Change accordingly
$username = "root"; // Change accordingly
$password = ""; // Change accordingly
$db = "xampp_starter"; // Change accordingly

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


//getting data from the form
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$username = $_POST['username'];
$studentId = $_POST['studentId'];
$password = $_POST['password'];
$password_hashed = password_hash($password, PASSWORD_DEFAULT);
$t = $_POST['type'];
$types = explode(',', $t);
if( isset($_POST['course']) ){
    $c = $_POST['course'];
    $course = explode(',', $c);
    $arrayLength = count(($course));
}
$userLength = count(($types));
$userTypes = array();
$i = 0;
$j = 0;


//checking if all fields entered
if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($username)) {
    echo '<text style="color: #FF0000;">Please fill in all fields.</text>';
    return;
}

//check if email already exists
$sql = $conn->prepare("SELECT * FROM User WHERE email = ?");
$sql->bind_param('s', $email);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo '<text style="color: #FF0000;">Email already exists.</text>';
    die();
}

//add to users table
$sql = $conn->prepare("INSERT INTO User (firstName, lastName, email, password, studentId, username) VALUES (?, ?, ?, ?, ?, ?)");
$sql->bind_param('ssssss', $fname, $lname, $email, $password_hashed, $studentId, $username);
$sql->execute();
$sql->close();

//add to user type table - can be multiple types
while ($j < $userLength)
    {
        $type = $types[$j];
        if (strcmp($type, 'Student') == 0) {
            $userTypeId = 1;
            $studentId = $_POST['studentId'];
        }
        else if (strcmp($type, 'Professor') == 0) {
            $userTypeId = 2;
        }
        else if (strcmp($type, 'TA') == 0) {
            $userTypeId = 3;
            $studentId = $_POST['studentId'];
        }
        else if (strcmp($type, 'TA Administrator') == 0) {
            $userTypeId = 4;
        }
        else if (strcmp($type, 'System Operator') == 0) {
            $userTypeId = 5;
        }
        else {
            echo "Error: User type not found.";
            return;
        }
        $sql2 = $conn->prepare("INSERT INTO User_UserType (userId, userTypeId) VALUES (?, ?)");
        $sql2->bind_param('ss', $email, $userTypeId);
        $sql2->execute();
        $userTypes[] = $userTypeId; 
        $j++;
}
$sql2->close();



// if student, add to student_course table for registered courses

if( in_array( 1 ,$userTypes ) ) {
    while ($i < $arrayLength)
    {
        $courseId = $course[$i];
        $sql3 = $conn->prepare("INSERT INTO Student_Course (studentId, courseId) VALUES (?, ?)");
        $sql3->bind_param('ss', $email, $courseId);
        $sql3->execute();
        $i++;
    }
    $conn->close();   
}

// if success, redirect to dashboard
session_start();
$_SESSION["email"] = $email;
echo "<script>window.location.replace('../dashboard/dashboard.html'); </script>";
?>
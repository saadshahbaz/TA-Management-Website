<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
$NotFound = 'No Entry Found!';

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

function getMessages($year, $term, $course)
{
    global $conn;
    global $NotFound;
    $sql = $conn->prepare(
        'SELECT * FROM message WHERE course= ? AND term= ? AND year= ? ORDER BY time DESC');
    $sql->bind_param('sss', $course, $term, $year);
    $sql->execute();
    $result = $sql->get_result();

    $i = 1;

    while ($oh = $result->fetch_assoc()) {
        $sql2 = $conn->prepare('SELECT * FROM User WHERE email= ?');
        $email = $sql2->bind_param('s', $oh['user']);
        $sql2->execute();
        $result2 = $sql2->get_result();
        $user = $result2->fetch_assoc();

         
        
        echo '<h4 style="color: rgb(167, 37, 48);">Posted By: ' . $user['firstName'] . ' ' . $user['lastName'] . '</h4>';
        
        echo '<h4>' . ' at ' . $oh['time'] . '</h4>';
        if ($oh["tag"] == "Announcement"){
            echo '<h5><span class="badge badge-pill badge-success">Announcement</span></h5>';
        }
        else if ($oh["tag"] == "Chat"){
            echo '<h5><span class="badge badge-pill badge-dark">Chat</span></h5>';
        }
        else if ($oh["tag"] == "Assignment Notes"){
            echo '<h5><span class="badge badge-pill badge-info">Assignment Notes</span></h5>';
        }
        else if ($oh["tag"] == "Reminders"){
            echo '<h5><span class="badge badge-pill badge-danger">Reminders</span></h5>';
        }
        else if ($oh["tag"] == "Links"){
            echo '<h5><span class="badge badge-pill badge-primary">Links</span></h5>';
        }
        echo '<h6>' . $oh['message'] . '</h6>';
        echo '<hr>';

        $i++;
    }
}

$term = $_GET['term'];
$year = $_GET['year'];
$course = $_GET['course'];

getMessages($year, $term, $course);
?>
    
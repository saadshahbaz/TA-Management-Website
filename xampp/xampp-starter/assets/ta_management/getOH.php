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

function getOH($year, $term, $course)
{
    global $conn;
    global $NotFound;
    $sql = $conn->prepare(
        'SELECT * FROM OfficeHours WHERE course= ? AND term= ? AND year= ?'
    );
    $sql->bind_param('sss', $course, $term, $year);
    $sql->execute();
    $result = $sql->get_result();

    echo '<table id="myTable">';
    echo '<tr>
    
        <th class="red-label">Name</th>
        <th class="red-label">Email</th>
        <th class="red-label">Location</th>
        <th class="red-label">Day</th>
        <th class="red-label">Start Time</th>
        <th class="red-label">End Time</th>
        <th class="red-label">Position</th>
        <th class="red-label">Resposibilities</th>';

    if (mysqli_num_rows($result) == 0) {
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
    }

    $i = 1;

    while ($oh = $result->fetch_assoc()) {
        $sql2 = $conn->prepare('SELECT * FROM User WHERE email= ?');
        $sql2->bind_param('s', $oh['email']);
        $sql2->execute();
        $result2 = $sql2->get_result();
        $user = $result2->fetch_assoc();
        echo '<tr>
        <td>' .
            $user['firstName'] .
            ' ' .
            $user['lastName'] .
            '</td>
        <td>' .
            $oh['email'] .
            '</td>
        <td>' .
            $oh['location'] .
            '</td>
        <td>' .
            $oh['day'] .
            '</td>
        <td>' .
            $oh['start_time'] .
            '</td>
        <td>' .
            $oh['end_time'] .
            '</td>
        <td>' .
            $oh['position'] .
            '</td>
        <td>' .
            $oh['responsibilities'] .
            '</td>
            <td><button type="button" id="' .
            $i .
            '" class="btn btn-outline-secondary" data-toggle="modal" onClick="buttonInformationRemove(this.id)"><i class="fa fa-minus"></i></button></td>
    
    
    </tr>';

        $i++;
    }
}

$term = $_GET['term'];
$year = $_GET['year'];
$course = $_GET['course'];

getOH($year, $term, $course);
?>
    
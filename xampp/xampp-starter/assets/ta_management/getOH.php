<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// // Create connection
// $conn = new mysqli($servername, $username, $password, $db);
// $NotFound = 'No Entry Found!';

// // Check connection
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);


function getOH($year, $term, $course)
{
    global $conn;
    global $NotFound;
    $sql = $conn->prepare(
        'SELECT * FROM OfficeHours WHERE course= :course AND term= :term AND year=:years '
    );
    // $sql->bind_param('sss', $course, $term, $year);
    $sql->bindValue(':years', $year);
    $sql->bindValue(':term', $term);
    $sql->bindValue(':course', $course);
    // $sql->execute();
    $result = $sql->execute();
    
    $number_of_rows = 0;
    while ($row = $result->fetchArray()) {
        $number_of_rows += 1;
    }

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

    if ($number_of_rows == 0) {
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

    while ($oh = $result->fetchArray()) {
        $sql2 = $conn->prepare('SELECT * FROM User WHERE email= :email');
        //$sql2->bind_param('s', $oh['email']);
        //$sql2->execute();
        $sql2->bindValue(':email', $oh['email']);
        $result2 = $sql2->execute();
        $user = $result2->fetchArray();
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
    
<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
// $conn = new mysqli($servername, $username, $password, $db);
$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);
$NotFound = 'No Entry Found!';

// Check connection
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }

$result2 = $conn->query('SELECT * FROM TA');
$number_of_rows = 0; //for now

while ($row = $result2->fetchArray()) {
    $number_of_rows += 1;
}

$sql = $conn->prepare('SELECT * FROM TA');
$result = $sql->execute();

// $result = $sql->get_result();

echo '<table id="myTable">';
echo '<tr>

    <th class="red-label">Email</th>
    <th class="red-label">Student ID</th>
    <th class="red-label">TA Name</th>
    <th class="red-label">Course</th>
    <th class="red-label">Term </th>
    <th class="red-label">Year</th>
    <th class="red-label">Assigned Hours</th>
    <th class="red-label">Remove</th>
    </tr>';

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

while ($ta = $result->fetchArray(SQLITE3_ASSOC)) {
    echo '<tr>
    
    <td>' .
        $ta['email'] .
        '</td>
    <td>' .
        $ta['student_id'] .
        '</td>

    <td>' .
        $ta['ta_name'] .
        '</td>
    <td>' .
        $ta['course'] .
        '</td>
    <td>' .
        $ta['term'] .
        '</td>
    <td>' .
        $ta['years'] .
        '</td>
    <td>' .
        $ta['assigned_hours'] .
        '</td>
        <td><button type="button" id="' .
        $i .
        '" class="btn btn-outline-secondary" data-toggle="modal" onClick="buttonInformationRemove(this.id)"><i class="fa fa-minus"></i></button></td>


</tr>';

    $i++;
}

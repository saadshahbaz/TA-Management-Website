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

$sql = $conn->prepare('SELECT * FROM TA');
$sql->execute();
$result = $sql->get_result();

echo '<div class="row">
<div class="col"><table id="myTable">';
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

if (mysqli_num_rows($result) == 0) {
    echo '</table></div></div>';
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

while ($ta = $result->fetch_assoc()) {
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
        '   </td>
    <td>' .
        $ta['assigned_hours'] .
        '</td>
        <td><button type="button" id="' .
        $i .
        '" class="btn btn-outline-secondary" data-toggle="modal" onClick="buttonInformationRemove(this.id)"><i class="fa fa-minus"></i></button></td>


</tr>';

    $i++;
}

echo '</table></div></div>';

?>

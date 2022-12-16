<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// Create connection
// $conn = new mysqli($servername, $username, $password, $db);

// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);
$sql = $conn->prepare('SELECT * FROM Professor');
$result = $sql->execute();
//$result = $sql->get_result();

echo '<table>';
echo '<tr>
    <th class="red-label">Email</th>
    <th class="red-label">First name</th>
    <th class="red-label">Last name</th>
    <th class="red-label">Faculty</th>
    <th class="red-label">Department</th>
    <th class="red-label">Courses</th>
    </tr>';

while ($prof = $result->fetchArray()) {
    // create comma-separated list of account types
    $query = $conn->prepare('SELECT * FROM User WHERE email = :email');
    // $query->bind_param('s', $prof['professor']);
    $query->bindValue(':email', $prof['professor']);
    $res = $query->execute();
    // $res = $query->get_result();
    $user = $res->fetchArray();
    echo '<tr>
        <td>' .
        $prof['professor'] .
        '</td>
        <td>' .
        $user['firstName'] .
        '</td>
        <td>' .
        $user['lastName'] .
        '</td>
        <td>' .
        $prof['faculty'] .
        '</td>
        <td>' .
        $prof['department'] .
        '</td>
        <td>' .
        $prof['course'] .
        '</td>
    </tr>';
}

echo '</table>';
$conn->close();
?>

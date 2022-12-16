<?php
function convertAccountType($type) {
    switch ($type) {
        case "student":
            return "Student";
        case "professor":
            return "Professor";
        case "admin":
            return "TA Administrator";
        case "ta":
            return "Teaching Assistant";
        case "sysop":
            return "System Operator";
    }
}
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

$sql = $conn->prepare("SELECT * FROM User");
$sql->execute();
$result = $sql->get_result();

echo '<table>';
echo'<tr>
    <th class="red-label">Email</th>
    <th class="red-label">First Name</th>
    <th class="red-label">Last Name</th>
    <th class="red-label">User Type</th>
    </tr>';


while ($user = $result->fetch_assoc()) {

    // create comma-separated list of account types
    $query = $conn->prepare("SELECT UserType.userType FROM UserType INNER JOIN User_UserType 
                ON UserType.idx=User_UserType.userTypeId WHERE User_UserType.userId = ?");
    $query->bind_param('s', $user['email']);
    $query->execute();
    $res = $query->get_result();
    
    $uTypes = [];

    while ($row = $res->fetch_assoc()) {
        $uTypes[] = convertAccountType($row['userType']);
        // $acct_types = $acct_types . ", " . convertAccountType($row['userType']);
    }
    $userRoles = implode(', ', $uTypes);

    echo 
    '<tr>
        <td>'. $user['email'] .'</td>
        <td>'. $user['firstName'] .'</td>
        <td>'. $user['lastName'] .'</td>
        <td>'. $userRoles .'</td>
    </tr>';
}

echo '</table>';
$conn->close();
?>
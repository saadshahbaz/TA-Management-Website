<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// $conn = new mysqli($servername, $username, $password, $db);

// // Check connection
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

$sql = $conn->prepare('SELECT DISTINCT term, years FROM TA ORDER BY years');
$result = $sql->execute();
// $result = $sql->get_result();
echo '<option value="" selected disabled>Term & Year...</option>';

while ($ta = $result->fetchArray()) {
    echo '<option value="' .
        $ta['term'] .
        ' ' .
        $ta['years'] .
        '">' .
        $ta['term'] .
        ' ' .
        $ta['years'] .
        '</option>';
}
$sql->close();

// function getTerm($year)
// {
//     global $conn;
//     $sql = $conn->prepare(
//         'SELECT DISTINCT term FROM TA where years = :years ORDER BY course'
//     );
//     // $sql->bind_param('s', $year);
//     $sql->bindValue(':years', $year);
//     $result = $sql->execute();
//     // $result = $sql->get_result();
//     echo '<option value="" selected disabled> Select a Term... </option>';

//     while ($ta = $result->fetchArray()) {
//         // echo '<tr>' . $ta['email'] . '</td>'
//         echo '<option value="' . $ta['term'] . '">' . $ta['term'] . '</option>';
//     }
//     $sql->close();
// }

// function getTAs($term, $year, $course)
// {
//     global $conn;
//     $sql = $conn->prepare(
//         'SELECT DISTINCT email FROM TA where term = :term AND years = :years AND course = :course ORDER BY course'
//     );
//     $sql->bindValue(':years', $year);
//     $sql->bindValue(':term', $term);
//     $sql->bindValue(':course', $course);

//     // $sql->bind_param('sss', $term, $year, $course);
//     $result = $sql->execute();
//     // $result = $sql->get_result();
//     echo '<option value="" selected disabled> Select a TA... </option>';

//     while ($ta = $result->fetchArray()) {
//         $query = $conn->prepare('SELECT * FROM User WHERE email = :email');
//         $query->bindValue(':email', $ta['email']);
//         // $query->bind_param('s', $ta['email']);
//         $res = $query->execute();
//         // $res = $query->get_result();
//         $user = $res->fetchArray();
//         echo '<option value="' .
//             $ta['email'] .
//             '">' .
//             $user['firstName'] .
//             ' ' .
//             $user['lastName'] .
//             '</option>';
//     }
//     $sql->close();
// }

// if (isset($_GET)) {
//     if (strcmp($_GET['action'], 'getYear') == 0) {
//         getYear();
//     }
// }

?>

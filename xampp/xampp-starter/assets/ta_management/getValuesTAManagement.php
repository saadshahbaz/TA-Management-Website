<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

function getTerm($course)
{
    global $conn;
    $sql = $conn->prepare(
        'SELECT DISTINCT term, `year` FROM course where courseNumber = ? ORDER BY `year`, term'
    );
    $sql->bind_param('s', $course);
    $sql->execute();
    $result = $sql->get_result();
    echo '<option value="" selected disabled> Select a Term... </option>';

    while ($ta = $result->fetch_assoc()) {
        // echo '<tr>' . $ta['email'] . '</td>'
        echo '<option value="' .
            $ta['term'] .
            ' ' .
            $ta['year'] .
            '">' .
            $ta['term'] .
            ' ' .
            $ta['year'] .
            '</option>';
    }
    $sql->close();
}

function getTAs($term, $year, $course)
{
    echo '<p>Term: ' . $term . '</p>';
    global $conn;
    $sql = $conn->prepare(
        'SELECT DISTINCT email FROM TA where term = ? AND years = ? AND course = ? ORDER BY course'
    );
    $sql->bind_param('sss', $term, $year, $course);
    $sql->execute();
    $result = $sql->get_result();
    echo '<option value="" selected disabled> Select a TA... </option>';

    while ($ta = $result->fetch_assoc()) {
        $query = $conn->prepare('SELECT * FROM User WHERE email = ?');
        $query->bind_param('s', $ta['email']);
        $query->execute();
        $res = $query->get_result();
        $user = $res->fetch_assoc();
        echo '<option value="' .
            $ta['email'] .
            '">' .
            $user['firstName'] .
            ' ' .
            $user['lastName'] .
            '</option>';
    }
    $sql->close();
}

if (isset($_GET)) {
    if (strcmp($_GET['action'], 'getTerms') == 0) {
        $course = $_GET['course'];
        getTerm($course);
    } elseif (strcmp($_GET['action'], 'getTAs') == 0) {
        $term = $_GET['term'];
        $year = $_GET['year'];
        $course = $_GET['course'];
        $NotFound = 'No Entry Found!';
        getTAs($term, $year, $course);
    }
}

?>

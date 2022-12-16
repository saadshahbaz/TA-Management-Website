
<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

// $conn = new mysqli($servername, $username, $password, $db);

// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

function getYears()
{
    global $conn;
    $sql = $conn->prepare('SELECT DISTINCT year FROM Course ORDER BY year');
    $result = $sql->execute();
    //$result = $sql->get_result();
    echo '<option value="" selected disabled> Select a Year... </option>';
    while ($ta = $result->fetchArray()) {
        echo $ta;
        echo '<option value="' . $ta['year'] . '">' . $ta['year'] . '</option>';
    }
    $conn->close();
}

function getSemesters()
{
    global $conn;

    echo '<option value="" selected disabled> Select a Term... </option>
    <option value="Fall" id="semester">Fall</option>
    <option value="Winter" id="semester">Winter</option>';
    $conn->close();
}

function getCourses($year, $term)
{
    global $conn;
    $sql = $conn->prepare(
        'SELECT DISTINCT courseNumber FROM Course where year = :years AND term = :term ORDER BY courseNumber'
    );
    // $sql->bind_param('ss', $year, $term);
    $sql->bindValue(':years', $year);
    $sql->bindValue(':term', $term);
    $result = $sql->execute();
    //$result = $sql->get_result();
    //$courses = $result->fetch_assoc();
    echo '<option value="" selected disabled> Select a Course... </option>';

    while ($ta = $result->fetchArray()) {
        echo $ta;
        echo '<option value="' .
            $ta['courseNumber'] .
            '">' .
            $ta['courseNumber'] .
            '</option>';
    }

    $conn->close();
}

if (strcmp($_GET['action'], 'getCourses') == 0) {
    $term = $_GET['term'];
    $year = $_GET['year'];
    getCourses($year, $term);
} elseif (strcmp($_GET['action'], 'getSemesters') == 0) {
    getSemesters();
} else {
    getYears();
}


?>

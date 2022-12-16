
<?php
$servername = 'localhost'; // Change accordingly
$username = 'root'; // Change accordingly
$password = ''; // Change accordingly
$db = 'xampp_starter'; // Change accordingly

$conn = new SQLite3('../database/ta_management.db', SQLITE3_OPEN_READWRITE);

function getYears()
{
    global $conn;
    $sql = $conn->prepare('SELECT DISTINCT year FROM Course ORDER BY year');
    $result = $sql->execute();
    // $result = $sql->get_result();
    echo '<option value="" selected disabled> Select a Year... </option>';
    while ($ta = $result->fetchArray()) {
        echo $ta;
        echo '<option value="' . $ta['year'] . '">' . $ta['year'] . '</option>';
    }
    $conn->close();
}

function getCourses($year, $term)
{
    global $conn;
    $sql = $conn->prepare(
        'SELECT DISTINCT courseNumber FROM Course where year = :years AND term = :term ORDER BY courseNumber'
    );
    $sql->bindValue(':years', $year);
    $sql->bindValue(':term', $term);
    // $sql->bind_param('ss', $year, $term);
    $result = $sql->execute();
    // $result = $sql->get_result();
    //$courses = $result->fetch_assoc();
    echo 'Choose courses';

    while ($ta = $result->fetchArray()) {
        // echo '<tr>' . $ta['email'] . '</td>'
        echo '<input type="checkbox" name="course[]" value="' .
            $ta['courseNumber'] .
            '"/>' .
            $ta['courseNumber'] .
            '';
    }

    $conn->close();
}

if (strcmp($_GET['action'], 'getCourses') == 0) {
    $term = $_GET['term'];
    $year = $_GET['year'];
    getCourses($year, $term);
} else {
    getYears();
}


?>

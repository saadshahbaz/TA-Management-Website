
<?php 

    $servername = "localhost"; // Change accordingly
    $username = "root"; // Change accordingly
    $password = ""; // Change accordingly
    $db = "xampp_starter"; // Change accordingly

    $conn = new mysqli($servername, $username, $password, $db);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    function getYears(){
        global $conn;
        $sql = $conn->prepare("SELECT DISTINCT year FROM Course ORDER BY year");
        $sql->execute();
        $result = $sql->get_result();
        echo '<option value="" selected disabled> Select a Year... </option>';
        while ($ta = $result->fetch_assoc()) {
            echo $ta;
            echo '<option value="' .
                $ta['year'] .
                '">' .
                $ta['year'] .
                '</option>';
        };
        $conn->close();
    }



    function getCourses($year, $term)
    {
        global $conn;
        $sql = $conn->prepare("SELECT DISTINCT courseNumber FROM Course where year = ? AND term = ? ORDER BY courseNumber");
        $sql->bind_param('ss', $year, $term);
        $sql->execute();
        $result = $sql->get_result();
        //$courses = $result->fetch_assoc();
        echo 'Choose courses: <br />';

        while ($ta = $result->fetch_assoc()) {
            // echo '<tr>' . $ta['email'] . '</td>'
            echo '<input type="checkbox" name="course[]" value="' .
                $ta['courseNumber'] .
                '"/>' .
                $ta['courseNumber'] .
                ' ';
        };

        $conn->close();
    }

    if (strcmp($_GET['action'], 'getCourses') == 0) {
        $term = $_GET['term'];
        $year = $_GET['year'];
        getCourses($year, $term);
    }
    else{
        getYears();
    }
?>

<?php

 $servername = "localhost"; // Change accordingly
 $username = "root"; // Change accordingly
 $password = ""; // Change accordingly
 $db = "xampp_starter"; // Change accordingly
 
 $conn = new mysqli($servername, $username, $password, $db);
 
 
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

function exportOH($course, $term, $year){
    global $conn;
    $sql = $conn->prepare('SELECT * FROM OfficeHours WHERE course= ? AND term= ? AND year= ?');
    $sql->bind_param('sss', $course, $term, $year);
    $sql->execute();
    $result = $sql->get_result();
    

        $delimiter = ","; 
        $filename = "CourseInformation" . "-" . $course . "-" . date("D M d Y") . ".csv"; 
        
        $f = fopen('php://memory', 'w'); 
        

        $fields = array('name', 'email', 'day', 'start_time', 'end_time', 'location', 'responsibilities', 'position'); 
        fputcsv($f, $fields, $delimiter); 
        while ($oh = $result->fetch_assoc()) {
            $sql2 = $conn->prepare('SELECT * FROM User WHERE email= ?');
            $sql2->bind_param('s', $oh['email']);
            $sql2->execute();
            $result2 = $sql2->get_result();
            $user = $result2->fetch_assoc();
            $name = $user['firstName'] . ' ' . $user['lastName'];
            $lineData = array($name, $oh['email'], $oh['day'], $oh['start_time'], $oh['end_time'], $oh['location'], $oh['responsibilities'], $oh['position']); 
            fputcsv($f, $lineData, $delimiter); 
        }
        
        fseek($f, 0); 
        
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$filename."\"");  
        
        fpassthru($f); 

    exit; 
}
$term = $_GET['term'];
$year = $_GET['year'];
$course = $_GET['course'];


exportOH($course, $term, $year);
?>
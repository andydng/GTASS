<?php

  /*
   
   
   This is just a popup window with the nominee information.
   
   
   */
    
include("includes/mysql_connect.php");
     $name = "late"; //pass it the nominee name from the link that the GTA member clicks

     $query = "SELECT * FROM nomination WHERE first_name = '$name'";// query
     $result = mysqli_query($db,$query) or die(mysql_error());// result
     if(!($row = mysqli_fetch_array($result)))
     echo("NO RESULTS FOUND!");
    $temp = $row['faculty_email'];

     $advQuery = "SELECT first_name, last_name FROM faculty WHERE email = '$temp'";
     $advResult =  mysqli_query($db,$advQuery) or die(mysql_error());
     if(!($advRow = mysqli_fetch_array($advResult)))
     echo("NO RESULTS FOUND!");


     $msg = ' \t\t\t nominee info\n \t\t---------------------------\n';
     $msg .= ' \t\t  First name: '.$row['first_name'].'\n';
     $msg .= ' \t\t  Last name: '.$row['last_name'].'\n';
     $msg .= ' \t\t  sid: '.$row['sid'].'\n';
     $msg .= ' \t\t  email: '.$row['student_email'].'\n';
     $msg .= ' \t\t  advisor: '.$advRow['first_name'].' '.$advRow['last_name'].'\n';
     $msg .= ' \t\t  Advisor email: '.$row['faculty_email'].'\n';
     $msg .= ' \t\t  session: '.$row['session_name'].'\n';
     $msg .= ' \t\t  rank: '.$row['rank'].'\n';
     $msg .= ' \t\t  rank: '.$row['rank'].'\n';

echo "<script type='text/javascript'>alert('$msg');</script>";


?>


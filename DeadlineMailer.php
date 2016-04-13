<?php
    
    /*
     *
     * This script checks the database and sends out a reminder email if the deadline is in 2 days for 2 reasons:
     *
     *    - Sends a reminder to the nominee if the nominee has an "N" for their "completed" value.
     *    - Sends a reminder to the nominator if the nominee has an "N" for their "verified" value.
     *
     *
     *
     *
     * MAIN ISSUE: It was a bit tricky to get php's mail function to work on mac:
     *
     * STEPS
     * -----
     * 1. Assuming you have el capitan: http://www.developerfiles.com/how-to-send-emails-from-localhost-mac-os-x-el-capitan/
     *    - if the "sudo postfix reload" command gives errors for an unused variable, just comment it out.
     *    - if it says "postfix/postfix-script: fatal: the Postfix mail system is not running", ignore it; mine gives the error and it works fine.
     * 2. Edit your XAMPP/etc/php.ini file and configure the sendmail_path option:
     *    - sendmail_path = "sendmail -t -i"
     *
     *
     *
     *
     *
     *
     * * * * * Also make sure the "mysql_connect.php" path and form path are correct * * * * * *
     *
     *
     *
     */
    
    
    /*
     *
     * You can add this code snippet to the end of the nominee form for emailing the nominator
     *
     *   - Just create the variables it uses:
     *           $faculty_name
     *           $student_name
     *           $faculty_email
     *
     
     
     
     
     $url = $_SERVER['SERVER_NAME'] . '/GTASS-4/Nominations/index.php'; //grabs the URL for the login page.
     
     $link = "<a href = '$url'>Login page</a><br>"; //Link to login page.
     
     $headers = "MIME-Version: 1.0" . "\r\n";
            //header info I stole from doan.
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     
     $message = " Hello $faculty_name,<br><br> A new nomination application was completed! Please login and verify the submission for $student_name:<br><br><br><br>".$link
     
     mail($faculty_email,"Nomination application complete", $message , $headers); // sends message
     
     
     
     
     
     
     */
    
    include("includes/mysql_connect.php");
   
    
    //----------------------//
    
    // Initial declarations //
    
    //----------------------//
    
    $url = $_SERVER['SERVER_NAME'] . '/GTASS-4/Students/form.php';
    date_default_timezone_set('UTC');// sets the default time zone
    $now = time();// grabs the current time
    $query = "SELECT * FROM `nomination`, `session`";;// query being used
    $result = mysqli_query($db,$query) or die(mysql_error());// result
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $Link_To_Form = "";// initializing these variables for the loops
    $message = "";
    
    
    
    //----------------------// Message being sent to the nominees. The final message will be $message //----------------------//----------------------//----------------------
    
    $msg = " Hello Nominee,\n\n  You have not completed your nomination and the deadline is in two days. Visit the following link to complete it: <br><br><br><br><br><br><br>";
    
    //----------------------//----------------------//----------------------//----------------------//----------------------//----------------------//----------------------
    
    
    
    
    
    //-----------   Start of the query fetch loop   -----------//
    while($row = mysqli_fetch_array($result)){
        
        $deadline = strtotime($row['comp_deadline']); //grabs the deadline
        $datediff = $deadline-$now; // takes the difference
        
        if(floor($datediff/(60*60*24))>=2){ // If the deadline is 2 days or more away
            
            
            if(floor($datediff/(60*60*24))==2){  //if it's exactly 2 days
                
                if(strcmp($row['complete'],"Y")!=0){// if not complete, send reminder
                    
                    $nominator = $row['faculty_email'];//grabs the nominator of the current row
                    $NominatorQuery = "SELECT first_name,last_name FROM faculty WHERE email='$nominator'";//query for grabing the current nominator's information
                    $nResult = mysqli_query($db,$NominatorQuery) or die(mysql_error());//actual query for nominators info
                    $nRow = mysqli_fetch_array($nResult);// It will only be one row.
                    
                    //builds the link variables into a string for the given loop iteration.
                    $this_link = '?nominator_first=' . $nRow['first_name'] . '&nominator_last=' . $nRow['last_name'] . '&student_first=' . $row['first_name'] . '&student_last=' . $row['last_name'] . '&pid=' . $row['sid'] . '&student_email=' . $row['student_email'] . '&nominator_email=' . $row['faculty_email'] . '&session_name=' . $row['session_name'];
                    
                    $Link_To_Form = $url . $this_link;// appends the variables being passed through the URL
                    $message = $msg . "<a href = '$Link_To_Form'>Please complete your application</a><br>";//appends link of the form to the final message
                    mail($row['student_email'],"Reminder to complete nomination application.",$message,$headers);//mail function to send the actual email
                    
                }
                if(strcmp($row['verified'],"Y")!=0){// if not verified, send reminder only
                    $nMessage = " Hello Nominator,<br><br> This is a reminder! You have 2 days to login and review the submission for ".$row['first_name'].".<br><br><br><br>";
                    mail($row['faculty_email'],"Reminder to complete nomination Verification",$nMessage, $headers);
                    
                    
                }
            }
        }
    }
    //-----------   End of the query fetch loop   -----------//
    
    
    echo("SUCCESS!");

?>


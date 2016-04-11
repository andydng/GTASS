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
     
     STEPS
     -----
     1. Assuming you have el capitan: http://www.developerfiles.com/how-to-send-emails-from-localhost-mac-os-x-el-capitan/
         - if the "sudo postfix reload" command gives errors for an unused variable, just comment it out.
         - if it says "postfix/postfix-script: fatal: the Postfix mail system is not running", ignore it; mine gives the error and it works fine.
     2. Edit your XAMPP/etc/php.ini file and configure the sendmail_path option:
         - sendmail_path = "sendmail -t -i"
     
   
     
     *
     *
     *
     * Also make sure the "mysql_connect.php" path is correct. 
     *
     *
     * I will be cleaning this up later, along with finishing the rest of the files.
     */
    
    
    
    include("../includes/mysql_connect.php");
    date_default_timezone_set('UTC');// sets the default time zone
    $now = time();// grabs the current time
    $query = "SELECT student_email, faculty_email, first_name, complete, verified, comp_deadline, ver_deadline FROM nomination, session";// query
    $result = mysqli_query($db,$query) or die(mysql_error());// result
    
    
    
    //----------------------//add the proper link for the form here//----------------------
    
    $Link_To_Form = " ";
    
    //----------------------//----------------------//----------------------
    
    
    
    
    
    //----------------------// string for the popup window//----------------------//----------------------
    
    $gottime =('\t\t\tSTUDENTS THAT STILL HAVE TIME\n\t\t\t-------------------------------------\n');
    
    //----------------------//----------------------//----------------------//----------------------
    
    
    
    
    
    
    //----------------------//Message being sent to the nominees. This method of doing it does seem a bit crude.//----------------------//----------------------
    
    $msg = " Hello Nominee,\n\n  You have not completed your nomination and the deadline is in two days. Visit the following link to complete it:\n\n\n\n\n\n".$Link_To_Form;
    
    //----------------------//----------------------//----------------------//----------------------
    
    
    
    
    

    //-----------   Start of the query fetch loop   -----------
    while($row = mysqli_fetch_array($result)){
        
        $deadline = strtotime($row['comp_deadline']); //grabs the deadline
        $datediff = $deadline-$now; // takes the difference
        
        //----------   If the deadline is 2 days or more away   ------------
        if(floor($datediff/(60*60*24))>=2) {
            
            //if it's exactly 2 days
            if(floor($datediff/(60*60*24))==2){
            // send email
                if(strcmp($row['complete'],"Y")!=0)
                    mail($row['student_email'],"Reminder to complete nomination application.",$msg);
                if(strcmp($row['verified'],"Y")!=0)
                    mail($row['student_email'],"Reminder to complete nomination Verification"," Hello Nominator,\n\n This is a reminder! You have 2 days to login and review the submission for ".$row['first_name']);
            }
            
        // displays a popup with info on the amount of time the remainder of the nominees have.
        $gottime .= '                       ' . $row['first_name'] . ' has ' . (floor($datediff/(60*60*24))) . ' days for the ' . $row['comp_deadline'] . ' Deadline.\n';
            
        }else{
         
        }
    }
    //-----------   End of the query fetch loop   -----------
    
    
    
    
  
    //initiates popup window;
    echo("SUCCESS");
    echo "<script type='text/javascript'>alert('$gottime');</script>";
?>
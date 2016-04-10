<?php
   //include("Resources/config.php");
  include("../includes/mysql_connect.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
    

   }
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>GTASS - Home</title>

    <!--Style sheets-->
    <link href = 'Resources/style.css' rel = 'stylesheet' type = 'text/css'>

  </head>
  <body>
    <nav class="navbar">
    <ul class = "nav-list">
      <li class = "nav-link" ><a class = "nav-item" href="../../index.html">GTASS</a></li>
     
      <li class = "nav-path">
        <a class = "path-list-member" href = "../index.html">Home</a>
      </li>

      <li class = "nav-path">
        <span class = "path-separator path-list-member">/</span>
      </li>      
             
            
      <li class = "nav-path">
        <a class = "path-list-member" href = "index-home.php">Committee Reviews</a>
      </li>

      <li class = "nav-path">
        <span class = "path-separator path-list-member">/</span>
      </li>      
             
      <!-- NEEDS GET[] variable added to link this link-->
      <li class = "nav-path">
        <?php
        $this_session = $_GET["session"];
        $this_link = 'complete.php?session=' . $this_session;
        print "<a class = 'path-list-member active-path' href = '$this_link'>Complete Applications</a>";
        
        ?>
      </li>      


      <li class = "nav-link nav-link-right"><a class = "nav-item" href="../index.php">Admin</a></li>
    </ul>
    </nav>

          <?php
            //INITIALIZE VARIABLES
            
            $member = $_SESSION['login_user'];
            $htmlOutput    = array();
            $session = $_GET["session"];
            $colsToDisplay = 4;
            $sqlA = "SELECT sid,faculty_email,first_name,last_name,rank,is_phd,new_phd FROM nomination WHERE session_name = '$session' and complete = 'Yes' and verified = 'Yes'";

            $resultA = mysqli_query($db,$sqlA);            
            $countA = mysqli_num_rows($resultA);

            //if result contained 1+ rows -> then generate table
            if($countA)
            {
              //printing header columns
              print '<div class ="table-title"><h3 class = "title-text">Complete Nominations</h3></div>';
              print '<table class = "index-table">';
              print '<tr class = "header-row"><td class = "header">Nominator</td><td class = "header">Student</td><td class = "header">Rank</td><td class = "header">Existing/New</td>';

              //printing header columns with committee member emails
              $sqlC = "SELECT email FROM committee WHERE session_name = '$session'";
              $headerOutput = array();
              $resultC = mysqli_query($db,$sqlC);
              $columnsC = mysqli_num_rows($resultC); //reuse columnsC for num columns for score fields
              $colsToDisplay += $columnsC;

              while($rowC = $resultC->fetch_assoc()) 
              {                       
                   $headerOutput[] = "<td class = 'header'>{$rowC['email']}</td>";
              }
              $headerOutput = array_chunk($headerOutput, $columnsC);
              foreach($headerOutput as $currRowC) 
              {      
                print implode('', $currRowC); 
              }               
              print '</tr>';
              //end of printing header columns with committee member emails

              //beginning rows of review data for session
              while($rowA = $resultA->fetch_assoc()) 
              {
                //getting faculty nominator first/last name
                $nominator = $rowA['faculty_email'];
                $sqlB = "SELECT first_name,last_name FROM faculty WHERE email = '$nominator'";
                $resultB = mysqli_query($db,$sqlB);
                $rowB = $resultB->fetch_assoc();
                //determining value of phd/existing column
                if($rowA['is_phd'] == 'Yes')
                  $phd = "Existing";
                else
                  $phd = "New";

                $student_name = $rowA['last_name'] . ', ' . $rowA['first_name'];
                $faculty_name = $rowB['last_name'] . ', ' . $rowB['first_name'];
                //storing row output in string to concatenate with review member columns
                $tempOutput = "<tr><td>{$faculty_name}</td><td>{$student_name}</td><td>{$rowA['rank']}</td><td>{$phd}</td>";
                
                $sid = $rowA['sid']; 

                $sqlD = "SELECT email FROM committee WHERE session_name = '$session'";
                $facColOutput = array();
                $resultD = mysqli_query($db,$sqlD);
                $columnsD = mysqli_num_rows($resultD); //reuse columnsC for num columns for score fields
                $facOutput = "";

                while($rowD = $resultD->fetch_assoc()) 
                {
                  $scoreTemp = "";
                  $fk_nominator = $rowD['email'];
                  $sqlE = "SELECT score FROM review WHERE session_name = '$session' and nominee = '$sid' and nominator = '$fk_nominator'";
                  $resultE = mysqli_query($db,$sqlE);
                  $columnsE = mysqli_num_rows($resultE);

                  if($columnsE > 0)
                  {
                    $rowsE = $resultC->fetch_assoc();
                    $score = $rowsE['score'];
                    if($fk_nominator == $nominator)
                      $facOutput = $facOutput . "<td><input value = '$score' type = 'number' min = '1' max = '100' name = 'score' placeholder = '1 - 100'></input></td>";
                    else
                      $facOutput = $facOutput . "<td>'$score'</td>"; 
                  }
                  else
                  {
                    if($fk_nominator == $nominator)
                      $facOutput = $facOutput . "<td><input type = 'number' min = '1' max = '100' name = 'score' placeholder = '1 - 100'></input></td>";
                    else
                      $facOutput = $facOutput . "<td>1</td>";
                    
                  }
                  
                }
                $facOutput = $facOutput . "</tr>";
                $htmlOutput[] = $tempOutput . $facOutput;                 
              }

              //BREAK THE COLUMNS INTO GROUPS 
              $htmlOutput = array_chunk($htmlOutput, $colsToDisplay);   
              //DISPLAY TABLE 
               
              foreach($htmlOutput as $currRow) 
              {      
                print implode('', $currRow); 
              } 
              print '</table>';              
            }
           
            
            
 
          ?>
    
  </body>
</html>
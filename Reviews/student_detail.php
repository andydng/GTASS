<?php
   //include("Resources/config.php");
  include("../includes/mysql_connect.php");
   session_start();
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
        print "<a class = 'path-list-member' href = '$this_link'>Complete Nominations</a>";
        
        ?>
      </li>

      <li class = "nav-path">
        <span class = "path-separator path-list-member">/</span>
      </li>      
             
            
      <li class = "nav-path">
        <?php
        $this_student = $_GET["session"];
        $this_link = 'student_detail.php?sid=' . $this_student;
        print "<a class = 'path-list-member active-path' href = '$this_link'>Student Detail</a>";
        
        ?>
      </li>

      <li class = "nav-link nav-link-right"><a class = "nav-item" href="../index.php">Admin</a></li>
    </ul>
    </nav>

          <?php
            //INITIALIZE VARIABLES
            $colsToDisplay = 1;
            
            $htmlOutput    = array();
            
            //need to generate queries for student details - needs nomination table/student completed table
            //needs citations, courses, advises
            $sql = "SELECT session_name FROM session";
            $result = mysqli_query($db,$sql);            
            $count = mysqli_num_rows($result);

            //if result contained 1+ rows -> then generate table
            if($count)
            {
              print '<div class ="table-title"><h3 class = "title-text">Student Detail<h1></div>';
              print '<table class = "index-table">';

              while($row = $result->fetch_assoc()) 
              {    
                   $session = $row['session_name'];
                   $htmlOutput[] = "<tr><td>{$row['session_name']}</td><td><a href = 'complete.php?session=$session'>Complete</a></td><td><a href = 'incomplete.php?session=$session'>Incomplete</a></td>";
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
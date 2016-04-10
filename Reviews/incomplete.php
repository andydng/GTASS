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
        $this_link = 'incomplete.php?session=' . $this_session;
        print "<a class = 'path-list-member active-path' href = '$this_link'>Incomplete Nominations</a>";
        
        ?>
      </li>      


      <li class = "nav-link nav-link-right"><a class = "nav-item" href="../Admin/index.php">Admin</a></li>
    </ul>
    </nav>
        
          <?php
            $member = $_SESSION['login_user'];
            $htmlOutput    = array();
            $session = $_GET["session"];
            $colsToDisplay = 5;
            $sqlA = "SELECT sid,student_email,faculty_email,first_name,last_name,rank,is_phd,new_phd,complete,verified FROM nomination WHERE session_name = '$session' and (complete = 'No' or verified = 'No')";

            $resultA = mysqli_query($db,$sqlA);

            $countA = mysqli_num_rows($resultA);

            //if result contained 1+ rows -> then generate table
            if($countA)
            {
              //printing header columns
              print '<div class ="table-title"><h3 class = "title-text">Incomplete Nominations</h3></div>';
              print '<table class = "index-table">';
              print '<tr class = "header-row"><td class = "rev-header">Nominator</td><td class = "rev-header">Student</td><td class = "rev-header">Rank</td><td class = "rev-header">Existing/New</td><td class = "rev-header">Missing Step</td></tr>';

              //beginning rows of review data for session
              while($rowA = $resultA->fetch_assoc()) 
              {
                //getting faculty nominator first/last name
                $reviewer = $_SESSION['login_user'];
                $nominator = $rowA['faculty_email'];
                $sqlB = "SELECT first_name,last_name FROM faculty WHERE email = '$nominator'";
                $resultB = mysqli_query($db,$sqlB);
                $rowB = $resultB->fetch_assoc();
                //determining value of phd/existing column
                if($rowA['is_phd'] == 'Yes')
                  $phd = "Existing";
                else
                  $phd = "New";

                if($rowA['complete'] == 'No')
                  $reason = "Incomplete";
                else
                  $reason = "Unverified";


                $sid = $rowA['sid'];
                $stu_email =  $rowA['student_email'];
                $student_name = $rowA['last_name'] . ', ' . $rowA['first_name'];
                $faculty_name = $rowB['last_name'] . ', ' . $rowB['first_name'];
                //storing row output in string to concatenate with review member columns
                $tempOutput = "<tr class = 'review-row'><td class = 'rev-cell'>{$faculty_name}</td><td class = 'rev-cell'><a target = '_blank' href = 'student_detail.php?sid='$sid'>{$student_name}</a></td><td class = 'rev-cell'>{$rowA['rank']}</td><td class = 'rev-cell'>{$phd}</td><td class = 'rev-cell'>{$reason}</td></tr>";
                
                $htmlOutput[] = $tempOutput;
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
          else
          {
            print "<div class ='no-results'><h3>There are no incomplete applications for this session</h3></div>";
          }

          ?>
        
        
      <?php
        if(isset($error) && !empty($error)){
            ?>
            <span id = "error-msg" class="error"><?= $error; ?></span>
            <?php
        }
      ?>        
    
  </body>
</html>
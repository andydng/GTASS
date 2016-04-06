<?php
   include("../../includes/mysql_connect.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 

      
      $sql = "SELECT session_name FROM session";
      $result = mysqli_query($db,$sql);
      $rows = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $rows['active'];
      $error = NULL;
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
    

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
        <a class = "path-list-member" href = "../../index.html">Home</a>
      </li>

      <li class = "nav-path">
        <span class = "path-separator path-list-member">/</span>
      </li>      
            
      <li class = "nav-path">
        <a class = "path-list-member" href = "../index-home.html">Admin</a>
      </li>

      <li class = "nav-path">
        <span class = "path-separator path-list-member">/</span>
      </li>      
            
      <li class = "nav-path">
        <a class = "path-list-member active-path" href = "index.php">Sessions</a>
      </li>      


      <li class = "nav-link nav-link-right nav-link-active"><a class = "nav-item" href="../index.php">Admin</a></li>
    </ul>
    </nav>

          <?php
            //INITIALIZE VARIABLES
            $colsToDisplay = 4;
            $htmlOutput    = array();
 
            $sql = "SELECT session_name, nom_deadline, comp_deadline, ver_deadline FROM session";
            $result = mysqli_query($db,$sql);            
            $count = mysqli_num_rows($result);

            //if result contained 1+ rows -> then generate table
            if($count)
            {
              print '<div class ="table-title"><h3 class = "title-text">Existing Sessions<h1></div>';
              print '<table class = "index-table">';
              print '<tr class = "header-row"><td class = "header">Session Name</td><td class = "header">Nomination Deadline</td><td class = "header">Completion Deadline</td><td class = "header">Verification Deadline</td></tr>';
              while($row = $result->fetch_assoc()) 
              {
                   $htmlOutput[] = "<tr><td>{$row['session_name']}</td><td>{$row['nom_deadline']}</td><td>{$row['comp_deadline']}</td><td>{$row['ver_deadline']}</td>";
              }
   
              //============================== OPTIONAL CODE =================
              //IF NEEDED, ADD MISSING COLUMNS
              /*
              $colsDifference = count($htmlOutput) % $colsToDisplay;
              if($colsDifference) 
              {
                  while($colsDifference < $colsToDisplay) 
                  {           
                    $htmlOutput[] = '<td></td>';           
                    $colsDifference++;      
                  } 
              } //========================= END: OPTIONAL CODE =================   
              */
              //BREAK THE COLUMNS INTO GROUPS 
              $htmlOutput = array_chunk($htmlOutput, $colsToDisplay);   
              //DISPLAY TABLE 
               
              foreach($htmlOutput as $currRow) 
              {      
                print implode('', $currRow); 
              } 
              print '</table>';              
            }
           
            print '<a class = "index-link" href = "create.php"><div class ="index-actions">Create<id ="span-sym"span> +</span></div></a>';
            
 
          ?>
    
  </body>
</html>
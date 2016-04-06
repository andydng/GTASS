<?php
   //include("Resources/config.php");
   include("../../includes/mysql_connect.php");
   //include("Resources/session.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {

   }
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>GTASS - Home</title>

    <!--Style sheets-->
    <link href = '../../css/style.css' rel = 'stylesheet' type = 'text/css'>

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
        <a class = "path-list-member active-path" href = "index.php">Chairs</a>
      </li>      


      <li class = "nav-link nav-link-right nav-link-active"><a class = "nav-item" href="../index.php">Admin</a></li>
    </ul>
    </nav>

          <?php
            //INITIALIZE VARIABLES
            $colsToDisplay = 2;
            $htmlOutput    = array();
 
            $sqlA = "SELECT session_name,email FROM chair";
            $result = mysqli_query($db,$sqlA);
            //$row = mysqli_fetch_array($result,MYSQLI_NUM);

            $count = mysqli_num_rows($result);

            //if result contained 1+ rows -> then generate table
            if($count)
            {
              print '<div class ="table-title"><h3 class = "title-text">Committee Chairs</h3></div>';
              print '<table class = "index-table" >';
              print '<tr class = "header-row"><td class = "header">Session</td><td class = "header">Chair</td></tr>';
              for($x = 0 ; $x <$count ; $x++) 
              { 
                  //while($row = $result->fetch_assoc())
                   $row = $result->fetch_assoc();

                  
                   //$sub_count = (string)mysqli_num_rows($sub_result);
                   $htmlOutput[] = "<tr><td>{$row['session_name']}</td><td>{$row['email']}</td>";
              }
   

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
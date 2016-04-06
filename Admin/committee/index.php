<?php
   //include("Resources/config.php");
   include("../../includes/mysql_connect.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {

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
        <a class = "path-list-member active-path" href = "index.php">Committees</a>
      </li>      


      <li class = "nav-link nav-link-right nav-link-active"><a class = "nav-item" href="../index.php">Admin</a></li>
    </ul>
    </nav>

          <?php
            //INITIALIZE VARIABLES
            $colsToDisplay = 2;
            $htmlOutput    = array();
 
            $sqlA = "SELECT session_name FROM session";
            $result = mysqli_query($db,$sqlA);
            //$row = mysqli_fetch_array($result,MYSQLI_NUM);

            $sqlB = "SELECT COUNT(email)  members FROM committee GROUP BY session_name";
            $resultB = mysqli_query($db,$sqlB);
            $rowB = mysqli_fetch_array($resultB,MYSQLI_NUM);
            $count = mysqli_num_rows($result);


            //if result contained 1+ rows -> then generate table
            if($count)
            {
              print '<div class ="table-title"><h3 class = "title-text">Committees</h3></div>';
              print '<table class = "index-table" >';
              print '<tr class = "header-row"><td class = "header">Session</td><td class = "header">Members</td></tr>';
              for($x = 0 ; $x <$count ; $x++) 
              { 
                  //while($row = $result->fetch_assoc())
                   $row = $result->fetch_assoc();

                   $row_session =  $row['session_name'];
                   $sub_query = "SELECT * FROM committee WHERE session_name='$row_session'";
                   $sub_result = mysqli_query($db,$sub_query);
                   $sub_count = (string)mysqli_num_rows($sub_result);
                   $htmlOutput[] = "<tr><td>{$row['session_name']}</td><td>". $sub_count ."</td>";
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
<?php
   include("Resources/config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      if(! get_magic_quotes_gpc() ) 
      {
        $session_name = addslashes ($_POST['session_name']);
        $nom_deadline = addslashes ($_POST['nom_deadline']);
        $com_deadline = addslashes ($_POST['com_deadline']);
        $ver_deadline = addslashes ($_POST['ver_deadline']);
      }
      else 
      {
        $session_name = addslashes ($_POST['session_name']);
        $nom_deadline = addslashes ($_POST['nom_deadline']);
        $com_deadline = addslashes ($_POST['com_deadline']);
        $ver_deadline = addslashes ($_POST['ver_deadline']);    
      }

      $sql = "INSERT INTO session ". "(session_name,nom_deadline, comp_deadline, 
        ver_deadline) ". "VALUES('$session_name','$nom_deadline','$com_deadline', '$ver_deadline')";

      $result = mysqli_query($db,$sql);

      $error = NULL;
      //$count = mysqli_num_rows($result);

      if(! $result)
      {

        $error = "Session could not be created";
      }
      else
      {
        header("location: index.php");
      }
    

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
        <a class = "path-list-member" href = "index.php">Sessions</a>
      </li>      

      <li class = "nav-path">
        <span class = "path-separator path-list-member">/</span>
      </li> 

      <li class = "nav-path nav-path-active">
        <a class = "path-list-member active-path" href = "create.php">Create</a>
      </li>             
        
   
      <li class = "nav-link nav-link-right nav-link-active"><a class = "nav-item" href="../index.php">Admin</a></li>
    </ul>
    </nav>


    <form id = "#login-form" action = "<?php $_PHP_SELF ?>" method = "post">
      <label>Session Name  :</label><input type = "text" name = "session_name" placeholder = "SpringYYYY" class = "box"/><br /><br />
      <label>Nomination Deadline  :</label><input type = "date" name = "nom_deadline" placeholder = "YYYY-MM-DD" class = "box" /><br/><br />
      <label>Completion Deadline  :</label><input type = "date" name = "com_deadline" placeholder = "YYYY-MM-DD"  class = "box" /><br/><br />
      <label>Verification Deadline  :</label><input type = "date" name = "ver_deadline" placeholder = "YYYY-MM-DD" class = "box" /><br/><br />
     
      <input type = "submit" value = " Create "/><br />
      <?php
        if(isset($error) && !empty($error)){
            ?>
            <span id = "error-msg" class="error"><?= $result; ?></span>
            <?php
        }
      ?>
    </form>
          
  </body>
</html>
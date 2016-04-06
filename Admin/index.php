<?php
   //include("Resources/config.php");
   include("../includes/mysql_connect.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT username FROM administrators WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      $error = NULL;
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
    
      if($count == 1) {
         
         $_SESSION['login_user'] = $myusername;
         
         header("location: index-home.html");
      }else {
         $error = "Invalid credentials for admin access";
         

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
      <li class = "nav-link" ><a class = "nav-item" href="../index.html">GTASS</a></li>
      <li class = "nav-link" ><a class = "nav-item" href="../Nominations/index.php">Nominations</a></li>
      <li class = "nav-link" ><a class = "nav-item" href="../Reviews/index.php">Committee Reviews</a></li>
      <li class = "nav-link nav-link-right nav-link-active"><a class = "nav-item" href="index.php">Admin</a></li>
    </ul>
    </nav>

    <form id = "#login-form" action = "" method = "post">
      <label>Username  :</label><input type = "text" name = "username" class = "box"/><br /><br />
      <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
      <input id = "submit-btn" type = "submit" value = " Submit "/><br />
      <?php
        if(isset($error) && !empty($error)){
            ?>
            <span id = "error-msg" class="error"><?= $error; ?></span>
            <?php
        }
      ?>
    </form>

  </body>
</html>
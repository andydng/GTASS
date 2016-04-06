<?php
   include("../../includes/mysql_connect.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      if(! get_magic_quotes_gpc() ) 
      {
        $first_name = addslashes ($_POST['first_name']);
        $last_name = addslashes ($_POST['last_name']);
        $email = addslashes ($_POST['email']);
        $password = addslashes ($_POST['password']);
      }
      else 
      {
        $first_name = addslashes ($_POST['first_name']);
        $last_name = addslashes ($_POST['last_name']);
        $email = addslashes ($_POST['email']);
        $password = addslashes ($_POST['password']);   
      }

      $sql = "INSERT INTO faculty ". "(email,first_name, last_name, 
        password) ". "VALUES('$email','$first_name','$last_name', '$password')";

      $result = mysqli_query($db,$sql);

      $error = NULL;
      //$count = mysqli_num_rows($result);

      if(! $result)
      {

        $error = "New faculty member could not be created";
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
        <a class = "path-list-member" href = "index.php">Faculty</a>
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
      <label>First Name  :</label><input type = "text" name = "first_name" class = "box"/><br /><br />
      <label>Last Name  :</label><input type = "text" name = "last_name" class = "box" /><br/><br />
      <label>Email  :</label><input type = "text" name = "email" placeholder = "email@domain.com"  class = "box" /><br/><br />
      <label>Password :</label><input type = "text" name = "password" placeholder = "Temp - Last Name" class = "box" /><br/><br />
     
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
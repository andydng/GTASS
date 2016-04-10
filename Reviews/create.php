<?php
   //include("Resources/config.php");
error_reporting(E_ALL);
   include("../includes/mysql_connect.php");
   session_start();
   
   $nominator = $_SESSION['login_user'];
   $session_name = "Spring2018";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
        
      if(! get_magic_quotes_gpc() ) 
      {
        $first_name = addslashes ($_POST['first_name']);
        $last_name = addslashes ($_POST['last_name']);     
        $email = addslashes ($_POST['email']);
        $rank = addslashes ($_POST['rank']); 
        $isphd = addslashes ($_POST['isphd']);
        $newphd = addslashes ($_POST['newphd']);     
      }
      else 
      {
        $first_name = addslashes ($_POST['first_name']);
        $last_name = addslashes ($_POST['last_name']);     
        $email = addslashes ($_POST['email']);
        $rank = addslashes ($_POST['rank']); 
        $isphd = addslashes ($_POST['isphd']);
        $newphd = addslashes ($_POST['newphd']);   
      }

      $sql = "INSERT INTO nomination ". "(sid,first_name,last_name,student_email,faculty_email,session_name,rank,is_phd,new_phd)"
      . "VALUES('','$first_name','$last_name','$email','$nominator','$session_name','$rank','$isphd','$newphd')";

      $result = mysqli_query($db,$sql);

      $error = NULL;
      //$count = mysqli_num_rows($result);

      if(! $result)
      {
        //Something went wrong
        $error = "Error creating nomination.";
      }
      else
      {
        //Something went right
        header("location: index-home.html");
      }
    

   }
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>GTASS - Home</title>

    <!--Style sheets-->
    <link href = '../css/style.css' rel = 'stylesheet' type = 'text/css'>
    <link href = 'Resources/style.css' rel = 'stylesheet' type = 'text/css'>

  </head>
  <body>
    <nav class="navbar">
    <ul class = "nav-list">
      <li class = "nav-link" ><a class = "nav-item" href="../index.html">GTASS</a></li>
      
      <li class = "nav-path">
        <a class = "path-list-member" href = "../index.html">Home</a>
      </li>

      <li class = "nav-path">
        <span class = "path-separator path-list-member">/</span>
      </li>      
            
      <li class = "nav-path">
        <a class = "path-list-member" href = "index-home.html">Nominations</a>
      </li>

      <li class = "nav-path">
        <span class = "path-separator path-list-member">/</span>
      </li>      
            
      <li class = "nav-path">
        <a class = "path-list-member active-path" href = "create.php">Create</a>
      </li>      

            
        
   
      <li class = "nav-link nav-link-right nav-link-active"><a class = "nav-item" href="../index.php">Admin</a></li>
    </ul>
    </nav>


    <div class ="table-title"><h3 class = "title-text">Nominee Information</h3></div>
    

    <form id = "login-form" action = "<?php $_PHP_SELF ?>" method = "post">
  
        <div class = "form-row">
        <div class = "label-format"><label>First Name  :</label></div>
        <div class = "input-format"><input type = "text" name = "first_name" class = "box"/><br /><br /></div>
      </div>
        <div class = "label-format"><label>Last Name  :</label></div>
        <div class = "input-format"><input type = "text" name = "last_name" class = "box" ><br/><br /></div>

        <div class = "label-format"><label>PID  :</label></div>
        <div class = "input-format"><input type = "text" name = "pid" class = "box" /><br/><br /></div>

        <div class = "input-format"><div class = "label-format"><label>Email  :</label></div>
        <div class = "input-format"><input type = "text" name = "email" placeholder = "email@domain.com"  class = "box" /><br/><br /></div>
        
        <div class = "label-format"><label>Rank :</label></div>
        <div class = "input-format">
          <select name="rank" form="login-form" class="dropdown box">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
          </select><br/><br />
        </div>
      
      
        
          <div class = "label-format"><label  >Current Ph.D.? :</label></div>
          
            <div class = "radio-options">
              <input type="radio" name="isphd" value="Y" checked> Yes
              <input type="radio" name="isphd" value="N"> No <br />
            </div>
        
      
      
        
         <div class = "label-format"><label>New Ph.D.? :</label></div>
      
            <div class = "radio-options">
              <input type="radio" name="newphd" value="Y" checked> Yes
              <input type="radio" name="newphd" value="N"> No <br />
            </div>
        
      
          
      
      

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
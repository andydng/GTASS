<?php
   include("../../includes/mysql_connect.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form


        
      if(! get_magic_quotes_gpc() ) 
      {
        $email = addslashes ($_POST['email']);
        $session = addslashes ($_POST['session_name']);

      }
      else 
      {
        $email = addslashes ($_POST['email']);
        $session = addslashes ($_POST['session_name']); 
      }

      $sql = "INSERT INTO committee ". "(email,session_name,password)"
      . "VALUES('$email','$session','$email')";

      $result = mysqli_query($db,$sql);

      $error = NULL;
      //$count = mysqli_num_rows($result);

      if(! $result)
      {

        $error = "New committee member could not be created";
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
        <a class = "path-list-member" href = "index.php">Committees</a>
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
      <label>Email :</label>
        <select name = "email" class = "box" id = "myList">
          <option selected="selected">Select Faculty</option>
          <?php
            $res=$db->query("SELECT email FROM faculty");
            while($row=$res->fetch_array())
            {
             ?>
                <option value="<?php echo $row['email']; ?>"><?php echo $row['email']; ?></option>
                <?php
            }
            ?>
        </select><br/><br />
      <label>Session :</label>
        <select name = "session_name" class = "box" id = "myList">
          <option selected="selected">Select Session</option>
          <?php
            $res=$db->query("SELECT session_name FROM session ");
            //Select * from P left join Q on P.id = Q.id where Q.id is NULL
            while($row=$res->fetch_array())
            {
             ?>
                <option value="<?php echo $row['session_name']; ?>"><?php echo $row['session_name']; ?></option>
                <?php
            }
            ?>





        </select><br/><br />     
     
      <input type = "submit" value = " Create "/><br />
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
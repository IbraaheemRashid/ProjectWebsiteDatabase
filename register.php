<?php
//if the form has been submitted
if (isset($_POST['submitted'])){
 #prepare the form input

  // connect to the database
  require_once('connectdb.php');
	
  $username = isset($_POST['username']) ? $_POST['username'] : false;
  $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : false;
  $email = isset($_POST['email']) ? $_POST['email'] : false;
  
  if (!($username)){
    exit("Username wrong!");
  }
  
  if (!($password)){
    exit("Password wrong!");
  }
  
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Invalid email address!");
  }

  try{
    #register user by inserting the user info 
    $stat = $db->prepare("insert into users values(default,?,?,?)");
    $stat->execute(array($username, $password, $email));
    $id = $db->lastInsertId();
    echo "Congratulations! You are now registered. Your ID is: $id  ";  	
  }
  catch (PDOexception $ex){
    echo "Sorry, a database error occurred! <br>";
    echo "Error details: <em>". $ex->getMessage()."</em>";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration System </title>
  
	<h3><a href = "project.php">View Projects</a></h3>
  <h3><a href="index.php">Login </a></h3>	
	<h3>Register</h3>
</head>
<body>
  <form method="post" action="register.php">
    Username: <input type="text" name="username" /><br>
    Password: <input type="password" name="password" /><br>
    Email: <input type="email" name="email" /><br><br>

    <input type="submit" value="Register" /> 
    <input type="reset" value="clear"/>
    <input type="hidden" name="submitted" value="true"/>
  </form>  
 
</body>
</html>

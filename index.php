<?php

	//if the form has been submitted
	if (isset($_POST['submitted'])){
		if ( !isset($_POST['username'], $_POST['password']) ) {
		// Could not get the data that should have been sent.
		 exit('Please fill both the username and password fields!');
	    }
		// connect DB
		require_once ("connectdb.php");
		try {
		//Query DB to find the matching username/password
		//using prepare/bindparameter to prevent SQL injection.
			$stat = $db->prepare('SELECT password FROM users WHERE username = ?');
			$stat->execute(array($_POST['username']));
		    
			// fetch the result row and check 
			if ($stat->rowCount()>0){  // matching username
				$row=$stat->fetch();

				if (password_verify($_POST['password'], $row['password'])){ //matching password
					
					//??recording the user session variable and go to loggedin page?? 
				  session_start();
					$_SESSION["username"]=$_POST['username'];
					header("Location:myprojects.php");
					exit();
				
				} else {
				 echo "<p style='color:red'>Error logging in, password does not match </p>";
 			    }
		    } else {
			 //else display an error
			  echo "<p style='color:red'>Error logging in, Username not found </p>";
		    }
		}
		catch(PDOException $ex) {
			echo("Failed to connect to the database.<br>");
			echo($ex->getMessage());
			exit;
		}

  }
?>
<!-- a HTML part -->
<html>
<head>
	<title>Login</title>
</head>

	
	<h3><a href = "project.php">View Projects</a></h3>
	<h3>Login </h3>	
	<h3><a href = "register.php">Register</a></h3>

<body>
<!-- a HTML form that allows the user to enter their username and password for log in.-->
<form action="index.php" method="post">

	<label>User Name</label>
	<input type="text" name="username" size="15" maxlength="25" />
    <label>Password:</label>
	<input type="password" name="password" size="15" maxlength="25" />
	<input type="hidden" name="uid" value="<?php echo $_SESSION['uid']; ?>">
	
	<input type="submit" value="Login" />
	<input type="reset" value="clear"/>
    <input type="hidden" name="submitted" value="TRUE" />
	

</form>
</body>
</html>

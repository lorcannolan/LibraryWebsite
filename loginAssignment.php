<!DOCTYPE html>
<html>
<head>
<?php 
	include("header.html");
 ?>
<title>Login</title>
<style>
#below
	{
		text-align: center;
		margin: auto;
	}
</style>
</head>
<body>

<?php

	include("connectionAssignment.php");
	session_start();
	$error = '';
   
	if($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		// username and password sent from form 
      
		$myusername = mysqli_real_escape_string($con,$_POST['username']);
		$mypassword = mysqli_real_escape_string($con,$_POST['psw']); 
		
		$sql = "SELECT UserName FROM users WHERE UserName = '$myusername' AND Password = '$mypassword'";
		$result = mysqli_query($con,$sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$active = $row['active'];
		
		
		$count = mysqli_num_rows($result);
		
		// If result matched $myusername and $mypassword, table row must be 1 row
		
		if($count == 1) 
		{
			//session_register("myusername");
			$_SESSION['login_user'] = $myusername;
			header("location: search.php");
		}
		else
		{
			$error = "Your Login Name or Password is invalid. Please Register your details.";
		}
	}
?>

<form action = "" method = "post" class = "center">
	Username: <input type = "text" name = "username" required><br/><br/>
	Password: <input type = "password" name = "psw" required><br/><br/>
		
	<div>
		<input type = "submit" value = "Login"/>
	</div>

</form>

	<div id = "below">
		<a href="register.php"><button>Register</button></a><br/>
	</div>

<div id = "below">

<?php
	echo "</br>";
	echo $error;
?>

</div>

</body>

<footer>
	<?php include("footer.html"); ?>
</footer>

</html>
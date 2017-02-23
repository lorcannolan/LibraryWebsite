<!DOCTYPE html>
<html>
<head>
<?php include("header.html"); ?>
<title>Register</title>
<style>
#below
	{
		text-align: center;
		margin: auto;
	}
</style>
</head>
<body>

<form action = "registering.php" method = "post" class = "center">
	<label>
		Username: <input type="text" name="username" required/><br/>
	</label>
	<label>
		Password: (6 characters)<input type="text" name="psw" required/><br/>
	</label>
	<label>
		Firstname: <input type="text" name="firstname" required/><br/>
	</label>
	<label>
		Surname: <input type="text" name="surname" required/><br/>
	</label>
	<label>
		Address Line 1: <input type="text" name="aLine1" required/><br/>
	</label>
	<label>
		Address Line 2: <input type="text" name="aLine2" required/><br/>
	</label>
	<label>
		City: <input type="text" name="city" required/><br/>
	</label>
	<label>
		Telephone: (7 digits max)<input type="text" name="telephone" required/><br/>
	</label>
	<label>
		Mobile: (10 digits max)<input type="text" name="mobile" required/><br/>
	</label>
	<input type="submit">
</form>

</body>
<footer>
	<?php include("footer.html"); ?>
</footer>
</html>
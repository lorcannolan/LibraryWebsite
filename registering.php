<!DOCTYPE html>
<html>
<head>
<title>Register</title>
</head>
<body>
<?php

	include("connectionAssignment.php");
	header("location: loginAssignment.php");
	if ( isset($_POST['username']) && isset($_POST['psw'])
			&& isset($_POST['firstname']) && isset($_POST['surname']) 
			&& isset($_POST['aLine1']) && isset($_POST['aLine2'])
			&& isset($_POST['city']) && isset($_POST['telephone'])
			&& isset($_POST['mobile']))
	{
		$myusername = $_POST['username'];
		$mypassword = $_POST['psw'];
		$firstName = $_POST['firstname'];
		$surName = $_POST['surname'];
		$address1 = $_POST['aLine1'];
		$address2 = $_POST['aLine2'];
		$City = $_POST['city'];
		$telePhone = $_POST['telephone'];
		$Mobile = $_POST['mobile'];
		$sql = "INSERT INTO users (UserName, Password, FirstName, Surname, AddressLine1,
				AddressLine2, City, Telephone, Mobile)
				VALUES ('$myusername', '$mypassword', '$firstName', '$surName', 
				'$address1', '$address2', '$City', '$telePhone', '$Mobile')";
		mysqli_query($con, $sql);
	}//end if
	else
	{
		echo "Please input data into all fields";
	}//end else
	mysqli_close($con);
?>
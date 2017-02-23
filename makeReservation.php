<?php
	include('sessionAssignment.php');
	include("connectionAssignment.php");
	
	if (isset($_POST['isbn']))
	{
		header("location: viewReserve.php");
		
		$isbn = $_POST['isbn'];
		
		$sql = "UPDATE books SET Reserved = 'Y' WHERE ISBN ='$isbn'";
		
		mysqli_query($con, $sql);
		
		$date = date("Y-m-d");
		
		$sql2 = "INSERT INTO reservations (ISBN, UserName) VALUES ('$isbn', '$login_session')";

		mysqli_query($con, $sql2);
	}
	
	
?>
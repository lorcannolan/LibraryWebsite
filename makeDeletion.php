<?php
	include('sessionAssignment.php');
	include("connectionAssignment.php");
	
	if ( isset($_POST['delete']) && isset($_POST['isbn']) )
	{
		header("location: viewReserve.php");
		
		$isbn = $_POST['isbn'];
		
		$sql = "UPDATE books SET Reserved = 'N' WHERE ISBN ='$isbn'";
		
		mysqli_query($con, $sql);

	}
?>
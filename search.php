<?php
	include('sessionAssignment.php');
	include("connectionAssignment.php");
	include("header.html");
	
	$result = mysqli_query($con, "SELECT CategoryDescription FROM categories");
	
	$categories = array();
	
	while($row = mysqli_fetch_array($result))
	{
		$categories[] = $row['CategoryDescription'];
	}
	
?>
<html>
   
	<head>
		<title>Main Menu</title>
	</head>
   
	<body>
		<h3 style="text-align:center;">Logged in as: <?php echo $login_session; ?></h3></br>
		
		<form action="searching.php" method="post" class = "center">
			Category: <select name = "category">
				<option value = "default">None</option>
				<?php
					foreach ($categories as $x)
					{
						echo "<option>";
						echo ($x);
						echo "</option>";
					}
				?>
			</select></br>
			<p style="padding:10px;">Book Name: <input type="text" name="book"/><br/>
			Author: <input type="text" name="author"/><br/>
			<input type="submit">
		</form>

	</body>
   
   <footer>
	<?php include("footer.html"); ?>
	</footer>
	
</html>
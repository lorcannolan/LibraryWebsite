<?php
	include('sessionAssignment.php');
	include("connectionAssignment.php");
	include("header.html");
?>

<html>
   
	<head>
		<title>View Reserved Books</title>
	</head>
	
	<body>
		
		<?php
			echo '<h3 style="text-align:center;">Logged in as: ';
			echo $login_session;
			echo "</h3></br>";
			
			$sql_col_names = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
							FROM books 
							JOIN categories USING (CategoryID)";
							
			if ($res = mysqli_query($con, $sql_col_names))
			{
				// Get field information for all fields
				$columnName = mysqli_fetch_fields($res);
				
				echo "<table><tr>";
				foreach ($columnName as $col)
				{
					echo "<td><strong>";
					echo ($col->name);
					echo "</strong></td>";
				}
				echo "<td><strong>Delete</strong></td>";
				echo "</tr>";
			}
			
			$sql_reserved = "SELECT ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
							FROM books
							JOIN reservations USING (ISBN)
							JOIN categories USING (CategoryID)
							WHERE UserName like '$login_session'
							AND Reserved like 'Y'";
			
			$search_reserved = mysqli_query($con, $sql_reserved);
		
			while($row2 = mysqli_fetch_array($search_reserved))
			{
				echo "<tr><td>";
				echo $row2['ISBN'];
				echo "</td><td>";
				echo $row2['BookTitle'];
				echo "</td><td>";
				echo $row2['Author'];
				echo "</td><td>";
				echo $row2['Edition'];
				echo "</td><td>";
				echo $row2['Year'];
				echo "</td><td>";
				echo $row2['Reserved'];
				echo "</td><td>";
				echo $row2['CategoryDescription'];
				echo '</td><td><form action="makeDeletion.php" method="post">';
				echo '<input type="hidden" name="isbn" value="'.$row2['ISBN'].'">';
				echo '<input type="Submit" value="Del" name="delete">';
				echo "</form></td></tr>";
			}//end while
			echo "</table>";
		?>
		
	</body>
	
	<footer>
		<?php include("footer.html"); ?>
	</footer>
   
</html>
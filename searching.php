<!DOCTYPE html>
<html>
<head>
<title>Search</title>
<style>
#side_by_side
	{
		display: inline-block;
		padding: 5px;
		text_align: center;
	}
#below
	{
		clear: both;
	}
</style>
</head>
<body>
<?php
	include('sessionAssignment.php');
	include("connectionAssignment.php");
	include("header.html");
	echo '<h3 style="text-align:center;">Logged in as: ';
	echo $login_session;
	echo "</h3></br>";

	$sql_col_names = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
							FROM books 
							JOIN categories USING (CategoryID)";

	if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST['book']) && empty($_POST['author']))
	{
		if ($_POST['category'] == 'default')
		{
			if (isset($_GET['page']))
			{
				$page = $_GET['page'];
				$page = mysql_real_escape_string($page);
			}
			else
			{
				$page = 1;
			}
			
			$search_cols = mysqli_query($con, $sql_col_names);
			$rows = mysqli_num_rows($search_cols);
			
			$per_page = 5;
			
			$total_pages = ceil($rows / $per_page);
			
			echo "<p>You are on page $page of $total_pages</p>";
			echo "</br>";
			
			if ($page != 1)
			{
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page=1" ><input type="hidden"><input type = "hidden" name = "category" value="default">';
				echo '<input type = "submit" value = "First" name = "submit"></form>';
				echo '</div>';
				$previous = $page - 1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$previous.'" ><input type="hidden"><input type = "hidden" name = "category" value="default">';
				echo '<input type = "submit" value = "Previous" name = "submit"></form>';
				echo '</div>';
			}
			
			if (($page != 1) && ($page != $total_pages))
			{
				echo '<div id = "side_by_side">';
				echo " | ";
				echo '</div>';
			}
			
			if ($page != $total_pages)
			{
				$next = $page+1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$next.'" ><input type="hidden"><input type = "hidden" name = "category" value="default">';
				echo '<input type = "submit" value = "Next" name = "submit"></form>';
				echo '</div>';
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$total_pages.'" ><input type="hidden"><input type = "hidden" name = "category" value="default">';
				echo '<input type = "submit" value = "Last" name = "submit"></form>';
				echo '</div>';
			}
			
			echo '<div id = "below">';
			
			$start_page = ($page - 1) * $per_page;
		
			$sql_main = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
							FROM books 
							JOIN categories USING (CategoryID)
							LIMIT $start_page, $per_page";
							
			$search_main = mysqli_query($con, $sql_main);
	
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
				echo "<td><strong>Reserve</strong></td>";
				echo "</tr>";
			}
			
			while($row2 = mysqli_fetch_array($search_main))
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
				if ($row2['Reserved'] == 'N')
				{
					echo '</td><td><form action="makeReservation.php" method="post">';
					echo '<input type="hidden" name="isbn" value="'.$row2['ISBN'].'">';
					echo '<input type="Submit" value="Res" name="reserve">';
				}
				echo "</form></td></tr>";
			}//end while
			echo "</table>";
			echo '</div>';
		}
		else
		{
			$category = $_POST['category'];
			if (isset($_GET['page']))
			{
				$page = $_GET['page'];
				$page = mysql_real_escape_string($page);
			}
			else
			{
				$page = 1;
			}
			
			$search_cols = mysqli_query($con, $sql_col_names);
			
			$sql_row_nums = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
							FROM books 
							JOIN categories USING (CategoryID)
							WHERE CategoryDescription LIKE '$_POST[category]'";
			
			$search_rows = mysqli_query($con, $sql_row_nums);
			
			$rows = mysqli_num_rows($search_rows);
			
			$per_page = 5;
			
			$total_pages = ceil($rows / $per_page);
			
			echo "<p>You are on page $page of $total_pages</p>";
			echo "</br>";
			
			if ($page != 1)
			{
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page=1" ><input type="hidden"><input type = "hidden" name = "category" value="'.$category.'">';
				echo '<input type = "submit" value = "First" name = "submit"></form>';
				echo '</div>';
				$previous = $page - 1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$previous.'" ><input type="hidden"><input type = "hidden" name = "category" value="'.$category.'">';
				echo '<input type = "submit" value = "Previous" name = "submit"></form>';
				echo '</div>';
			}
			
			if (($page != 1) && ($page != $total_pages))
			{
				echo '<div id = "side_by_side">';
				echo " | ";
				echo '</div>';
			}
			
			if ($page != $total_pages)
			{
				$next = $page+1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$next.'" ><input type="hidden"><input type = "hidden" name = "category" value="'.$category.'">';
				echo '<input type = "submit" value = "Next" name = "submit"></form>';
				echo '</div>';
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$total_pages.'" ><input type="hidden"><input type = "hidden" name = "category" value="'.$category.'">';
				echo '<input type = "submit" value = "Last" name = "submit"></form>';
				echo '</div>';
			}
			
			echo '<div id = "below">';
			
			$start_page = ($page - 1) * $per_page;
			
			$sql_main = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
							FROM books 
							JOIN categories USING (CategoryID)
							WHERE CategoryDescription LIKE '$_POST[category]'
							LIMIT $start_page, $per_page";
			
			$search_main = mysqli_query($con, $sql_main);
		
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
				echo "<td><strong>Reserve</strong></td>";
				echo "</tr>";
			}
			
			while($row2 = mysqli_fetch_array($search_main))
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
				if ($row2['Reserved'] == 'N')
				{
					echo '</td><td><form action="makeReservation.php" method="post">';
					echo '<input type="hidden" name="isbn" value="'.$row2['ISBN'].'">';
					echo '<input type="Submit" value="Res" name="reserve">';
				}
				echo "</form></td></tr>";
			}//end while
			echo "</table>";
			echo '</div>';
		}
		echo "</br>";
		echo "<a href='search.php' style='margin:auto;'>Search another book</a>";
	}
	
	elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['book']) && empty($_POST['author']))
	{
		$category = $_POST['category'];
		//if category is none and book search bar is used
		if ($category == 'default')
		{
			$book = $_POST['book'];
			$search_cols = mysqli_query($con, $sql_col_names);
			
			$sql_row_nums = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
								FROM books 
								JOIN categories USING (CategoryID)
								WHERE BookTitle LIKE '%$_POST[book]%'";
			
			$search_rows = mysqli_query($con, $sql_row_nums);
				
			$rows = mysqli_num_rows($search_rows);
			
			$per_page = 5;
			
			$total_pages = ceil($rows / $per_page);
			
			if (isset($_GET['page']))
			{
				$page = $_GET['page'];
				$page = mysql_real_escape_string($page);
				if ($page > $total_pages)
				{
					$page = 1;
				}
			}
			else
			{
				$page = 1;
			}
			
			echo "<p>You are on page $page of $total_pages</p>";
			echo "</br>";
			
			if ($page != 1)
			{
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page=1" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "First" name = "submit"></form>';
				echo '</div>';
				$previous = $page - 1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$previous.'" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Previous" name = "submit"></form>';
				echo '</div>';
			}
			
			if (($page != 1) && ($page != $total_pages))
			{
				echo '<div id = "side_by_side">';
				echo " | ";
				echo '</div>';
			}
			
			if ($page != $total_pages)
			{
				$next = $page+1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$next.'" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Next" name = "submit"></form>';
				echo '</div>';
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$total_pages.'" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Last" name = "submit"></form>';
				echo '</div>';
			}
			echo '<div id = "below">';
			
			$start_page = ($page - 1) * $per_page;
			
			$sql_main = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
								FROM books 
								JOIN categories USING (CategoryID)
								WHERE BookTitle LIKE '%$_POST[book]%'
								LIMIT $start_page, $per_page";
								
			$search_main = mysqli_query($con, $sql_main);
		
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
				echo "<td><strong>Reserve</strong></td>";
				echo "</tr>";
			}
			
			while($row2 = mysqli_fetch_array($search_main))
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
				if ($row2['Reserved'] == 'N')
				{
					echo '</td><td><form action="makeReservation.php" method="post">';
					echo '<input type="hidden" name="isbn" value="'.$row2['ISBN'].'">';
					echo '<input type="Submit" value="Res" name="reserve">';
				}
				echo "</form></td></tr>";
			}//end while
			echo "</table>";
			echo '</div>';
			echo "</br>";
			echo "<a href='search.php'>Search another book</a>";
		}
		else
		{
			$book = $_POST['book'];
			$search_cols = mysqli_query($con, $sql_col_names);
		
			$sql_row_nums = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
							FROM books 
							JOIN categories USING (CategoryID)
							WHERE BookTitle LIKE '%$_POST[book]%'
							AND CategoryDescription LIKE '$_POST[category]'";
							
			$search_rows = mysqli_query($con, $sql_row_nums);
				
			$rows = mysqli_num_rows($search_rows);
			
			$per_page = 5;
			
			$total_pages = ceil($rows / $per_page);
			
			if (isset($_GET['page']))
			{
				$page = $_GET['page'];
				$page = mysql_real_escape_string($page);
				if ($page > $total_pages)
				{
					$page = 1;
				}
			}
			else
			{
				$page = 1;
			}
			
			echo "<p>You are on page $page of $total_pages</p>";
			echo "</br>";
			
			if ($page != 1)
			{
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page=1" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "First" name = "submit"></form>';
				echo '</div>';
				$previous = $page - 1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$previous.'" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Previous" name = "submit"></form>';
				echo '</div>';
			}
			
			if (($page != 1) && ($page != $total_pages))
			{
				echo '<div id = "side_by_side">';
				echo " | ";
				echo '</div>';
			}
			
			if ($page != $total_pages)
			{
				$next = $page+1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$next.'" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Next" name = "submit"></form>';
				echo '</div>';
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$total_pages.'" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Last" name = "submit"></form>';
				echo '</div>';
			}
			echo '<div id = "below">';
			
			$start_page = ($page - 1) * $per_page;
			
			$sql_main = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
						FROM books 
						JOIN categories USING (CategoryID)
						WHERE BookTitle LIKE '%$_POST[book]%'
						AND CategoryDescription LIKE '$_POST[category]'
						LIMIT $start_page, $per_page";
			
			$search_main = mysqli_query($con, $sql_main);
		
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
				echo "<td><strong>Reserve</strong></td>";
				echo "</tr>";
			}
			
			while($row2 = mysqli_fetch_array($search_main))
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
				if ($row2['Reserved'] == 'N')
				{
					echo '</td><td><form action="makeReservation.php" method="post">';
					echo '<input type="hidden" name="isbn" value="'.$row2['ISBN'].'">';
					echo '<input type="Submit" value="Res" name="reserve">';
				}
				echo "</form></td></tr>";
			}//end while
			echo "</table>";
			echo '</div>';
			echo "</br>";
			echo "<a href='search.php'>Search another book</a>";
		}
	}
	
	elseif ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST['book']) && !empty($_POST['author']))
	{
		$category = $_POST['category'];
		//if category is none and author search bar is used
		if ($category == 'default')
		{
			$author = $_POST['author'];
			$search_cols = mysqli_query($con, $sql_col_names);
			
			$sql_row_nums = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
							FROM books 
							JOIN categories USING (CategoryID)
							WHERE Author LIKE '%$_POST[author]%'";
			
			$search_rows = mysqli_query($con, $sql_row_nums);
			
			$rows = mysqli_num_rows($search_rows);
			
			$per_page = 5;
			
			$total_pages = ceil($rows / $per_page);
			
			if (isset($_GET['page']))
			{
				$page = $_GET['page'];
				$page = mysql_real_escape_string($page);
				if ($page > $total_pages)
				{
					$page = 1;
				}
			}
			else
			{
				$page = 1;
			}
			
			echo "<p>You are on page $page of $total_pages</p>";
			echo "</br>";
			
			if ($page != 1)
			{
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page=1" ><input type="hidden"><input type = "hidden" name = "author" value="'.$author.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "First" name = "submit"></form>';
				echo '</div>';
				$previous = $page - 1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$previous.'" ><input type="hidden"><input type = "hidden" name = "author" value="'.$author.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Previous" name = "submit"></form>';
				echo '</div>';
			}
			
			if (($page != 1) && ($page != $total_pages))
			{
				echo '<div id = "side_by_side">';
				echo " | ";
				echo '</div>';
			}
			
			if ($page != $total_pages)
			{
				$next = $page+1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$next.'" ><input type="hidden"><input type = "hidden" name = "author" value="'.$author.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Next" name = "submit"></form>';
				echo '</div>';
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$total_pages.'" ><input type="hidden"><input type = "hidden" name = "author" value="'.$author.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Last" name = "submit"></form>';
				echo '</div>';
			}
			echo '<div id = "below">';
			
			$start_page = ($page - 1) * $per_page;
			
			$sql_main = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
						FROM books 
						JOIN categories USING (CategoryID)
						WHERE Author LIKE '%$_POST[author]%'
						LIMIT $start_page, $per_page";
			
			$search_main = mysqli_query($con, $sql_main);
			
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
				echo "<td><strong>Reserve</strong></td>";
				echo "</tr>";
			}
			
			while($row2 = mysqli_fetch_array($search_main))
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
				if ($row2['Reserved'] == 'N')
				{
					echo '</td><td><form action="makeReservation.php" method="post">';
					echo '<input type="hidden" name="isbn" value="'.$row2['ISBN'].'">';
					echo '<input type="Submit" value="Res" name="reserve">';
				}
				echo "</form></td></tr>";
			}//end while
			echo "</table>";
			echo '</div>';
			echo "</br>";
			echo "<a href='search.php'>Search another book</a>";
		}
		else
		{
			$author = $_POST['author'];
			$search_cols = mysqli_query($con, $sql_col_names);
		
			$sql_row_nums = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
					FROM books 
					JOIN categories USING (CategoryID)
					WHERE Author LIKE '%$_POST[author]%'
					AND CategoryDescription LIKE '$_POST[category]'";
					
			$search_rows = mysqli_query($con, $sql_row_nums);
			
			$rows = mysqli_num_rows($search_rows);
			
			$per_page = 5;
						
			$total_pages = ceil($rows / $per_page);
						
			if (isset($_GET['page']))
			{
				$page = $_GET['page'];
				$page = mysql_real_escape_string($page);
				if ($page > $total_pages)
				{
					$page = 1;
				}
			}
			else
			{
				$page = 1;
			}
						
			echo "<p>You are on page $page of $total_pages</p>";
			echo "</br>";
					
			if ($page != 1)
			{
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page=1" ><input type="hidden"><input type = "hidden" name = "author" value="'.$author.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "First" name = "submit"></form>';
				echo '</div>';
				$previous = $page - 1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$previous.'" ><input type="hidden"><input type = "hidden" name = "author" value="'.$author.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Previous" name = "submit"></form>';
				echo '</div>';
			}
					
			if (($page != 1) && ($page != $total_pages))
			{
				echo '<div id = "side_by_side">';
				echo " | ";
				echo '</div>';
			}
			
			if ($page != $total_pages)
			{
				$next = $page+1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$next.'" ><input type="hidden"><input type = "hidden" name = "author" value="'.$author.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Next" name = "submit"></form>';
				echo '</div>';
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$total_pages.'" ><input type="hidden"><input type = "hidden" name = "author" value="'.$author.'">
				<input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Last" name = "submit"></form>';
				echo '</div>';
			}
			echo '<div id = "below">';
			
			$start_page = ($page - 1) * $per_page;
			
			$sql_main = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
						FROM books 
						JOIN categories USING (CategoryID)
						WHERE Author LIKE '%$_POST[author]%'
						AND CategoryDescription LIKE '$_POST[category]'
						LIMIT $start_page, $per_page";
			
			$search_main = mysqli_query($con, $sql_main);
			
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
				echo "<td><strong>Reserve</strong></td>";
				echo "</tr>";
			}
			
			while($row2 = mysqli_fetch_array($search_main))
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
				if ($row2['Reserved'] == 'N')
				{
					echo '</td><td><form action="makeReservation.php" method="post">';
					echo '<input type="hidden" name="isbn" value="'.$row2['ISBN'].'">';
					echo '<input type="Submit" value="Res" name="reserve">';
				}
				echo "</form></td></tr>";
			}//end while
			echo "</table>";
			echo '</div>';
			echo "</br>";
			echo "<a href='search.php'>Search another book</a>";
		}
	}
	
	elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['book']) && !empty($_POST['author']))
	{
		$category = $_POST['category'];
		if ($category == 'default')
		{
			$book = $_POST['book'];
			$author = $_POST['author'];
			$search_cols = mysqli_query($con, $sql_col_names);
			
			$sql_row_nums = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
							FROM books 
							JOIN categories USING (CategoryID)
							WHERE Author LIKE '%$_POST[author]%'
							AND BookTitle LIKE '%$_POST[book]%'";
			
			$search_rows = mysqli_query($con, $sql_row_nums);
				
			$rows = mysqli_num_rows($search_rows);
			
			$per_page = 5;
			
			$total_pages = ceil($rows / $per_page);
			
			if (isset($_GET['page']))
			{
				$page = $_GET['page'];
				$page = mysql_real_escape_string($page);
				if ($page > $total_pages)
				{
					$page = 1;
				}
			}
			else
			{
				$page = 1;
			}
			
			echo "<p>You are on page $page of $total_pages</p>";
			echo "</br>";
			
			if ($page != 1)
			{
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page=1" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type = "hidden" name = "author" value="'.$author.'"><input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "First" name = "submit"></form>';
				echo '</div>';
				$previous = $page - 1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$previous.'" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type = "hidden" name = "author" value="'.$author.'"><input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Previous" name = "submit"></form>';
				echo '</div>';
			}
			
			if (($page != 1) && ($page != $total_pages))
			{
				echo '<div id = "side_by_side">';
				echo " | ";
				echo '</div>';
			}
			
			if ($page != $total_pages)
			{
				$next = $page+1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$next.'" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type = "hidden" name = "author" value="'.$author.'"><input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Next" name = "submit"></form>';
				echo '</div>';
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$total_pages.'" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type = "hidden" name = "author" value="'.$author.'"><input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Last" name = "submit"></form>';
				echo '</div>';
			}
			echo '<div id = "below">';
			
			$start_page = ($page - 1) * $per_page;
			
			$sql_main = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
						FROM books 
						JOIN categories USING (CategoryID)
						WHERE Author LIKE '%$_POST[author]%'
						AND BookTitle LIKE '%$_POST[book]%'
						LIMIT $start_page, $per_page";
			
			$search_main = mysqli_query($con, $sql_main);
			
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
				echo "<td><strong>Reserve</strong></td>";
				echo "</tr>";
			}
			
			while($row2 = mysqli_fetch_array($search_main))
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
				if ($row2['Reserved'] == 'N')
				{
					echo '</td><td><form action="makeReservation.php" method="post">';
					echo '<input type="hidden" name="isbn" value="'.$row2['ISBN'].'">';
					echo '<input type="Submit" value="Res" name="reserve">';
				}
				echo "</form></td></tr>";
			}//end while
			echo "</table>";
			echo '</div>';
			echo "</br>";
			echo "<a href='search.php'>Search another book</a>";
		}
		else
		{
			$book = $_POST['book'];
			$author = $_POST['author'];
			$search_cols = mysqli_query($con, $sql_col_names);
		
			$sql_row_nums = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
							FROM books 
							JOIN categories USING (CategoryID)
							WHERE Author LIKE '%$_POST[author]%'
							AND BookTitle LIKE '%$_POST[book]%'
							AND CategoryDescription LIKE '$_POST[category]'";
			
			$search_rows = mysqli_query($con, $sql_row_nums);
			
			$rows = mysqli_num_rows($search_rows);
			
			$per_page = 5;
			
			$total_pages = ceil($rows / $per_page);
			
			if (isset($_GET['page']))
			{
				$page = $_GET['page'];
				$page = mysql_real_escape_string($page);
				if ($page > $total_pages)
				{
					$page = 1;
				}
			}
			else
			{
				$page = 1;
			}
			
			echo "<p>You are on page $page of $total_pages</p>";
			echo "</br>";
			
			if ($page != 1)
			{
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page=1" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type = "hidden" name = "author" value="'.$author.'"><input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "First" name = "submit"></form>';
				echo '</div>';
				$previous = $page - 1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$previous.'" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type = "hidden" name = "author" value="'.$author.'"><input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Previous" name = "submit"></form>';
				echo '</div>';
			}
			
			if (($page != 1) && ($page != $total_pages))
			{
				echo '<div id = "side_by_side">';
				echo " | ";
				echo '</div>';
			}
			
			if ($page != $total_pages)
			{
				$next = $page+1;
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$next.'" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type = "hidden" name = "author" value="'.$author.'"><input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Next" name = "submit"></form>';
				echo '</div>';
				echo '<div id = "side_by_side">';
				echo '<form method = "post" action = "'.$_SERVER['PHP_SELF'].'?page='.$total_pages.'" ><input type="hidden"><input type = "hidden" name = "book" value="'.$book.'">
				<input type = "hidden" name = "author" value="'.$author.'"><input type="hidden" name="category" value="'.$category.'">';
				echo '<input type = "submit" value = "Last" name = "submit"></form>';
				echo '</div>';
			}
			echo '<div id = "below">';
			
			$start_page = ($page - 1) * $per_page;
			
			$sql_main = "select ISBN, BookTitle, Author, Edition, Year, Reserved, CategoryDescription
						FROM books 
						JOIN categories USING (CategoryID)
						WHERE Author LIKE '%$_POST[author]%'
						AND BookTitle LIKE '%$_POST[book]%'
						AND CategoryDescription LIKE '$_POST[category]'
						LIMIT $start_page, $per_page";
			
			$search_main = mysqli_query($con, $sql_main);
			
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
				echo "<td><strong>Reserve</strong></td>";
				echo "</tr>";
			}
			
			while($row2 = mysqli_fetch_array($search_main))
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
				if ($row2['Reserved'] == 'N')
				{
					echo '</td><td><form action="makeReservation.php" method="post">';
					echo '<input type="hidden" name="isbn" value="'.$row2['ISBN'].'">';
					echo '<input type="Submit" value="Res" name="reserve">';
				}
				echo "</form></td></tr>";
			}//end while
			echo "</table>";
			echo '</div>';
			echo "</br>";
			echo "<a href='search.php'>Search another book</a>";
		}
	}
?>

</body>

<footer>
	<?php include("footer.html"); ?>
</footer>

</html>
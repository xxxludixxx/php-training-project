<!-- Database connection -->
<?php require_once ("../includes/db_connection.php"); ?>
<!-- PHP Functions -->
<?php require_once("../includes/functions.php"); ?>
<!-- Database query -->
<?php
	$query  = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "WHERE visible = 1 ";
	$query .= "ORDER BY position ASC";
	$result = mysqli_query($connection, $query);
	confirm_query($result);
?>
<!-- Header -->
<?php include("../includes/layouts/header.php"); ?>
<!-- Main content -->
<div id="main">
	<div id="navigation">
		<ul class="subjects">
			<?php
				// Use returned data to create navigation
				while($subject = mysqli_fetch_assoc($result)) {
					// output data from each row
					?>
					<li><?php echo $subject["menu_name"]?></li>
					<?php
				}
			?>
		</ul>
	</div>
	<div id="page">
		<h2>Manage Content</h2>
	</div>
</div>
<!-- Release returned data -->
<?php
	mysqli_free_result($result);
?>
<!-- Footer -->
<?php include("../includes/layouts/footer.php"); ?>
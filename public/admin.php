<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<!-- Main content -->
<div id="main">
	<div id="navigation">
		<p><a href="index.php">&laquo; Go back to Main Page</a><br /></p>
	</div>
	<div id="page">
		<h2>Admin Menu</h2>
		<p>Welcome to the admin area, <?= htmlentities($_SESSION["username"]); ?></p>
		<ul>
			<li><a href="manage_content.php">Manage Website Content</a></li>
			<li><a href="manage_admins.php">Manage Admin Users</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
	</div>
</div>

<!-- Footer -->
<?php include("../includes/layouts/footer.php"); ?>
<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php $layout_context = "public"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(true); ?>

	<div id="main">
		<div id="navigation">
			<?php if(!isset($_SESSION["username"])) { ?>
			<p><a href="login.php">Login &raquo;</a><br /></p>
			<?php } else { ?>
			<p><a href="admin.php">Admin Panel</a><br /></p>
			<?php } ?>
			<?php echo public_navigation($current_subject, $current_page); ?>
		</div>
		<div id="page">
			<?php if ($current_page) { ?>
				<h2><?php echo htmlentities($current_page["menu_name"]); ?></h2>
				<?php echo nl2br(htmlentities($current_page["content"])); ?>
			<?php } else { ?>

				<p>Welcome!</p>

			<?php } ?>
		</div>
	</div>
<?php include("../includes/layouts/footer.php"); ?>
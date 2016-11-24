<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(); ?>
	<div id="main">
		<div id="navigation">
			<?php echo public_navigation($current_subject, $current_page); ?>
		</div>
		<div id="page">
			<?php if ($current_subject) { ?>
				<h2>Manage Subject</h2>
				Menu name: <?php echo htmlentities($current_subject["menu_name"]); ?><br />
			<?php } elseif ($current_page) {?>
				<div class="view-content"><?php echo htmlentities($current_page["content"]); ?></div>
			<?php } else { ?>
				Please select a subject or a page.
			<?php } ?>
		</div>
	</div>
<?php include("../includes/layouts/footer.php"); ?>
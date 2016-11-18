<?php require_once ("../includes/session.php"); ?>
<!-- Database connection -->
<?php require_once ("../includes/db_connection.php"); ?>
<!-- PHP Functions -->
<?php require_once("../includes/functions.php"); ?>
<!-- Header -->
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(); ?>

<!-- Main content -->
<div id="main">
	<div id="navigation">
		<?php echo navigation($current_subject, $current_page); ?>
        <br />
        <a href="new_subject.php">+ Add a subject</a>
	</div>
	<div id="page">
        <?php echo message(); ?>
		<?php if ($current_subject) { ?>
            <h2>Manage Subject</h2>
			Menu name: <?php echo $current_subject["menu_name"]; ?><br />
            <a href="edit_subject.php?subject=<?php echo $current_subject["id"]; ?>">Edit Subject</a>
		<?php } elseif ($current_page) {?>
            <h2>Manage Page</h2>
            Menu name: <?php echo $current_page["menu_name"]; ?><br />
		<?php } else { ?>
            Please select a subject or a page.
        <?php } ?>
	</div>
</div>
<!-- Footer -->
<?php include("../includes/layouts/footer.php"); ?>
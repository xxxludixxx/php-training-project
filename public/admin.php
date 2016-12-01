<?php require_once ("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layout/header.php"); ?>
    <div id="main">
        <div class="row">
            <div class="navbar">
                <ul>
                    <li><a href="new_post.php">Add new post</a></li>
                    <li><a href="edit_post.php">Edit your posts</a></li>
                    <li><a href="admin.php">Manage account</a></li>
                </ul>
            </div>
            <div class="manage_account">

            </div>
        </div>
    </div>
<!--Footer-->
<?php include("../includes/layout/footer.php"); ?>
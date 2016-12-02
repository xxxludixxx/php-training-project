<?php require_once ("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layout/header.php"); ?>
    <div class="main">
        <div id="nav">
            <?php navigation(); ?>
        </div>
        <div id="content">
            <div class="">
                <div class="">
                    <h2>Hi, <?= htmlentities($_SESSION["login"]); ?>. Manage your account:</h2>
                </div>
                <div class="manage_account">
                </div>
            </div>
        </div>
    </div>
<!--Footer-->
<?php include("../includes/layout/footer.php"); ?>
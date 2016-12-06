<?php require_once ("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php $layout_context = "public"; ?>
<?php include("../includes/layout/header.php"); ?>
<?php
    if(!empty($_GET["category"])) {
        $post_set = find_posts_for_category($_GET["category"]);
        $post = mysqli_fetch_assoc($post_set);
        echo $post["post_title"];
        echo "<br /><br />";
        echo $post["content"];
    }
?>

    <div id="main">
        <div id="nav">
            <?php navigation(); ?>
        </div>
        <div class="content">
        </div>
    </div>
<?php include("../includes/layout/footer.php"); ?>
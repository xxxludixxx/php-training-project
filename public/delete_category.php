<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
    $current_category = find_category_by_id($_GET["category"], false);
    if(!$current_category) {
        redirect_to("edit_category.php");
    }

    $posts_set = find_posts_for_category($current_category["id"], false);
    if(mysqli_num_rows($posts_set) > 0) {
        $_SESSION["message"] = "Category containing posts can't be deleted.";
        redirect_to("edit_category.php");
    }

    $id = $current_category["id"];
    $query = "DELETE FROM categories WHERE id = {$id} LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
        $_SESSION["message"] = "Category successfully deleted.";
        redirect_to("edit_category.php");
    } else {
        $_SESSION["message"] = "Category deletion failed.";
        redirect_to("edit_category.php?category={$id}");
    }
?>
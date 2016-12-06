<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php
if(isset($_POST["submit"])) {
    $required_fields = array("post_title", "content", "position", "visible");
    validate_presence($required_fields);
    validate_category($_POST["category"]);

    $post_title = htmlentities(mysql_prep($_POST["post_title"]));
    $content = htmlentities(mysql_prep($_POST["content"]));
    $category_id= (int) $_POST["category"];
    $admin_id = (int) $_SESSION["admin_id"];
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];

    if(!empty($errors)) {
        $_SESSION["errors"] = $errors;
        redirect_to("new_post.php");
    }

    $query = "UPDATE posts SET ";
    $query .= "post_title = '{$post_title}', ";
    $query .= "content = '{$content}', ";
    $query .= "category_id = '{$category_id}', ";
    $query .= "admin_id = '{$admin_id}', ";
    $query .= "position = '{$position}', ";
    $query .= "visible = '{$visible}' ";
    $query .= "WHERE id = '{$_GET["post"]}'";
    $query .= " LIMIT 1";
    $result = mysqli_query($connection, $query);
    confirm_query($result);

    if ($result) {
        $_SESSION["message"] = "Post edited successfully!";
        redirect_to("edit_post.php");
    } else {
        $_SESSION["message"] = "Something went wrong. Please try again.";
        redirect_to("edit_post.php");
    }
} else {
    //
}
?>
<?php include("../includes/layout/header.php"); ?>
<?php if(empty($_GET["category"]) && empty($_GET["post"])) { ?>
    <div id="main">
        <div id="nav">
            <?php navigation(); ?>
        </div>
        <div id="content">
            <?php echo message(); ?>
            <?php $errors = errors(); ?>
            <?php echo format_errors($errors); ?>
            <h2>Choose a Post to edit:</h2>
                <?php
                    $output = "<ul class=\"categories\">";
                    $category_set = find_all_categories(false);
                    while ($category = mysqli_fetch_assoc($category_set)) {
                        $output .= "<li";
                        //select?!
                        $output .= ">";
                        $output .= "<h3>";
                        $output .= htmlentities($category["category_name"]);
                        $output .= "<h3>";

                        $post_set = find_posts_for_category($category["id"], false);
                        $output .= "<ul class=\"pages\">";
                        while ($post = mysqli_fetch_assoc($post_set)) {
                            $output .= "<li";
                            $output .= ">";
                            $output .= "<a href=\"edit_post.php?category=";
                            $output .= urlencode($category["id"]);
                            $output .= "&post=";
                            $output .= urlencode($post["id"]);
                            $output .= "\">";
                            $output .= htmlentities($post["post_title"]);
                            $output .= "</a></li>";
                        }
                        mysqli_free_result($post_set);
                        $output .= "</ul></li>";
                    }
                    mysqli_free_result($category_set);
                    $output .= "</ul>";
                    echo $output;
                ?>
        </div>
    </div>
<?php } else { ?>
    <?php
        $current_post = find_selected_post();
        $current_category = find_selected_category();
    ?>
    <div id="main">
        <div id="nav">
            <?php navigation(); ?>
        </div>
        <div id="content">
            <?php echo message(); ?>
            <?php $errors = errors(); ?>
            <?php echo format_errors($errors); ?>
            <h2>Edit Post: <?php
                echo $current_post["post_title"];
                ?></h2>
            <form action="edit_post.php?category=<?php echo $current_category["id"]; ?>&post=<?php echo $current_post["id"]; ?>" method="post">
                <table>
                    <tr>
                        <td><label for="post_title">Title:</td>
                        <td><input type="text" name="post_title" value="<?php echo $current_post["post_title"]; ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="content">Content:</td>
                        <td><textarea rows="20" cols="50" name="content"><?php echo $current_post["content"]; ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Change category:</td>
                        <td>
                            <select name="category">
                                <?php
                                $category_set = find_all_categories($public=false);
                                $category_count = mysqli_num_rows($category_set);
                                for ($count=1; $count <= $category_count ; $count++) {
                                    $category = mysqli_fetch_assoc($category_set);
                                    $output = "<option value=\"";
                                    $output .= $category["id"];
                                    $output .= "\"";
                                    if($_GET["category"] == $category["id"]) {
                                        $output .= "selected=\"selected\"";
                                    }
                                    $output .= ">";
                                    $output .= $category["category_name"];
                                    $output .= "</option>";

                                    echo $output;
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Position:</td>
                        <td>
                            <select name="position">
                                <?php
                                $category_id = $_GET["category"];
                                $posts_set = find_posts_for_category($category_id, $public=false);
                                $posts_count = mysqli_num_rows($posts_set);
                                for ($count=1; $count <= $posts_count; $count++) {
                                    $output = "<option value=\"";
                                    $output .= $count;
                                    $output .= "\"";
                                    if($current_post["position"] == $count) {
                                        $output .= " selected=\"selected\"";
                                    }
                                    $output .= ">";
                                    $output .= $count;
                                    $output .= "</option>";

                                    echo $output;
//                                    echo "<option value=\"{$count}\">{$count}</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr><td>Visible:</td>
                        <td><input type="radio" name="visible" value="1" <?php  if($current_post["visible"] == 1) {
                            echo "checked=\"checked\""; } ?>
                            />Yes &nbsp;<input type="radio" name="visible" value="0" <?php  if($current_post["visible"] == 0) {
            echo "checked=\"checked\""; } ?> />No</td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="submit" value="Post"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php } ?>
<?php include("../includes/layout/footer.php"); ?>

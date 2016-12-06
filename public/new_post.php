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
    $category= (int) $_POST["category"];
    $admin_id = (int) $_SESSION["admin_id"];
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];

    if(!empty($errors)) {
        $_SESSION["errors"] = $errors;
        redirect_to("new_post.php");
    }

    $query = "INSERT INTO posts (";
    $query .= "post_title, content, category_id, admin_id, position, visible";
    $query .= ") VALUES (";
    $query .= "'{$post_title}', '{$content}', '{$category}', '{$admin_id}', '{$position}', '{$visible}'";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION["message"] = "Post added successfully!";
        redirect_to("new_post.php");
    } else {
        $_SESSION["message"] = "Something went wrong. Please try again.";
        redirect_to("new_post.php");
    }
} else {
    //
}
?>
<?php include("../includes/layout/header.php"); ?>
<?php if(empty($_GET["category"])) { ?>
    <div id="main">
        <div id="nav">
            <?php navigation(); ?>
        </div>
        <div id="content">
            <?php echo message(); ?>
            <?php $errors = errors(); ?>
            <?php echo format_errors($errors); ?>
            <h2>Choose a Category:</h2>
            <form action="new_post.php" method="get">
                <label for="category">Category:</label>
                <select name="category">
                    <?php
                    $category_set = find_all_categories($public=false);
                    $category_count = mysqli_num_rows($category_set);
                    for ($count=1; $count <= $category_count ; $count++) {
                        $category = mysqli_fetch_assoc($category_set);
                        echo "<option value=\"{$category["id"]}\">{$category["category_name"]}</option>";
                    }
                    ?>
                </select>
                <td><input type="submit" name="submit" value="Submit"></td>
            </form>
        </div>
    </div>
<?php } else { ?>
<div id="main">
    <div id="nav">
        <?php navigation(); ?>
    </div>
    <div id="content">
        <?php echo message(); ?>
        <?php $errors = errors(); ?>
        <?php echo format_errors($errors); ?>
        <h2>Add New Post:</h2>
        <form action="new_post.php" method="post">
            <table>
                <tr>
                    <td><label for="post_title">Title:</td>
                    <td><input type="text" name="post_title" value=""></td>
                </tr>
                <tr>
                    <td><label for="content">Content:</td>
                    <td><textarea rows="20" cols="50" name="content"></textarea></td>
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
                                for ($count=1; $count <= $posts_count + 1; $count++) {
                                    echo "<option value=\"{$count}\">${count}</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr><td>Visible:</td>
                    <td><input type="radio" name="visible" value="1" />Yes &nbsp;<input type="radio" name="visible" value="0" />No</td>
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

<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php
    if(isset($_POST['submit'])) {
        $required_fields = array("category_name", "position", "visible");
        validate_presence($required_fields);

        $category_name = mysql_prep($_POST["category_name"]);
        $position = (int) $_POST["position"];
        $visible = (int) $_POST["visible"];

        if(!empty($errors)) {
            $_SESSION["errors"] = $errors;
            redirect_to("edit_category.php?subject=");
        }
    }


?>
<?php include("../includes/layout/header.php"); ?>
<?php if(empty($_GET["category"])) { ?>
<div id="main">
    <div id="nav">
        <?php navigation(); ?>
    </div>
    <div id="content">
        <h2>Choose a Category:</h2>
        <form action="edit_category.php" method="get">
            <label for="category_name">Category Name:</label>
            <select name="category">
                <?php
                    $category_set = find_all_categories();
                    $category_count = mysqli_num_rows($category_set);
                    for ($count=1; $count <= $category_count + 1; $count++) {
                        $category = find_category_by_id(${count});
                        echo "<option value=\"{$count}\">{$category["category_name"]}</option>";
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
        <h2>Edit Existing Category:</h2>
        <form action="edit_category.php" method="post">
            <table>
                <tr><td><label for="category_name">Category Name:</td>
                    <td><input type="text" name="category_name" value="<?php echo find_category_by_id($_GET["category"])["category_name"]; ?>"></td>
                </tr>
                <tr><td><label for="position">Position:</label></td>
                    <td>
                        <select name="position">
                            <?php
                            $category_set = find_all_categories();
                            $category_count = mysqli_num_rows($category_set);
                            for ($count=1; $count <= $category_count + 1; $count++) {
                                echo "<option value=\"{$count}\">${count}</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr><td>Visible:</td>
                    <td><input type="radio" name="visible" value="1" />Yes &nbsp;<input type="radio" name="visible" value="1" />No</td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="Edit Category"></td>
                    <td><a href="remove_category.php?category=<?php echo $_GET["category"] ?>">Remove this category</a></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php } ?>

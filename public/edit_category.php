<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
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

        $query = "UPDATE categories SET ";
        $query .= "category_name = '{$category_name}', ";
        $query .= "position = '{$position}', ";
        $query .= "visible = '{$visible}' ";
        $query .= "WHERE id = '{$_GET["category"]}'";
        $query .= " LIMIT 1";
        $result = mysqli_query($connection, $query);
        confirm_query($result);

        if ($result && mysqli_affected_rows($connection) == 1) {
            $_SESSION["message"] = "Category edited";
            redirect_to("edit_category.php");
        } else {
            $message = "Category edition failed.";
        }
    } else {

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
        <form action="edit_category.php" method="get">
            <label for="category_name">Category Name:</label>
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
        <h2>Edit Existing Category:</h2>
        <form action="edit_category.php?category=<?php echo htmlentities($_GET["category"]); ?>" method="post">
            <table>
                <tr><td><label for="category_name">Category Name:</td>
                    <td><input type="text" name="category_name" value="<?php $category = find_category_by_id($_GET["category"]); echo mysql_prep($category["category_name"]); ?>"></td>
                </tr>
                <tr><td><label for="position">Position:</label></td>
                    <td>
                        <select name="position">
                            <?php
                                $category_set = find_all_categories($public=false);
                                $category_count = mysqli_num_rows($category_set);
                                $category = find_selected_category();
                                for ($count=1; $count <= $category_count; $count++) {
                                    $result = "<option value=\"";
                                    $result .= $count;
                                    $result .= "\"";
                                    if($category["position"] == $count) {
                                        $result .= "selected=\"selected\"";
                                    }
                                    $result .= ">";
                                    $result .= $count;
                                    $result .= "</option>";

                                    echo $result;
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr><td>Visible:</td>
                    <td><input type="radio" name="visible" value="1" <?php if($current_category["visible"] == 1) { echo "checked=\"checked\"";} ?>/>Yes &nbsp;<input type="radio" name="visible" value="0" <?php if($current_category["visible"] == 0) { echo "checked=\"checked\"";} ?> />No</td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="Edit Category"></td>
                    <td><a href="delete_category.php?category=<?php echo $_GET["category"] ?>" onclick="return confirm('Are you sure?');">Remove this category</a></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php } ?>
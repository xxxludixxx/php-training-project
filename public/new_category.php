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
        redirect_to("new_category.php");
    }

    $query = "INSERT INTO categories (";
    $query .= "category_name, position, visible";
    $query .= ") VALUES (";
    $query .= " '{$category_name}', '{$position}', '{$visible}'";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION["message"] = "Category created";
        redirect_to("new_category.php");
    } else {
        $_SESSION["message"] = "Category creation failed.";
        redirect_to("new_category.php");
    }
} else {
    // This is probably a GET request
?>
<?php include("../includes/layout/header.php"); ?>
<div id="main">
    <div id="nav">
        <?php navigation(); ?>
    </div>
    <div id="content">
        <?php echo message(); ?>
        <?php $errors = errors(); ?>
        <?php echo format_errors($errors); ?>
        <h2>Create New Category:</h2>
        <form action="new_category.php" method="post">
            <table>
                <tr><td><label for="category_name">Category Name:</td>
                    <td><input type="text" name="category_name" value=""></td>
                </tr>
                <tr><td>Position:</td>
                    <td>
                        <select name="position">
                            <?php
                            $category_set = find_all_categories($public=false);
                            $category_count = mysqli_num_rows($category_set);
                            for ($count=1; $count <= $category_count + 1; $count++) {
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
                    <td><input type="submit" name="submit" value="Create Category"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php } ?>
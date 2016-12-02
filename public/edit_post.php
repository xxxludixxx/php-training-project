<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layout/header.php"); ?>
<div id="main">
    <div id="nav">
        <?php navigation(); ?>
    </div>
    <div id="content">
        <h2>Edit Post:</h2>
        <form action="edit_post.php" method="post">
            <table>
                <tr>
                    <td><label for="post_title">Title:</td>
                    <td><input type="text" name="post_title" value=""></td>
                </tr>
                <tr>
                    <td><label for="content">Content:</td>
                    <td><textarea rows="20" cols="50" ></textarea></td>
                </tr>
                <tr>
                    <td>Position:</td>
                    <td>
                        <select name="position">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <option value="1">First Category</option>
                            <option value="2">Second Category</option>
                            <option value="3">Third Category</option>
                        </select>
                        <a href="new_category.php">Create New Category</a>
                    </td>
                </tr>
                <tr><td>Visible:</td>
                    <td><input type="radio" name="visible" value="1" />Yes &nbsp;<input type="radio" name="visible" value="1" />No</td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="Post"></td>
                </tr>
            </table>
        </form>
    </div>
</div>

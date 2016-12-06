<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php errors(); ?>
<?php
if(isset($_POST["submit"])) {
    $required_fields = array("login", "first_name", "last_name", "password", "confirmed_password");
    validate_presence($required_fields);

    $fields_with_max_lengths = array("login" => 30, "first-name" => 50, "last-name" => 50,);
    validate_max_length($fields_with_max_lengths);
    validate_password_match();

    if(empty($errors)) {
        $id = $_SESSION["admin_id"];
        $login = htmlentities(mysql_prep($_POST["login"]));
        $first_name = htmlentities(mysql_prep($_POST["first_name"]));
        $last_name = htmlentities(mysql_prep($_POST["last_name"]));
        $password = mysql_prep($_POST["password"]);
        $hashed_password = password_encrypt($password);

        $query = "UPDATE admins SET ";
        $query .= "login = '{$login}', ";
        $query .= "first_name = '{$first_name}', ";
        $query .= "last_name = '{$last_name}', ";
        $query .= "hashed_password = '{$hashed_password}' ";
        $query .= "WHERE id = '{$id}' ";
        $query .= "LIMIT 1";

        $result = mysqli_query($connection, $query);

        if ($result) {
            $_SESSION["message"] = "Success. Your account has been updated.";
            redirect_to("admin.php");
        } else {
            $_SESSION["message"] = "Account update failed.";
        }
    }
} else {

}
?>

<?php include("../includes/layout/header.php"); ?>
    <div class="main">
        <div id="nav">
            <?php navigation(); ?>
        </div>
        <div id="content">
            <?php echo message(); ?>
            <?php $errors = errors(); ?>
            <?php echo format_errors($errors); ?>
            <div class="">
                <div class="">
                    <h2>Hi, <?= htmlentities($_SESSION["login"]); ?>. Manage your account:</h2>
                </div>
                <div class="manage_account">
                    <form action="admin.php" method="post">
                        <?php $admin = find_admin_by_username($_SESSION["login"]); ?>
                        <table>
                            <tr><td>Login:</td>
                                <td><input type="text" name="login" value="<?= $admin["login"]; ?>"></td>
                            </tr>
                            <tr><td>First Name:</td>
                                <td><input type="text" name="first_name" value="<?= $admin["first_name"]; ?>"></td>
                            </tr>
                            <tr><td>Last name:</td>
                                <td><input type="text" name="last_name" value="<?= $admin["last_name"]; ?>"></td>
                            </tr>
                            <tr><td>New Password:</td>
                                <td><input type="password" name="password" value=""></td>
                            </tr>
                            <tr><td>Confirm new password:</td>
                                <td><input type="password" name="confirmed_password" value=""></td>
                            </tr>
                        </table>
                        <br />
                        <input type="submit" name="submit" value="Update" />
                        <a href="index.php"><p>Go back</p></a>
                    </form>
                    <br />
                </div>
            </div>
        </div>
    </div>
<!--Footer-->
<?php include("../includes/layout/footer.php"); ?>
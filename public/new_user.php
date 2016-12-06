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
        $login = htmlentities(mysql_prep($_POST["login"]));
        $first_name = htmlentities(mysql_prep($_POST["first_name"]));
        $last_name = htmlentities(mysql_prep($_POST["last_name"]));
        $password = mysql_prep($_POST["password"]);
        $hashed_password = password_encrypt($password);

        $query = "INSERT INTO admins (";
        $query .= " login, first_name, last_name, hashed_password";
        $query .= ") VALUES (";
        $query .= " '{$login}', '{$first_name}', '{$last_name}', '{$hashed_password}'";
        $query .= ")";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $_SESSION["message"] = "Success. New user registered.";
            redirect_to("admin.php");
        } else {
            $_SESSION["message"] = "Registration failed.";
        }
    }
} else {

}
?>

<?php include("../includes/layout/header.php"); ?>
    <!--Main content-->
    <div id="main">
        <div id="nav">
            <?php navigation(); ?>
        </div>
        <div id="content">
            <?php echo message(); ?>
            <?php $errors = errors(); ?>
            <?php echo format_errors($errors); ?>
            <form action="new_user.php" method="post">
                <table>
                    <tr><td>Login:</td>
                        <td><input type="text" name="login" value="<?php if (isset($_POST["login"])) { echo $_POST["login"]; } ?>"></td>
                    </tr>
                    <tr><td>First Name:</td>
                        <td><input type="text" name="first_name" value="<?php if (isset($_POST["login"])) { echo $_POST["first_name"]; } ?>"></td>
                    </tr>
                    <tr><td>Last name:</td>
                        <td><input type="text" name="last_name" value="<?php if (isset($_POST["login"])) { echo $_POST["last_name"]; } ?>"></td>
                    </tr>
                    <tr><td>Password:</td>
                        <td><input type="password" name="password" value=""></td>
                    </tr>
                    <tr><td>Confirm password:</td>
                        <td><input type="password" name="confirmed_password" value=""></td>
                    </tr>
                </table>
                <br />
                <input type="submit" name="submit" value="Create User" />
                <a href="index.php"><p>Go back</p></a>
            </form>
            <br />
        </div>
    </div>
    <!--Footer-->
<?php include("../includes/layout/footer.php"); ?>
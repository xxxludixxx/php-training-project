<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
    $username = "";
    if (isset($_POST['submit'])) {
        $required_fields = array("login", "password");
        validate_presence($required_fields);

        if (empty($errors)) {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $found_admin = attempt_login($login, $password);
            if ($found_admin) {
                $_SESSION["admin_id"] = $found_admin["id"];
                $_SESSION["login"] = $found_admin["login"];
                redirect_to("admin.php");
            } else {
                $_SESSION["message"] = "Username/password incorrect.";
            }
        }
    } else {

    }?>
<?php include("../includes/layout/header.php"); ?>
<!--Main content-->
<div id="main">
    <div id="login">
        <form action="login.php" method="post">
            <table>
                <tr><td><label for="login">Login:</label></td>
                    <td><input type="text" name="login" value="<?php if (isset($_POST["login"])) { echo $_POST["login"]; } ?>"></td>
                </tr>
                <tr><td><label for="password">Password:</></td>
                    <td><input type="password" name="password" value=""></td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Log In" />
            <a href="index.php"><p>Go back</p></a>
        </form>
    </div>
</div>
<!--Footer-->
<?php include("../includes/layout/footer.php"); ?>

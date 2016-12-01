<?php
    function redirect_to($new_location) {
        header("Location: " . $new_location);
        exit;
    }
    function mysql_prep($string) {
        global $connection;

        $escaped_string = mysqli_real_escape_string($connection, $string);
        return $escaped_string;
    }
    function confirm_query($result_set) {
        if(!$result_set) {
            die("Database query failed");
        }
    }
    function format_errors($errors=array()) {
        $output = "";
        if (!empty($errors)) {
            $output .= "<div class=\"error\">";
            $output .= "Please fix the following errors:";
            $output .= "<ul>";
            foreach ($errors as $key => $error) {
                $output .= "<li>";
                $output .= htmlentities($error);
                $output .= "</li>";
            }
            $output .= "</ul>";
            $output .= "</div>";
        }
        return $output;
    }
// MySQL QUERIES
    function find_admin_by_username($username) {
        global $connection;

        $safe_username = mysqli_real_escape_string($connection, $username);

        $query = "SELECT * ";
        $query .= "FROM admins ";
        $query .= "WHERE login = '{$safe_username}' ";
        $query .= "LIMIT 1";
        $admin_set = mysqli_query($connection, $query);
        confirm_query($admin_set);
        if($admin = mysqli_fetch_assoc($admin_set)) {
            return $admin;
        } else {
            return null;
        }
    }
// PASSWORD FUNCTIONS
    function password_encrypt($password) {
        $hash_format = "$2y$10$";
        $salt_length = 22;
        $salt = generate_salt($salt_length);
        $format_and_salt = $hash_format . $salt;
        $hash = crypt($password, $format_and_salt);
        return $hash;
    }

    function generate_salt($length) {
        $unique_random_string = md5(uniqid(mt_rand(), true));
        $base64_string = base64_encode($unique_random_string);
        $modified_base64_string =str_replace('+', '.', $base64_string);
        $salt = substr($modified_base64_string, 0, $length);
        return $salt;
    }
// LOGIN
    function password_check($password, $existing_hash) {
        $hash = crypt($password, $existing_hash);
        if ($hash === $existing_hash) {
            return true;
        } else {
            return false;
        }
    }

    function attempt_login($login, $password) {
        $admin = find_admin_by_username($login);
        if($admin) {
            if (password_check($password, $admin['hashed_password'])) {
                return $admin;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
// LOGIN CONTROL
    function logged_in() {
        return isset($_SESSION['admin_id']);
    }

    function confirm_logged_in() {
        if(!logged_in()) {
            redirect_to("login.php");
        }
    }

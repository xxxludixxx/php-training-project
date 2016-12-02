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

    function find_all_categories() {
        global $connection;

        $query = "SELECT * FROM categories ";
        $query .= "ORDER BY position ASC";
        $category_set = mysqli_query($connection, $query);
        confirm_query($category_set);
        return $category_set;
    }

    function find_category_by_id($category_id) {
        global $connection;

        $safe_category_id = mysql_prep($category_id);

        $query = "SELECT * FROM categories ";
        $query .= "WHERE id = {$safe_category_id} ";
        $query .= "LIMIT 1";
        $category_set = mysqli_query($connection, $query);
        confirm_query($category_set);
        if ($category = mysqli_fetch_assoc($category_set)) {
            return $category;
        } else {
            return null;
        }
    }

    function find_selected_category() {
        global $current_category;

        if(isset($_GET["category"])) {
            $current_category = find_category_by_id($_GET["category"]);
            return $current_category;
        }
    }
// NAVIGATION
    function navigation() {
        global $layout_context;
        if ($layout_context !== "public") {
            echo admin_navigation();
        } else {
            echo public_navigation();
        }
    }

    function public_navigation() {
        $output = "<ul class=\"categories\">";
        $category_set = find_all_categories();
        while ($category = mysqli_fetch_assoc($category_set)) {
            $output .= "<li>";
            $output .= "<a href=\"index.php?category=";
            $output .= urlencode($category["id"]);
            $output .= "\">";
            $output .= htmlentities($category["category_name"]);
            $output .= "</a>";
            $output .= "</li>";
        }
        mysqli_free_result($category_set);
        $output .= "</ul>";
        return $output;
    }

    function admin_navigation() {
        $result = "<nav>";
        $result .= "<ul>";
        $result .= "<li>";
        $result .= "Posts";
        $result .= "<ul>";
        $result .= "<li>";
        $result .= "<a href=\"new_post.php\">";
        $result .= "Add New Post";
        $result .= "</a>";
        $result .= "</li>";
        $result .= "<li>";
        $result .= "<a href=\"edit_post.php\">";
        $result .= "Edit Posts";
        $result .= "</a>";
        $result .= "</li>";
        $result .= "</ul>";
        $result .= "</li>";
        $result .= "<li>";
        $result .= "Categories";
        $result .= "<ul>";
        $result .= "<li>";
        $result .= "<a href=\"new_category.php\">";
        $result .= "Add New Category";
        $result .= "</a>";
        $result .= "</li>";
        $result .= "<li>";
        $result .= "<a href=\"edit_category.php\">";
        $result .= "Edit Categories";
        $result .= "</a>";
        $result .= "</li>";
        $result .= "</ul>";
        $result .= "</li>";
        $result .= "<li>";
        $result .= "Accounts";
        $result .= "<ul>";
        $result .= "<li>";
        $result .= "<a href=\"new_admin.php\">";
        $result .= "Create admin user";
        $result .= "</a></li>";
        $result .= "<li>";
        $result .= "<a href=\"admin.php\">";
        $result .= "Manage Your Account";
        $result .= "</a></li>";
        $result .= "<li>";
        $result .= "<a href=\"manage_admins.php\">";
        $result .= "Manage Other Admin Accounts";
        $result .= "</a>";
        $result .= "</li>";
        $result .= "</ul>";
        $result .= "</li>";
        $result .= "</ul>";
        $result .= "</nav>";

        return $result;
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
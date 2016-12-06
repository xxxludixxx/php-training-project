<?php

$errors = array();

function fieldname_as_text($fieldname) {
    $fieldname = str_replace("_", " ", $fieldname);
    $fieldname = ucfirst($fieldname);
    return $fieldname;
}

function is_present($value) {
    return isset($value) && $value !== "";
}

function validate_presence($required_fields) {
    global $errors;
    foreach ($required_fields as $field) {
        $value = trim($_POST[$field]);
        if (!is_present($value)) {
            $errors[$field] = fieldname_as_text($field) . " can't be blank.";
        }
    }
}

function has_max_length($value, $max) {
    return strlen($value) <= $max;
}

function validate_max_length($fields_with_max_lengths) {
    global $errors;
    foreach ($fields_with_max_lengths as $field => $max) {
        $value = trim($_POST[$field]);
        if (!has_max_length($value, $max)) {
            $errors[$field] = fieldname_as_text($field) . " is too long";
        }
    }
}

function password_match() {
    if (isset($_POST["submit"]) && $_POST["password"] === $_POST["confirmed_password"]) {
        return true;
    }
}

function validate_password_match() {
    global $errors;

    if (!password_match()) {
        $errors["password"] = "Your passwords did not match.";
    }
}

function validate_category($id) {
    $category = find_category_by_id($id, false);
    if($category["id"] !== $id) {
        $_SESSION["message"] = "Category does not exist.";
        redirect_to("edit_post.php");
    }
}
?>
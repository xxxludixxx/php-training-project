<?php
// Define Database Constants
    define("DB_SERVER", "docker");
    define("DB_USER", "jludwa");
    define("DB_PASS", "zaq12wsx");
    define("DB_NAME", "widget_corp");
// Create a database connection
	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
// Test if connection succeeded
	if(mysqli_connect_errno()) {
        die("Database connection failed: " .
            mysqli_connect_error() .
            " (" . mysqli_connect_errno() . ")"
        );
    }
?>
<?php
    $host = "docker";
    $user = "intcet_88";
    $pass = "zaq12wsx";
    $db = "intcet_88";

    $connection = new mysqli($host, $user, $pass, $db);
    // Test if connection succeeded
    if ($connection->connect_error) {
        die("Connection to database failed: " . $conn->connect_error);
    }
?>
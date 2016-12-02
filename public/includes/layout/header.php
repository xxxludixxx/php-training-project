<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Basic CMS by Lu2</title>
    <meta name="description" content="Basic PHP CMS">
    <meta name="author" content="Lu2">
    <link rel="stylesheet" href="styles/public.css">
</head>
<body>
<div id="header">
        <div class="main-div">
            <h1><a href="index.php">CMS - Test Header</a></h1>
        </div>
        <div class="right-col">
            <ul id="navigation">
                <?php if (!logged_in()) { ?>
                    <li><a href="login.php">Log In</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php } else { ?>
                    <?php if ($layout_context !== "admin") { ?>
                        <li><a href="admin.php">Admin Panel</a></li>
                    <?php } ?>
                    <li><a href="logout.php">Log out</a></li>
                <?php } ?>

            </ul>
        </div>
</div>
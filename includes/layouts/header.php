<?php if (!isset($layout_context)){ $layout_context = "public"; } ?>
<!DOCTYPE html>

<html lang="en">
<head>
	<title>Widget Corp<?php if ($layout_context == "admin") { echo " Admin";} ?></title>
	<link href="stylesheets/public.css" media="all" rel="stylesheet" type="text/css" />
</head>
<body>
<!-- Header -->
<div id="header">
	<h1><a href="../../public/admin.php" style="color: white; text-decoration: none">Widget Corp<?php if ($layout_context == "admin") { echo " Admin";} ?></a></h1>
</div>
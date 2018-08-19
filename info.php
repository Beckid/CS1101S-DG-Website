<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once 'head.php'; ?>
</head>
<body>
<?php
require_once 'useful.php';

// Only admin user can use this tool.
if (!logged_in() || $_SESSION['usertype'] != "admin") {
	redirect_no_permission();
} else {
	echo phpinfo();
}
?>
</body>
</html>
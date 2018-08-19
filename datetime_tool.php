<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once 'head.php'; ?>
</head>
<body>
<?php
require_once 'nav.php';

// Set the default timezone to be Singapore local time.
// Noitce this setting only applies to the current script.
date_default_timezone_set('Asia/Singapore');

// Only admin user can use this tool.
if (!logged_in() || $_SESSION['usertype'] != "admin") {
	redirect_no_permission();
}

$db = db_connect();
$db_version = $db->getAttribute(PDO::ATTR_SERVER_VERSION);
$db = null;
?>

<div class="container">
	<h1>Datetime Tool<br>
	<small>A useful tool to help you get information about current PHP server's datetime information.</small></h1>
	<br>

	<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
		<h3>Datetime Information of the current PHP server</h3>
		<table class="table table-responive table-striped">
			<tr>
				<td>PHP current Time</td>
				<td><?php echo date(DATE_COOKIE); ?></td>
			</tr>
			<tr>
				<td>PHP version</td>
				<td><?php echo phpversion(); ?></td>
			</tr>
			<tr>
				<td>PHP server timezone</td>
				<td><?php echo date_default_timezone_get(); ?></td>
			</tr>
			<tr>
				<td>Database version</td>
				<td><?php echo $db_version; ?></td>
			</tr>
		</table>
	</div>
</div>
<br><br><br>
<?php require_once 'footer.php'; ?>
</body>
</html>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once 'head.php'; ?>
</head>
<body>
<?php
require_once 'nav.php';

// To load the database configuration.
require_once 'config.php';
// To load the required mailer functionality.
require_once 'mailer.php';

$result = email(ADMIN_EMAIL, "Test for mailer function", "Some test text");

if ($result) {
	$result_str = "An email has successfully been sent to the admin email address for testing purpose. Please check.";
} else {
	$result_str = "There is something wrong with the website. Please contact the website admin immediately.";
}
?>

<div class="container">
	<h1>Mailer Test Tool<br>
	<small>A useful tool to help you check whether the mailer is working correctly.</small></h1>
	<br>

	<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
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
				<td>Email destination</td>
				<td><?php echo ADMIN_EMAIL; ?></td>
			</tr>
			<tr>
				<td>Test Result</td>
				<td><?php echo $result_str; ?></td>
			</tr>
		</table>
	</div>
</div>
<br><br><br>
<?php require_once 'footer.php'; ?>
</body>
</html>
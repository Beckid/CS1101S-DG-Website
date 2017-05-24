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

// Only after login, the user can use this tool.
if (!logged_in()) {
	header("location: login.php");
} else if($_POST) {
	$pword = $_POST['input'];
	$hash = password_hash($pword, PASSWORD_DEFAULT);
	$time = date(DATE_COOKIE);
	$version = phpversion();
}
?>

<div class="container">
	<h1>Password Tool<br>
	<small>A useful tool to help you use PHP system built-in password hash/verify function.</small></h1>
	<br><br><br>

	<form role="form" method="post" action="password_tool.php" class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
		<div class="form-group">
			<label for="input">Enter a password as input</label>
			<input type="text" name="input" class="form-control" id="input" placeholder="Enter a password as input" accesskey="i" tabindex="1" required autofocus>
		</div>

		<button type="submit" class="btn btn-success">Submit</button>
	</form>

	<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2" id="result" hidden>
		<br><br><br>
		<h3>Result of PHP password hash/verify function</h3>
		<table class="table table-responive table-striped">
			<tr>
				<td>Original password</td>
				<td><?php echo $pword; ?></td>
			</tr>
			<tr>
				<td>Hash value</td>
				<td><?php echo $hash; ?></td>
			</tr>
			<tr>
				<td>Algorithms used</td>
				<td>Bcrypt</td>
			</tr>
			<tr>
				<td>Create Time</td>
				<td><?php echo $time; ?></td>
			</tr>
			<tr>
				<td>PHP version</td>
				<td><?php echo $version; ?></td>
			</tr>
		</table>

		<?php
		if ($_POST) {
		?>
		<script type="text/javascript">
			$("#result").removeAttr("hidden");
		</script>
		<?php	
		}
		?>
	</div>
</div>
<br><br><br>
<?php require_once 'footer.php'; ?>
</body>
</html>
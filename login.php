<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once 'head.php'; ?>
</head>
<body>
<?php
require_once 'nav.php';

// To record whether the recent login attempt has failed.
$login_fail = false;

if (logged_in()) {
	header("location: index.php");
} else if ($_POST) {
	if (login_validate($_POST["username"], $_POST["password"])) {
		header("location: index.php");
	} else {
		$login_fail = true;
	}
};
?>

<h1>User Login</h1>

<div class="container">
	<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offse-4 col-lg-4 col-lg-offset-4">
		<form role="form" method="post" action="login.php">
			<p style="color: red;">
				<?php if ($login_fail) {
					echo "The username and password does not match.";
				} ?>
			</p>

			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" name="username" class="form-control" id="username" placeholder="Type username" accesskey="u" tabindex="1" required autofocus>
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" name="password" class="form-control" id="password" placeholder="Type password" accesskey="p" tabindex="2" required>
			</div>

			<button type="submit" class="btn btn-primary">Sign in</button>
		</form>
	</div>
</div>
<br><br><br><br>

<?php require_once 'footer.php'; ?>
</body>
</html>
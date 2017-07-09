<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once 'head.php'; ?>
	<script type="text/javascript" src="useful.js"></script>
</head>
<body>
<?php
require_once 'nav.php';

if (logged_in()) {
	header("location: index.php");
} else if ($_POST) {
	
};
?>

<h1>Change Password</h1>

<div class="container">
	<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
		<form role="form" method="post" action="login.php">
			<div id="error_message" class="">
				<?php if ($login_fail) {
					echo "You have changed your password successfully.";
				?>
				<script type="text/javascript">add_alert_class();</script>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php
				} ?>
			</div>

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
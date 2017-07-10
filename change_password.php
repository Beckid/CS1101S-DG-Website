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

$change_result = -1;

if (!logged_in()) {
	header("location: index.php");
} else if ($_POST) {
	$old = $_POST['origin'];
	$new = $_POST['new'];
	$confirm = $_POST['confirm'];

	if ($new != $confirm) {
		$change_result = 1;
	} else {
		$change_result = change_password($old, $new);
	}
};
?>

<h1>Change Password</h1>

<div class="container">
	<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
		<form role="form" method="post" action="change_password.php">
			<div id="error_message" class="">
				<?php if ($change_result == 0) {
					echo "Your password has been changed successfully.";
				?>
				<script type="text/javascript">add_success_class();</script>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php
				} else if ($change_result > 0) {
					if ($change_result == 1) {
						echo "The new password doesn't match the confirmation.";
					} else if ($change_result == 2) {
						echo "You have entered a wrong old password. Please check again.";
					}
				?>
				<script type="text/javascript">add_alert_class();</script>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php
				} ?>
			</div>

			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" value="<?php echo $_SESSION['username']; ?>" name="username" class="form-control" id="username" placeholder="Type your username" accesskey="u" tabindex="1" required disabled>
			</div>

			<div class="form-group">
				<label for="origin">Original password</label>
				<input type="password" name="origin" class="form-control" id="origin" placeholder="Type your original password" accesskey="o" tabindex="2" autofocus required>
			</div>

			<div class="form-group">
				<label for="new">New password</label>
				<input type="password" name="new" class="form-control" id="new" placeholder="Type your new password" accesskey="n" tabindex="3" required>
			</div>

			<div class="form-group">
				<label for="confirm">Confirm new password</label>
				<input type="password" name="confirm" class="form-control" id="confirm" placeholder="Type your new password again" accesskey="a" tabindex="4" required>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-success">Submit</button>
				<button type="button" class="btn btn-primary" onclick="window.location.href='index.php'">Cancel</button>
			</div>
		</form>
	</div>
</div>
<br><br><br><br>

<?php require_once 'footer.php'; ?>
</body>
</html>
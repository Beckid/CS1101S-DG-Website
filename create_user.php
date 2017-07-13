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

// To represent the type of the error.
$result = -1;

// Only admin users can upload files.
if (!logged_in() || $_SESSION['usertype'] != "admin") {
	header("location: index.php");
} else if ($_POST) {
	$password = $_POST['password'];
	$confirm = $_POST['confirm'];

	if ($password != $confirm) {
		$result = 1;
	} else {
		$uname = $_POST['username'];
		$email = $_POST['email'];
		$is_random = isset($_POST['random']);
		// The value of type here is either 'student' or 'admin'.
		$type = $_POST['type'];

		$result = create_user($uname, $password, $type, $email, $is_random);
	}
}
?>

<h1>Create User<small> (For Admin only)</small></h1>
<br><br>

<div class="container">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
		<form role="form" method="post" action="create_user.php" onsubmit="confirm_new_user();">
			<div id="error_message" class="">
				<?php if ($result == 0) {
					echo "Your password has been changed successfully.";
				?>
				<script type="text/javascript">add_success_class();</script>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php
				} else if ($result > 0) {
					if ($result == 1) {
						echo "The two passwords you have entered do not match.";
					} else if ($result == 2) {
						echo "There is an existing user with the same username. Please change.";
					} else if ($result == 3) {
						echo "Your password is too simple. Guideline for a good password: " .
							 "1) It has to be at least 8 characters long; " . 
							 "2) It has to contain both numeric and alphabetic digits.";
					}
				?>
				<script type="text/javascript">add_alert_class();</script>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php
				} ?>
			</div>
			<br>

			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" name="username" class="form-control" id="username" placeholder="Type username" accesskey="u" tabindex="1" required autofocus>
			</div>

			<div class="form-group">
				<label for="type">User type</label>
				<br>
				<div class="radio-inline">
					<label><input type="radio" name="type" value="admin" id="type_admin" accesskey="a" tabindex="2" required>Admin</label>
				</div>
				<div class="radio-inline">
					<label><input type="radio" name="type" value="student" id="type_student" accesskey="s" tabindex="3" required>Student</label>
				</div>
			</div>

			<div class="form-group">
				<label for="email">Email address</label>
				<input type="email" name="email" class="form-control" id="email" placeholder="someone@example.com" accesskey="e" tabindex="4">
				<p id="email_help" class="form-text text-muted" style="color: #34495E;">
					We will send an email to this address for acknowledgement if a new user has been created successfully.
				</p>
			</div>

			<div class="form-group">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="random" id="random" accesskey="r" tabindex="5" onchange="generate_random_password();">
						<b>Generate random password</b>
					</label>
				</div>
			</div>

			<div id="manual-password-group" class="">
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" class="form-control" id="password" placeholder="Type password" accesskey="p" tabindex="6" required>
				</div>

				<div class="form-group">
					<label for="confirm">Confirm password again</label>
					<input type="password" name="confirm" class="form-control" id="confirm" placeholder="Type password again" accesskey="c" tabindex="7" required>
				</div>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-success">Submit</button>
				<button type="button" class="btn btn-primary" onclick="window.location.href='index.php'">Cancel</button>
			</div>
		</form>
	</div>
</div>
<br><br><br><br>

<?php
require_once 'footer.php';
?>
</body>
</html>
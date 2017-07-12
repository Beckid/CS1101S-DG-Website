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
	
}
?>

<h1>Create User<small> (For Admin only)</small></h1>
<br><br>

<div class="container">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
		<form role="form" method="post" action="create_user.php" onsubmit="confirm_new_user();">
			<div id="error_message" class="">
				
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
					<label><input type="radio" name="type" id="type_admin" accesskey="a" tabindex="5" required>Admin</label>
				</div>
				<div class="radio-inline">
					<label><input type="radio" name="type" id="type_student" accesskey="s" tabindex="6" required>Student</label>
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
				<label for="password">Password</label>
				<input type="password" name="password" class="form-control" id="password" placeholder="Type password" accesskey="p" tabindex="2" required>
			</div>

			<div class="form-group">
				<label for="confirm">Confirm password again</label>
				<input type="password" name="confirm" class="form-control" id="confirm" placeholder="Type password again" accesskey="c" tabindex="3" required>
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
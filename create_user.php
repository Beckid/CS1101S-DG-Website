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
				<label for="password">Password</label>
				<input type="password" name="password" class="form-control" id="password" placeholder="Type password" accesskey="p" tabindex="2" required>
			</div>

			<div class="form-group">
				<label for="password">Confirm password again</label>
				<input type="password" name="password" class="form-control" id="password" placeholder="Type password again" accesskey="c" tabindex="3" required>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-success">Submit</button>
				<button class="btn btn-primary" onclick="window.location.href='index.php'">Cancel</button>
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
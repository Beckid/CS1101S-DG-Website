<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once 'head.php'; ?>
</head>
<body>
<?php
require_once 'nav.php';

if (!logged_in() || $_SESSION['usertype'] != "admin") {
	header("location: index.php");
} else if ($_POST) {
	;
};
?>

<h1>Upload Files<small>(For Admin only)</small></h1>

<div class="container">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offse-2 col-lg-8 col-lg-offset-2">
		<form role="form" method="post" action="upload.php">
			<div class="form-group">
				<label for="fileName">File Name</label>
				<input type="text" name="fileName" class="form-control" id="fileName" placeholder="Type the name of the file" accesskey="n" tabindex="1" required autofocus>
			</div>

			<div class="form-group">
				<label for="author">Author</label>
				<input type="text" name="author" class="form-control" id="author" placeholder="Type author" accesskey="a" tabindex="2">
			</div>

			<div class="form-group">
				<label for="description">Description</label>
				<input type="text" name="description" class="form-control" id="description" placeholder="Type the description of the file" accesskey="d" tabindex="3">
			</div>

			<button type="submit" class="btn btn-primary">Upload</button>
		</form>
	</div>
</div>
<br><br><br><br>

<?php
require_once 'footer.php';
?>
</body>
</html>
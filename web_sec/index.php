<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once '../head.php'; ?>
	<script type="text/javascript" src="useful.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="contained-fluid">
		<div class="navbar-header">
			<!-- Data target should be accorded with the id of collapse div part -->
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#my-navbar-collapse">
	            <span class="sr-only">Go to...</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	        </button>

			<a href="../index.php" class="navbar-brand">CS1101S DG</a>
		</div>

		<!-- Compatibility for mobile browsers, which will collapse on smaller screens -->
		<div class="collapse navbar-collapse" id="my-navbar-collapse">
			<ul class="nav navbar-nav navbar-left">
				<li><a href="https://ivle.nus.edu.sg/" target="_blank">IVLE</a></li>
				<li><a href="https://sourceacademy.comp.nus.edu.sg/" target="_blank">Source Academy</a></li>
				<li><a href="http://sourceacademy.comp.nus.edu.sg/playground" target="_blank">Source Playground</a></li>
				<li><a href="https://yunpengn.github.io/" target="_blank">Yunpeng's Website</a></li>
				<li><a href="../editor.php">Online Text Editor</a></li>
			</ul>
		</div>
	</div>
</nav>
<!-- Because the navigation bar is fixed at the top, we need 3 new lines to avoid the contents below being blocked by it. -->
<br><br><br>

<?php
$correct_answer = false;

if ($_POST && $_POST["password"] == "may_the_source_be_with_you") {
	$correct_answer = true;
};
?>

<h1>An interesting but simple problem</h1>
<br><br>

<div class="container">
	<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 col-lg-6 col-lg-offset-3">
		<?php
		if ($correct_answer) {
		?>
		<h3 style="color: red;">Congratulations! You have solved the problem.</h3>
		<?php
		} else {
		?>
		<form role="form" method="post" action="index.php">
			<div class="form-group">
				<label for="username">I hide something here!</label>
				<div class="hidden">
					<input type="password" name="username" class="form-control" id="hide" value="may_the_source_be_with_you" accesskey="h" tabindex="1" required>
				</div>
			</div>

			<div class="form-group">
				<label for="password">Enter the secret:</label>
				<input type="password" name="password" class="form-control" id="password" placeholder="Type the secret" accesskey="p" tabindex="2" required  autofocus>
			</div>

			<button type="submit" class="btn btn-primary">Sign in</button>
		</form>
		<?php	
		}
		?>
	</div>
</div>
<br><br><br><br>

<?php require_once '../footer.php'; ?>
</body>
</html>
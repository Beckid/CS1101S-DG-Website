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

			<a href="index.php" class="navbar-brand">CS1101S DG</a>
		</div>

		<!-- Compatibility for mobile browsers, which will collapse on smaller screens -->
		<div class="collapse navbar-collapse" id="my-navbar-collapse">
			<ul class="nav navbar-nav navbar-left">
				<li><a href="https://ivle.nus.edu.sg/" target="_blank">IVLE</a></li>
				<li><a href="https://sourceacademy.comp.nus.edu.sg/" target="_blank">Source Academy</a></li>
				<li><a href="https://source-ide.surge.sh/" target="_blank">Source IDE</a></li>
				<li><a href="https://comp.nus.edu.sg/~e0134079/" target="_blank">Yunpeng's Website</a></li>
				<li><a href="editor.php">Online Text Editor</a></li>
				<?php
				require_once 'useful.php';

				if (logged_in() && isset($_SESSION['usertype']) && $_SESSION['usertype'] == "admin") {
				?>
				<li class="dropdown">
					<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Administration <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="upload.php">Upload Files</a></li>
						<li><a href="delete.php">Delete Files</a></li>
						<li><a href="create_user.php">Create User</a></li>
						<li><a href="password_tool.php">Password Tool</a></li>
						<li><a href="datetime_tool.php">Datetime Tool</a></li>
					</ul>
				</li>
				<?php
				} ?>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<?php
				if (logged_in()) {
				?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Welcome, <?php echo $_SESSION['username']; ?><b class="cavet"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="change_password.php">Change password</a></li>
						<li><a href="logout.php">Sign out</a></li>
					</ul>
				</li>

				<?php
				} else {
				?>
				<li><a href="login.php">Sign in</a></li>
				<?php
				}
				?>
			</ul>
		</div>
	</div>
</nav>
<!-- Because the navigation bar is fixed at the top, we need 3 new lines to avoid the contents below being blocked by it. -->
<br><br><br>

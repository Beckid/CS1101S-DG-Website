<?php
// Load the database configuration.
require_once 'config.php';

// Checks the _SESSION variable to decide whether the user has logged in.
function logged_in() {
	return isset($_SESSION['authorized']) && $_SESSION['authorized'] == true;
}

// To validate whether the user name and the password matches. Used in the login page.
function login_validate($uname, $pword) {
	// Avoid SQL injection by filtering special characters.
	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);

	// Create connection to the database or report error.
	$db = mysqli_connect(DB_SERVER, DB_UNAME, DB_PWORD, DB_NAME) or die("Cannot connect to the database.");

	// Query to the database or report error.
	$query = "SELECT * FROM Users WHERE Username = '" . $uname . "' AND Password = '" . $pword . "'";
	$result = mysqli_query($db, $query) or die ("Query is not successfuly.");

	if (mysqli_num_rows($result) > 0) {
		// The validation is successful. Change the query result into an associate array.
		$result_row = mysqli_fetch_array($result, MYSQLI_ASSOC);

		// Register this dialog in the _SESSION to save related information.
		$_SESSION['authorized'] = true;
		$_SESSION['username'] = $result_row['Username'];
		if ($result_row['UserType'] == 0) {
			$_SESSION['usertype'] = "admin";
		} elseif ($result_row['UserType'] == 1) {
			$_SESSION['usertype'] = "student";
		}

		// Return true and re-direct to the homepage.
		return true;
	} else {
		// The validation fails. Return false and prompt false information on the page.
		return false;
	}
}

// Clear all the _SESSION variables. Used in the logout page.
function log_out() {
	// Empty the whole _SESSION array.
	$_SESSION = array();

	// Clear the session ID saved in the local cookie if necessary.
	if(isset($_COOKIE[session_name()])) {
		setcookie(session_name(), "", time() - 1, "/");
	}

	// Clear the data stored on the server.
	session_destroy();
}

// To store the uploaded file locally and keep a record in the database. Used in the upload page.
function file_upload($fileInfo, $desiredName, $author, $description) {
	move_uploaded_file($fileInfo['tmp_name'], get_stored_path($fileInfo['name']));
}

function get_stored_path($fname) {
	
}
?>
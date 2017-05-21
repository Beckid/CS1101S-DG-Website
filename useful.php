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
	$db = mysqli_connect(DB_SERVER, DB_UNAME, DB_PWORD, DB_NAME) or die("Cannot connect to the database." . mysqli_connect_error($db));

	// Query to the database or report error.
	$query = "SELECT * FROM Users WHERE Username = '" . $uname . "' AND Password = '" . $pword . "'";
	$result = mysqli_query($db, $query) or die ("Query is not successfuly.");

	if (mysqli_num_rows($result) > 0) {
		// The validation is successful. Change the query result into an associate array.
		$result_row = mysqli_fetch_assoc($result);

		// Register this dialog in the _SESSION to save related information.
		$_SESSION['authorized'] = true;
		$_SESSION['username'] = $result_row['Username'];
		if ($result_row['UserType'] == 0) {
			$_SESSION['usertype'] = "admin";
		} elseif ($result_row['UserType'] == 1) {
			$_SESSION['usertype'] = "student";
		}

		// Close the database connection.
		mysqli_close($db);

		// Return true and re-direct to the homepage.
		return true;
	} else {
		// Close the database connection.
		mysqli_close($db);

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
	// Avoid SQL injection by filtering special characters.
	$desiredName = htmlspecialchars($desiredName);
	$author = htmlspecialchars($author);
	$description = htmlspecialchars($description);
	// Avoid uploaded files with the same name.
	$path = get_stored_path($fileInfo['name']);

	// Try to store the uploaded file locally on the server.
	if(move_uploaded_file($fileInfo['tmp_name'], $path)) {
		// Create connection to the database or report error.
		$db = mysqli_connect(DB_SERVER, DB_UNAME, DB_PWORD, DB_NAME) or die("Cannot connect to the database.");

		// Make a query to the database to keep a record or report error.
		$query = "INSERT INTO Files (FileName, Author, Description, FilePath) VALUES ('" . $desiredName . "', '" . $author . "', '" . $description . "', '" . $path . "')";
		$result = mysqli_query($db, $query) or die ("Query is not successfuly.");

		// Close the database connection.
		mysqli_close($db);

		// Successful in storing the file on the server.
		return true;
	} else {
		// Close the database connection.
		mysqli_close($db);

		// Not successful in storing the file on the server.
		return false;
	}
}

// Encrypt the path where the uploaded is stored on the server.
function get_stored_path($fname) {
	// Pre-process the file name.
	$fname = htmlspecialchars($fname);
	$fname = pathinfo($fname)['filename'];
	$fname_new = 1;

	// Transform the string name into the product of the ASCII codes of all characters in the string.
	for($i = 0; $i < strlen($fname); $i++) {
		$fname_new *= ord($fname[$i]);
	}

	// Return the path accordingly.
	return "./upload/" . $fname_new . time() . rand() . ".pdf";
}

// Get the information for all files stored on the server. Used in the homepage.
function get_all_files() {
	// Create connection to the database or report error.
	$db = mysqli_connect(DB_SERVER, DB_UNAME, DB_PWORD, DB_NAME) or die("Cannot connect to the database.");

	// Make a query to the database to keep a record or report error.
	$query = "SELECT * FROM Files ORDER BY UploadTime DESC";
	$result = mysqli_query($db, $query) or die ("Query is not successfuly.");

	// Get the 2nd-dimensional associate array for all the files. Each row represents a single file.
	// $result_rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// Bug fixed, some verions of PHP do not support mysqli_fetch_all, we have to get rid of it by using a for loop.
	$result_rows = array();
	for ($i = 0; $i < mysqli_num_rows($result); $i++) { 
		$result_rows[$i] = mysqli_fetch_assoc($result);
	}


	// Close the database connection.
	mysqli_close($db);

	return $result_rows;
}

// Download a single file according to the file unique identifier. Used in the homepage.
function file_download($id) {
	// Create connection to the database or report error.
	$db = mysqli_connect(DB_SERVER, DB_UNAME, DB_PWORD, DB_NAME) or die("Cannot connect to the database.");

	// Query to the database to get the file path.
	$query = "SELECT FilePath,FileName FROM Files WHERE Id = " . $id;
	$result = mysqli_query($db, $query) or die ("Query is not successfuly.");

	if (mysqli_num_rows($result) > 0) {
		// hange the query result into an associate array and get the file path.
		$result_row = mysqli_fetch_assoc($result);
		$path = $result_row['FilePath'];
		$fname = $result_row['FileName'] . ".pdf";

		// Close the database connection.
		mysqli_close($db);

		if(!$path) {
			die("The file does not exist on the server.");
		} else {
			// Let the browser to prompt the download window.
			header('Content-Disposition: attachment; filename=' . $fname);
			// Set the transmission method to be binary without compression.
			header('Content-Transfer-Encoding: binary');
			// Tell the browser about the type of the file.
			header('Content-Type: application/pdf');
			// Set the expiry time of the page to be 0.
			header('Expires: 0');
			// Ask the browser to not save any cookies.
			header('Cache-Control: must-revalidate');
			// Tell the browser about the type of the data transferred.
			header('Accept-Ranges: bytes');
			// Read (download) the whole file.
			readfile($path);

			return true;
		}
	}
}

// Delete a single file
function file_delete($id) {
	// Create connection to the database or report error.
	$db = mysqli_connect(DB_SERVER, DB_UNAME, DB_PWORD, DB_NAME) or die("Cannot connect to the database.");

	// Avoid SQL injection by filtering special characters.
	$id = htmlspecialchars($id);

	// Query to the database to get the file path.
	$query = "SELECT * FROM Files LIMIT 1 OFFSET " . $id;
	$result = mysqli_query($db, $query) or die ("Query is not successfuly.");

	// To verify the record exists in the database.
	if (mysqli_num_rows($result) == 1) {
		// Change the query result into an associate array.
		$result_row = mysqli_fetch_assoc($result);

		// Tries to delete this row from the database.
		$query = "DELETE FROM Files WHERE Id = " . $result_row['Id'];
		mysqli_query($db, $query) or die ("Query is not successfuly.");
	} else {
		return false;
	}

	// Notice that we do not delete the file locally.
	return true;
}
?>
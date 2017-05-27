<?php
// Load the database configuration.
require_once 'config.php';

// Checks the _SESSION variable to decide whether the user has logged in.
function logged_in() {
	return isset($_SESSION['authorized']) && $_SESSION['authorized'] == true;
}

function db_connect() {
	// To establish connection to the database.
	try {
		$db = new PDO(DSN, DB_UNAME, DB_PWORD);
		// Set the error mode to throw exceptions.
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		// Catch the potential exception here for defensive programming practice.
		die("Cannot connect to the database. ". $e->getMessage() . "<br>");
	}

	return $db;
}

// To validate whether the user name and the password matches. Used in the login page.
function login_validate($uname, $pword) {
	// Avoid SQL injection by filtering special characters.
	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);

	// Create connection to the database or report error.
	$db = db_connect();

	// Prepared statement for query to the database later (to avoid SQL injection attack).
	$stmt = $db->prepare("SELECT * FROM " . DB_PREFIX . ".users WHERE username = ?");
	// Query to the database or report error.
	try {
		$stmt->execute(array($uname));
	} catch (PDOException $e) {
		// Catch the potential exception here for defensive programming practice.
		die("Cannot query to the database. ". $e->getMessage() . "<br>");
	}

	// Fetch the first row returned by the statement to an associate array.
	// Avoid using $stmt->rowCount() here due to known compatibility issues.
	$result_row = $stmt->fetch(PDO::FETCH_ASSOC);

	// There exists at least one row matching the username in the database.
	if ($result_row != null) {
		// To check whether the password matches with this username.
		// PHP secured password verify function is used (single-way hashed with bCrypt algorithm).
		if (password_verify($pword, $result_row['password'])) {
			// Register this dialog in the _SESSION to save related information.
			$_SESSION['authorized'] = true;
			$_SESSION['username'] = $result_row['username'];

			// Differentiate the user type to decide whether the user can upload/delete files.
			if ($result_row['user_type'] == 0) {
				$_SESSION['usertype'] = "admin";
			} elseif ($result_row['UserType'] == 1) {
				$_SESSION['usertype'] = "student";
			}

			// Close the database connection.
			$db = null;
			// Return true and re-direct to the homepage.
			return true;
		}
	}

	// Close the database connection.
	$db = null;
	// The validation fails. Return false and prompt false information on the page.
	return false;
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

	// Encrypt the path with time depedent.
	$path = get_stored_path($fileInfo['name']);

	// Try to store the uploaded file locally on the server.
	if(move_uploaded_file($fileInfo['tmp_name'], $path)) {
		// Create connection to the database or report error.
		$db = db_connect();

		// Prepared statement for query to the database later (to avoid SQL injection attack).
		$stmt = $db->prepare("INSERT INTO " . DB_PREFIX . ".files (file_name, author, description, file_path) VALUES (?, ?, ?, ?)");

		// Query to the database or report error.
		try {
			$stmt->execute(array($desiredName, $author, $description, $path));
		} catch (PDOException $e) {
			// Catch the potential exception here for defensive programming practice.
			die("Cannot query to the database. ". $e->getMessage() . "<br>");
		}

		// Close the database connection.
		$db = null;

		// Successful in storing the file on the server.
		return true;
	} else {
		// Close the database connection.
		$db = null;

		// Not successful in storing the file on the server.
		return false;
	}
}

// Encrypt the path where the uploaded is stored on the server.
function get_stored_path($fname) {
	// Avoid SQL injection by filtering special characters.
	$fname = htmlspecialchars($fname);
	// Get the actual file name without extension name.
	$fname = pathinfo($fname)['filename'];
	// Initialization of the new file name.
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
	$db = db_connect();

	// Prepared statement for query to the database later (to avoid SQL injection attack).
	$stmt = $db->prepare("SELECT * FROM " . DB_PREFIX . ".files ORDER BY uploaded_at DESC");
	// Query to the database or report error.
	try {
		$stmt->execute();
	} catch (PDOException $e) {
		// Catch the potential exception here for defensive programming practice.
		die("Cannot query to the database. ". $e->getMessage() . "<br>");
	}

	// Use a 2D array to fetch each row in the files table.
	$result_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// Close the database connection.
	$db = null;

	return $result_rows;
}

// Download a single file according to the file unique identifier. Used in the homepage.
function file_download($id) {
	// Create connection to the database or report error.
	$db = db_connect();

	// Prepared statement for query to the database later (to avoid SQL injection attack).
	$stmt = $db->prepare("SELECT file_path, file_name FROM " . DB_PREFIX . ".files WHERE id = ?");
	// Query to the database or report error.
	try {
		$stmt->execute(array($id));
	} catch (PDOException $e) {
		// Catch the potential exception here for defensive programming practice.
		die("Cannot query to the database. ". $e->getMessage() . "<br>");
	}

	// Fetch the query result into an associate array and get the file path.
	$result_row = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($result_row != null) {
		$path = $result_row['file_path'];
		$fname = $result_row['file_name'] . ".pdf";

		// Close the database connection.
		$db = null;

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
	} else {
		// Close the database connection.
		$db = null;
		// Return false because we cannot download the selected file.
		return false;
	}
}

// Delete a single file
function file_delete($id) {
	// Avoid SQL injection by filtering special characters.
	$id = htmlspecialchars($id);

	// Create connection to the database or report error.
	$db = db_connect();

	// Notice that there is a known bug that LIMIT and OFFSET only accepts integer parameter.
	// What we can do is to turn off emulated prepared statement.
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
	// Prepared statement for query to the database later (to avoid SQL injection attack).
	$stmt = $db->prepare("SELECT * FROM " . DB_PREFIX . ".files LIMIT 1 OFFSET ?");

	// Query to the database or report error.
	try {
		// Since we have already binded the parameter, there is no need to put any parameters here.
		$stmt->execute(array($id));
	} catch (PDOException $e) {
		// Catch the potential exception here for defensive programming practice.
		die("Cannot query to the database. ". $e->getMessage() . "<br>");
	}

	// Change the query result into an associate array.
	$result_row = $stmt->fetch(PDO::FETCH_ASSOC);

	// To verify the record exists in the database.
	if ($result_row != null) {
		// Prepared statement for query to the database later (to avoid SQL injection attack).
		$stmt = $db->prepare("DELETE FROM " . DB_PREFIX . ".files WHERE id = ?");
		// Query to the database or report error.
		try {
			$stmt->execute(array($result_row['id']));
		} catch (PDOException $e) {
			// Catch the potential exception here for defensive programming practice.
			die("Cannot query to the database. ". $e->getMessage() . "<br>");
		}

		// Close the database connection.
		$db = null;
		// Notice that we do not delete the file locally.
		return true;
	} else {
		// Close the database connection.
		$db = null;
		// Return false because we cannot find the requested file.
		return false;
	}
}
?>
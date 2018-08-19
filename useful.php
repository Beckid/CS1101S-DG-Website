<?php
// To load the database configuration.
require_once 'config/config.php';
// To load the required mailer functionality.
require_once 'mailer.php';

// To check the _SESSION variable to decide whether the user has logged in.
function logged_in() {
	return isset($_SESSION['authorized']) && $_SESSION['authorized'] == true;
}

// Helper function to establish connection to the database.
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
			} elseif ($result_row['user_type'] == 1) {
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

// To verify whether the user can change the password.
function change_password($old, $new) {
	// Avoid SQL injection by filtering special characters.
	$uname = $_SESSION['username'];
	$old = htmlspecialchars($old);
	$new = htmlspecialchars($new);

	// Check whether the user has entered the correct old password by trying to sign in.
	if (login_validate($uname, $old)) {
		// Use PHP standard encrypted single-way hash function to encrypt the password.
		// Notice: we should never store the actual password in the database.
		// PASSWORD_DEFAULT means the default encryption algorithm, Bcrypt.
		$encrypted = password_hash($new, PASSWORD_DEFAULT);

		// Create connection to the database or report error.
		$db = db_connect();

		// Prepared statement for query to the database later (to avoid SQL injection attack).
		$stmt = $db->prepare("UPDATE " . DB_PREFIX . ".users SET password = ? WHERE username = ?");
		// Query to the database or report error.
		try {
			$stmt->execute(array($encrypted, $uname));
		} catch (PDOException $e) {
			// Catch the potential exception here for defensive programming practice.
			die("Cannot query to the database. ". $e->getMessage() . "<br>");
		}

		// Close the database connection.
		$db = null;

		// The password has been changed successfully.
		return 0;
	} else {
		// Close the database connection.
		$db = null;

		// The old password is wrong.
		return 2;
	}
}

// Create a new user and send a confirmation email.
function create_user($uname, $pword, $type, $email, $is_random) {
	// Avoid SQL injection by filtering special characters.
	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);
	$type = htmlspecialchars($type);
	$email = htmlspecialchars($email);

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
	if ($stmt->fetch(PDO::FETCH_ASSOC) != null) {
		// Close the database connection.
		$db = null;

		// There exists a user with the same username.
		return 2;
	} else {
		if ($is_random) {
			// Generates a random password.
			$pword = generate_random_password();
		} else if (!password_strength_checker($pword)) {
			// Close the database connection.
			$db = null;

			// The password is too simple.
			return 3;
		}

		// Use PHP standard encrypted single-way hash function to encrypt the password.
		// Notice: we should never store the actual password in the database.
		// PASSWORD_DEFAULT means the default encryption algorithm, Bcrypt.
		$encrypted = password_hash($pword, PASSWORD_DEFAULT);

		// Prepared statement for query to the database later (to avoid SQL injection attack).
		$stmt = $db->prepare("INSERT INTO " . DB_PREFIX . ".users (user_type, username, password) VALUES (?, ?, ?)");
		// Query to the database or report error.
		try {
			$stmt->execute(array(get_user_type($type), $uname, $encrypted));
		} catch (PDOException $e) {
			// Catch the potential exception here for defensive programming practice.
			die("Cannot query to the database. ". $e->getMessage() . "<br>");
		}

		// Close the database connection.
		$db = null;

		// The new user has been created successfully.
		// For the last step, we need to send the email.
		return create_user_email($email, $uname, $pword, $is_random);
	}
}

// Check whether a given password is strong enough.
function password_strength_checker($pword) {
	return strlen($pword) >= 8 && preg_match("#[0-9]+#", $pword) && preg_match("#[a-zA-Z]+#", $pword);
}

// Generate a random password.
function generate_random_password() {
	// TODO: replace it by random_bytes when we upgrade to PHP 7.
	return bin2hex(openssl_random_pseudo_bytes(8));
}

// Get the numerical value of user type to insert into the database.
function get_user_type($type_str) {
	if ($type_str == "admin") {
		return 0;
	} else if ($type_str == "student") {
		return 1;
	} else {
		// Catch the potential exception here for defensive programming practice.
		die("The usertype is wrong.");
	}
}

// Send confirmation email to the desired email address.
function create_user_email($email, $uname, $pword, $is_random) {
	$subject = "User Registration Confirmation - CS1101S Studio Website";
	$message = "Dear user,\n\n" .
			   "Welcome to CS1101S Studio Website!\n" .
			   "We notice that a new account associated with this email address has been created recently.\n" .
			   "This email is to acknowledge you that the user registration is successful.\n\n" .
			   "Username: " . $uname . "\n";

	if ($is_random) {
		$message = $message . "Password: " . $pword . "\n\n" .
				   "We suggest you to log in and change your password as soon as possible.\n\n";
	} else {
		$message = $message . "\n";
	}

	$message = $message .
			   "Hereby, we would like to thank you again for using CS1101S DG Website.\n\n" .
			   "Sincere,\n" . 
			   "Website Admin\n" .
			   "Visit us at https://cs1101s.azurewebsites.net/";

	if (email($email, $subject, $message)) {
		return 0;
	} else {
		return 4;
	}
}

/*********************************************************************
Functions below are used for file management functionality.
*********************************************************************/

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
	// Returns the information for each file to the page.
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
	// Please comment this line if you are using Microsoft SQL Server.
	// $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
	
	// Prepared statement for query to the database later (to avoid SQL injection attack).
	$stmt = $db->prepare("SELECT * FROM " . DB_PREFIX . ".files ORDER BY id OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY");

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

function redirect_no_permission() {
	header("location: index.php");
	die("No permission to access this page.");
}
?>

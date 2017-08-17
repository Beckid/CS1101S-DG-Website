<!-- Notice: Change the file name to config.php -->

<?php
// If you are using Microsoft SQL Server, change DB_TYPE into 'sqlsrv'.
define('DB_TYPE', 'mysql', true);

// Settings that are required for connecting to the database server.
define('DB_HOST', 'localhost', true);
define('DB_NAME', 'cs1101s', true);
define('DB_PREFIX', 'cs1101s', true);
define('DB_UNAME', 'root', true);
define('DB_PWORD', '123456', true);

// Gets the DSN to help create connection to the database.
// Notice that the DSN for Microsoft SQL Server is slightly different.
if (DB_TYPE != 'sqlsrv') {
	$dsn = DB_TYPE . ":server=" . DB_HOST . ";database=" . DB_NAME;
} else {
	$dsn = DB_TYPE . ":host=" . DB_HOST . ";db_name=" . DB_NAME;
}

define('DSN', $dsn, true);

// Settings that are required for using gmail to send email.
define('EMAIL_ADDR', 'random@gmail.com', true);
define('EMAIL_PWORD', 'setUp?', true);

// Every email will be BCC'ed to admin's personal email.
define('ADMIN_EMAIL', 'iamadmin@outlook.com', true);
?>
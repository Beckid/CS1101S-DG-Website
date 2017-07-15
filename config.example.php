<!-- Notice: Change the file name to config.php -->

<?php
// Settings that are required for connecting to the database server.
define('DB_TYPE', 'mysql', true);
define('DB_HOST', 'localhost', true);
define('DB_NAME', 'cs1101s', true);
define('DB_PREFIX', 'cs1101s', true);
define('DB_UNAME', 'root', true);
define('DB_PWORD', '123456', true);

// Gets the DSN to help create connection to the database.
$dsn = DB_TYPE . ":host=" . DB_HOST . ";db_name=" . DB_NAME;
// If you are using Microsoft SQL Server, use the one below instead and 
// change DB_TYPE into 'sqlsrv'.
// $dsn = DB_TYPE . ":server=" . DB_HOST . ";database=" . DB_NAME;

define('DSN', $dsn, true);

// Settings that are required for using gmail to send email.
define('EMAIL_ADDR', 'random@gmail.com', true);
define('EMAIL_PWORD', 'setUp?', true);

// Every email will be BCC'ed to admin's personal email.
define('ADMIN_EMAIL', 'iamadmin@outlook.com', true);
?>
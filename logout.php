<?php
// Start the session, because we need _SESSION variables later on.
session_start();

// Require useful.php functions.
require_once 'useful.php';

// Clear the _SESSION arrays and erase essential variables.
log_out();

header("location: index.php");
?>
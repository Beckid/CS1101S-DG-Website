<?php
require_once 'useful.php';

file_download($_POST['file_id']);

header("location: index.php");
?>
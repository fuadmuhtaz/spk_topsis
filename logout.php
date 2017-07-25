<?php
require './includes/config.php';

session_destroy();

header('Location: login.php');
exit;
?>

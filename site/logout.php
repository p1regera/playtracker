<?php
session_start();
require("..\util\connect-db.php");

session_unset();
session_destroy();

header('Location: login.php');
exit;
?>
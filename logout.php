<?php
//echo "<em>COUNT : ".count($_SESSION)."</em>";
//die("SESSION IS OVER!");

session_start();
session_unset();
session_destroy();
session_write_close();
setcookie(session_name(), '', 0, '/');
session_regenerate_id(true);

header('Location: login.php');
die("SESSION IS OVER!");

?>
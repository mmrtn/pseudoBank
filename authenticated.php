<?php
session_start();
// die("You are not logged in!");
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {

    header('Location: login.php');
    exit();
}
?>
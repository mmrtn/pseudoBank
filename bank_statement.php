<?php
session_start();

function redirect()
{

    $_SESSION["failed"] = 'true';
    header("Location: login.php");
    exit();
}
require_once('Db.php');
require_once('functions.php');

if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST)) {
    if (login_auth($_POST['username'], $_POST['password'])) {
        $user_details = get_user_details($_POST['username']);

        $_SESSION["authenticated"] = 'true';
        $_SESSION["username"] = $_POST['username'];
    } else {
        failed_login();
        redirect();
    }

} else {

    if (!isset($_SESSION["authenticated"])) {
        require('authenticated.php');
    }
    else {
        $user_details = get_user_details($_SESSION["username"]);
    }

}

?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="assets/img/coin.gif">

    <title>PSEUDO BANK</title>


    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html {
            display: table;
            margin: auto;
        }
    </style>


<body>
<div id="container">

    <h1>Welcome <em style="color:green;"><?= $user_details['owner_name'] ?></em></h1>

    <h2>Summary statement</h2>
    <ul>
        <li>Current net credit: <?= $user_details['amount'] ?></li>
        <li>Account number: <?= $user_details['account_number'] ?></li>
    </ul>

    <form action="logout.php" id="login" method="post">
        <input type="submit" value="Log Out!">
    </form>
</div>
</body>
</html>



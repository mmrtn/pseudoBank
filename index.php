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
    } else {
        $user_details = get_user_details($_SESSION["username"]);
        if (array_key_exists('statement', $_POST)) {

            $statement = get_user_statement($_SESSION["username"]);
            // var_dump($statement);

        }
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

    <h2 style="color: #ffa102">PSEUDO BANK</h2>

    <h2>Welcome <em style="color:green;"><?= $user_details['owner_name'] ?></em></h2>

    <h2>Summary statement</h2>
    <ul>
        <li>Current net credit: <?= $user_details['amount'] ?></li>
        <li>Account number: <?= $user_details['account_number'] ?></li>
    </ul>

    <form action="logout.php" id="logout" method="post">
        <input class="btn btn-sm btn-danger btn-block" type="submit" value="Log Out!">
    </form>
    <br/>

<!--    <form action="index.php" id="statement" method="post">-->
<!--        <input id='statement' class="btn btn-sm btn-info btn-block" name='statement' type="submit" value="Bank Statement">-->
<!--    </form>-->
    <div>
        <?php
        //  get_user_statement($_SESSION["username"]);

        ?>

    </div>

</div>
</body>
</html>
<script>


</script>


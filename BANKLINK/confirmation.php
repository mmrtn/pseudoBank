<?php
require_once('../config.php');
require_once('../Db.php');
require_once('../Banking.php');
require_once('../functions.php');
require_once('Banklink.php');

session_start();

if (isset($_POST) && empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST)) {
        if (login_auth($_POST['username'], $_POST['password'])) {

            $user_details = get_user_details($_POST['username']);

            $_SESSION["authenticated"] = 'true';
            $_SESSION["username"] = $_POST['username'];
            unset($_POST['username']);
            unset($_POST['password']);

            $user_details = get_user_details($_SESSION["username"]);
            $_SESSION['owner_name'] = $user_details['owner_name'];
            $_SESSION['account_number'] = $user_details['account_number'];
            $_SESSION['available_funds'] = $user_details['amount'];

        } else {
            $_SESSION["failed"] = 'true';
            header('Location:login.php');
            exit();
        }
    }
}




if (!empty($_SESSION["authenticated"]) && $_SESSION["authenticated"]) {

    if (array_key_exists('confirm', $_POST)) {
        $transfer=Banking::tranfer($_SESSION['account_number'], $_SESSION['beneficiary_account'], $_SESSION['amount'], $_SESSION['description']);
        if ($transfer==='Your payment is made') {
            $_SESSION['confirmed'] = $transfer;
            Banklink::delete_banklink($_SESSION["banklink"]);
            header('Location:confirmed.php');
            exit();
        }
        else {
            echo "<h1>$transfer</h1>";
        }
    }

    if (array_key_exists('cancle', $_POST)) {
        Banklink::delete_banklink($_SESSION["banklink"]);
        Banklink::logout();
    }
    ?>

    <!doctype html>

    <html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="../assets/img/coin.gif">

        <title>Payment Confirmation</title>


        <!-- Bootstrap core CSS -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
        <script type='text/javascript' src='http://code.jquery.com/jquery-1.11.3.min.js'></script>
        <style>
            html {
                display: table;
                margin: auto;
            }

            #funds {
                font-weight: bold;
                color: <?=($_SESSION['available_funds']>=$_SESSION['amount']) ? 'green;' : 'red;'  ?>

            }
        </style>

    <body>


    <div id="container">
        <span><h2 style="color: #ffa102">PSEUDO BANK</h2></span>

        <h2>Payment Confirmation</h2>

        <p>Date: <?= date('d-m-Y') ?></p>

        <p>Payer name: <?= $_SESSION['owner_name'] ?></p>

        <p>Payer account: <?= $_SESSION['account_number'] ?></p>

        <p>Beneficiary name: <?= $_SESSION['beneficiary_name'] ?></p>

        <p>Beneficiary account: <?= $_SESSION['beneficiary_account'] ?></p>

        <p>
            Amount: <?= $_SESSION['amount'] . '<span id="funds"> (AVAILABLE FUNDS:' . $_SESSION['available_funds'] . ')</span>' ?></p>

        <p>Description: <?= $_SESSION['description'] ?></p>

        <form action="confirmation.php" method="post">
            <input id='confirm' class="btn btn-lg btn-primary btn-block" name='confirm' type="submit" value="CONFIRM PAYMENT"/>
        </form>
        <br/>

        <form action="confirmation.php" method="post">
            <input id='cancle' class="btn btn-lg btn-danger btn-block" name='cancle' type="submit" value="CANCLE"/>
        </form>

    </div>
    </body>
    </html>


<?php } ?>
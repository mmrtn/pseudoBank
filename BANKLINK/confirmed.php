<?php
date_default_timezone_set('Europe/Tallinn');
ini_set('date.timezone', 'Europe/Tallinn');

require_once 'Banklink.php';
session_start();
if (!empty($_SESSION["authenticated"]) && $_SESSION['confirmed'] && $_SESSION["authenticated"]) { ?>


    <!doctype html>

    <html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="../assets/img/coin.gif">

        <title>Payment Confirmed!</title>


        <!-- Bootstrap core CSS -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

        <style>
            html {
                display: table;
                margin: auto;
            }
        </style>

    <body>


    <div id="container">
        <span><h2 style="color: #ffa102">PSEUDO BANK</h2></span>

        <h2 style="color: blue"><?= $_SESSION['confirmed'] ?></h2>

        <p>Date: <?= date('d-m-Y') ?></p>

        <p>Payer name: <?= $_SESSION['owner_name'] ?></p>

        <p>Payer account: <?= $_SESSION['account_number'] ?></p>

        <p>Beneficiary name: <?= $_SESSION['beneficiary_name'] ?></p>

        <p>Beneficiary account: <?= $_SESSION['beneficiary_account'] ?></p>

        <p>Amount: <?= $_SESSION['amount'] ?></p>

        <p>Description: <?= $_SESSION['description'] ?></p>

    </div>
    </body>
    </html>

<?php }
session_destroy();
Banklink::logout(false);


?>
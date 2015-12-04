<?php

require_once 'Banklink.php';

if (array_key_exists('link', $_GET)) {
    $link = (ctype_alnum($_GET['link'])) ? $_GET['link'] : false;

    if (Banklink::is_valid_link($link)) {

        $payment_details=Banklink::get_details($link);

        session_start();
        $_SESSION['user_id']=$payment_details['user_id'];
        $_SESSION['beneficiary_name']=$payment_details['owner_name'];
        $_SESSION['beneficiary_account']=$payment_details['account_number'];
        $_SESSION['banklink']=$payment_details['banklink'];
        $_SESSION['amount']=$payment_details['amount'];
        $_SESSION['description']=$payment_details['description'];

        header('Location:login.php');
        exit();
    }

}


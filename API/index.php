<?php
require_once('../Db.php');
require_once('../Banking.php');
require_once('WebAPI.php');
require_once('Api_methods.php');

// $token1='xNFQGbrBJdRbywG4GSFBaRWGR';

$api_response = array();
$p = $_POST;

function all_keys_valid($post)
{
    global $api_response;
    $keys = array('apikey', 'description', 'amount'); //All MUST have keys!

    foreach ($keys as $k) {
        if (!array_key_exists($k, $post)) {
            $api_response['message'] = "parameter: $k is missing";
            $api_response['status'] = 400;
            // $api_response['Instructions'] = 'http://localhost/pseudoBank/API/instructions.php';
            // header('Location: instructions.php');
            return false;

        }
    }

    if (strlen($post['description'])>120) {
        $api_response['message'] = "Description can be up to 120 character long";
        return false;
    }

    if (ctype_alnum($post['apikey']) && !Api_methods::is_valid_token($post['apikey'])) {
        $api_response['message'] = "Invalid APIKEY!";
        return false;
    }


    if (!is_numeric($post['amount']) || $post['amount'] < 1 || $post['amount'] > 10000) {
        $api_response['message'] = "amount must be between 1.0-10.000";
        return false;
    }
    return true;
}

if (isset($_POST)) {
    if (all_keys_valid($_POST)) {
        $api_response['status'] = 200;
        $api_response['banklink'] = 'http://pseudobank.esy.es/BANKLINK/?link=' . Api_methods::create_banklink($p['apikey'], $p['amount'], htmlspecialchars($p['description']));

    } else {
        $api_response['status'] = 400;
        if ($api_response['message'] === "Invalid APIKEY!") {
            $api_response['status'] = 403;
        }


    }

    WebAPI::deliver_response('json', $api_response);

}

else {
    header('Location: instructions.php');
    exit();
}

<?php

$api_response = array();
$p = $_POST;
$ip = $_SERVER['REMOTE_ADDR'];
$bank_ip = '185.28.20.'; //main part of Pseudobank IP - last nr might change...
$api_response['ip'] = $ip;
$apikey = '1234567890xxxxSECRET';

function deliver_json_response($api_response)
{
    // Define HTTP responses
    $http_response_code = array(
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found'
    );

    header('HTTP/1.1 ' . $api_response['status'] . ' ' . $http_response_code[$api_response['status']]);
    header('Content-Type: application/json; charset=utf-8');

    $json_response = json_encode($api_response);
    // Deliver formatted data
    echo $json_response;

}


function all_keys_valid($post)
{
    global $api_response;
    global $apikey;

    $keys = array('apikey', 'description', 'amount'); //All MUST have keys!

    foreach ($keys as $k) {
        if (!array_key_exists($k, $post)) {
            $api_response['message'] = "parameter: $k is missing";
            $api_response['status'] = 400;

            return false;

        }
    }

    if (strlen($post['description']) > 120) {
        $api_response['message'] = "Description can be up to 120 character long";
        return false;
    }

    if (!ctype_alnum($post['apikey']) || $post['apikey'] !== $apikey) {
        $api_response['message'] = "Invalid APIKEY!";
        return false;
    }

    if (!is_numeric($post['amount']) || $post['amount'] < 1 || $post['amount'] > 10000) {
        $api_response['message'] = "amount must be between 1.0-10.000";
        return false;
    }
    return true;
}


if (isset($_POST) && strpos($ip, $bank_ip) !== false) {
    if (all_keys_valid($_POST)) {

        $api_response['status'] = 200;
        $api_response['message'] = 'CONFIRMED';

    } else {
        $api_response['status'] = 400;
        if ($api_response['message'] === "Invalid APIKEY!") {
            $api_response['status'] = 403;
        }
    }

    deliver_json_response($api_response);

    if ($api_response['status']===200) {

        // DO SOMETHING USEFUL!

    }

}
<?php
$apikey = '1234567890xxxxSECRET';
$amount = 99.89;
$description = 'description abcdt# order nr 111222333 / product etc';
$owner_name='John Doe';

function send_confmsg($apikey, $amount, $description, $owner_name)
{
    $url = 'http://webapi.esy.es/endpoint/';
    $data = array('apikey' => $apikey, 'amount' => $amount, 'description' => $description, 'payerName'=>$owner_name);

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context = stream_context_create($options);
    $json = file_get_contents($url, false, $context);

    $search_results = json_decode($json, TRUE);
    if ($search_results === NULL)
        die('json query error!');

    return $search_results;
}

print_r(send_confmsg($apikey, $amount, $description, $owner_name));
<?php
require_once('WebAPI.php');

$token1='xNFQGbrBJdRbywG4GSFBaRWGR';
$api_response=array();

function all_keys_valid($post)  {
    global $api_response;
    $keys=array('apikey','description', 'amount');
    foreach ($keys as $k) {
        if (!array_key_exists($k, $post)) {
            $api_response['message']="parameter: $k is missing";
            return false;
        }
        if (!ctype_alnum($post[$k])) {
            $api_response['message']="Only alphanumeric characters are allowed!";
            return false;
        }
    }

    if ($post['amount']<=0 || $post['amount']>10000) {
        $api_response['message']="amount must be between 1.0-10.000";
        return false;
    }
    return true;
}

if (isset($_POST)) {
    if (all_keys_valid($_POST) && $_POST['apikey']=$token1) {
        $api_response['status']=200;
        $api_response['message']='good enogh!';
    }

    else {
        $api_response['status']=400;


    }

    WebAPI::deliver_response('json', $api_response);

}
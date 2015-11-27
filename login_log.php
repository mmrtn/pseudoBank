<?php

function get_timestamp() {
    $date = new DateTime();
    $date_format = $date->format("Y-m-d H:i:s");
    return $date_format;
}

function get_ip_info($ip) {
    
    
    $jsonurl = 'http://ip-api.com/json/'.$ip;
    // var_dump(str_replace(' ', '+', $jsonurl));

    $json = file_get_contents(str_replace(' ', '+', $jsonurl));

    $search_results = json_decode($json, TRUE);

    $country = $search_results['country'];
    $city = $search_results['city'];
    $isp = $search_results['isp'];
    $result="Country: ".$country."; City: ".$city."; ISP: ".$isp;
    
    return $result;
}

function get_visitor_information() {
    $ip=$_SERVER['REMOTE_ADDR'];
    $info=array(
        'ip'=>$_SERVER['REMOTE_ADDR'],
        'server'=>$_SERVER['SERVER_NAME'],
        'browser'=>$_SERVER['HTTP_USER_AGENT'],
        'origin'=>get_ip_info($ip),
        'timestamp'=>get_timestamp()
    );
    return $info;
}

function log_query($line) {
    
    file_put_contents('visitor.log', PHP_EOL . $line, FILE_APPEND);
}

date_default_timezone_set('Europe/Tallinn');
log_query(json_encode(get_visitor_information()));

?>
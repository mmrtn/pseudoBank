<?php

function failed_login() {
    if (!$_SERVER['SERVER_NAME']==='localhost') {
        date_default_timezone_set('Europe/Tallinn');
        ini_set('date.timezone','Europe/Tallinn');
        require_once 'login_log.php';
    }

}

function login_auth($login_name, $login_pwd) {
    require_once('config.php');
    $db_conn = new Database(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

    $sql="SELECT password FROM users WHERE username = '".mysqli_real_escape_string ($db_conn->get_conn() , $login_name )."'";
   //  $sql="SELECT password FROM users WHERE username = '".$login_name."'";

    $query_result = $db_conn->db_query($sql)->fetch_assoc();
    $db_conn->close_conn();
    if ($query_result['password']===$login_pwd) {
        return true;
    }
    return false;

}

function get_user_details($username) {
    require_once('config.php');
    $db_conn = new Database(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
    $sql="SELECT * FROM users WHERE username = '".$username."'";

    $query_result = $db_conn->db_query($sql)->fetch_assoc();


    $db_conn->close_conn();

    return $query_result;

}

?>
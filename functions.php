<?php

require_once('config.php');
function failed_login()
{
    if (!$_SERVER['SERVER_NAME'] === 'localhost') {
        date_default_timezone_set('Europe/Tallinn');
        ini_set('date.timezone', 'Europe/Tallinn');
        require_once 'login_log.php';
    }

}

function login_auth($login_name, $login_pwd)
{

    $db_conn = new Database(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

    $sql = "SELECT password FROM users WHERE username = '" . mysqli_real_escape_string($db_conn->get_conn(), $login_name) . "'";
    //  $sql="SELECT password FROM users WHERE username = '".$login_name."'";

    $query_result = $db_conn->db_query($sql)->fetch_assoc();
    $db_conn->close_conn();
    if ($query_result['password'] === $login_pwd) {
        return true;
    }
    return false;

}

function get_user_details($username)
{

    $db_conn = new Database(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
    $sql = "SELECT * FROM users WHERE username = '" . $username . "'";

    $query_result = $db_conn->db_query($sql)->fetch_assoc();


    $db_conn->close_conn();

    return $query_result;

}

function get_user_statement($username)
{
    $db_conn = new Database(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
    $sql = "SELECT transaction.`date`,transaction.`description`, transaction.`amount`, (SELECT users.owner_name FROM users WHERE transaction.`origin_account`=users.account_number) AS 'FROM'
    FROM `transaction`
    WHERE
    (transaction.`origin_account`= (SELECT account_number FROM users WHERE username=" . "'" . $username . "'" . "))
    OR
    (transaction.`destination_account`= (SELECT account_number FROM users WHERE username=" . "'" . $username . "'" . "))
    ORDER BY `transaction`.`date` DESC
    ";

    $query_result = $db_conn->db_query($sql);
    return $query_result;

//    foreach ($query_result as $row) {
//        echo "<p>" . var_dump($row) . "</p>";
//    }
}

?>
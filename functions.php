<?php

$db = Db::getInstance()->getConnection();

function failed_login()
{
    if ($_SERVER['SERVER_NAME'] !== 'localhost') {
        date_default_timezone_set('Europe/Tallinn');
        ini_set('date.timezone', 'Europe/Tallinn');
        require_once 'login_log.php';
    }

}

function login_auth($login_name, $login_pwd)
{
    global $db;

    $sql = "SELECT password FROM users WHERE username = '" . mysqli_real_escape_string($db, $login_name) . "'";
    //  $sql="SELECT password FROM users WHERE username = '".$login_name."'";

    $query_result = mysqli_query($db, $sql)->fetch_assoc();


    if ($query_result['password'] === $login_pwd) {
        return true;
    }
    return false;

}

function get_user_details($username)
{
    global $db;

    $sql = "SELECT * FROM users WHERE username = '" . $username . "'";

    $query_result = mysqli_query($db, $sql)->fetch_assoc();

    return $query_result;

}

function get_user_statement($username)
{
    global $db;

    $sql = "SELECT transaction.`date`,transaction.`description`, transaction.`amount`,
    (SELECT users.owner_name FROM users WHERE transaction.`origin_account`=users.account_number) AS 'FROM',
    (SELECT users.owner_name FROM users WHERE transaction.`destination_account`=users.account_number) AS 'TO'
    FROM `transaction`
    WHERE
    (transaction.`origin_account`= (SELECT account_number FROM users WHERE username=" . "'" . $username . "'" . "))
    OR
    (transaction.`destination_account`= (SELECT account_number FROM users WHERE username=" . "'" . $username . "'" . "))
    ORDER BY `transaction`.`date` DESC
    ";

    $query_result = mysqli_query($db, $sql);
    return $query_result;

}

function logout()
{
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(), '', 0, '/');
    session_regenerate_id(true);


    header('Location: index.php');
    die("SESSION IS OVER!");
}

?>
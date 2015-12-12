<?php

require_once '../config.php';
require_once '../Db.php';

class Banklink
{
    static function is_valid_link($banklink)
    {

        $db = Db::getInstance()->getConnection();

        $sql = "SELECT `banklink` FROM `banklinks` WHERE `banklink`='" . mysqli_real_escape_string($db, $banklink) . "'";
        $query_result = mysqli_query($db, $sql);
        if (mysqli_num_rows($query_result) > 0) {
            return true;
        }
        return false;
    }


    static function get_details($banklink)
    {

        $db = Db::getInstance()->getConnection();

        $sql = "SELECT banklinks.*,users.account_number, users.owner_name, tokens.return_url, tokens.confirm_url FROM `banklinks`
                INNER JOIN users ON banklinks.user_id=users.user_id
                INNER JOIN tokens ON banklinks.user_id=tokens.user_id
                WHERE banklinks.banklink='" . mysqli_real_escape_string($db, $banklink) . "'";
        $result = mysqli_query($db, $sql)->fetch_assoc();

        return $result;
    }


    static function logout($header = true)
    {
        session_start();
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(), '', 0, '/');
        session_regenerate_id(true);


        if ($header) {
            header('Location: ../login.php');
            die("SESSION IS OVER!");
        }
    }

    static function delete_banklink($banklink)
    {
        $db = Db::getInstance()->getConnection();
        $sql = "DELETE FROM `banklinks` WHERE `banklink`='$banklink'";
        mysqli_query($db, $sql);
    }


    static function send_cofirmation($url, $amount, $description, $owner_name, $apikey='1234567890xxxxSECRET')
    {
        $data = array('apikey' => $apikey, 'amount' => $amount, 'description' => $description, 'payerName'=>$owner_name);

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        try {
            $context = stream_context_create($options);
            $json = file_get_contents($url, false, $context);

            $search_results = json_decode($json, TRUE);
                //        if ($search_results === NULL)
                //            die('json query error!');
            return $search_results['status'];

        }
        catch (Exception $e) {
            return null;
        }
    }

}


<?php
require_once '../config.php';

class Api_methods
{
    static function is_valid_token($token)
    {

        $db = Db::getInstance()->getConnection();

        $sql = "SELECT `token` FROM `tokens` WHERE `token`='" . mysqli_real_escape_string($db, $token) . "'";
        $query_result = mysqli_query($db, $sql);
        if (mysqli_num_rows($query_result) > 0) {

            return true;
        }

        return false;
    }

    static function generateRandomString($length = 60)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    static function create_banklink($token, $amount, $description) {

        $banklink = self::generateRandomString();
        $db = Db::getInstance()->getConnection();


        $insert_format="INSERT INTO `banklinks`(`banklink`, `user_id`, `amount`, `description`) VALUES
        ('%s', (SELECT `user_id` FROM `tokens` WHERE `token`='$token'), '%s', '%s');";

        $insert_query=sprintf($insert_format, $banklink, $amount, $description);

        mysqli_query($db, $insert_query);

        return $banklink;

    }

}

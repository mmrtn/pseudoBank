<?php


class Banking
{
    static function is_valid($account1, $account2 = 0)
    {
        $db = Db::getInstance()->getConnection();
        // IN CASE OF 1 account
        if (!$account2) {
            $sql = "SELECT `user_id` FROM `users` WHERE `account_number`='" . mysqli_real_escape_string($db, $account1) . "'";
            $query_result = mysqli_query($db, $sql);
            if (mysqli_num_rows($query_result) > 0) {

                return true;
            }
            // IN CASE OF 2 accounts
        } else {
            $sql = "SELECT `user_id` FROM `users` WHERE `account_number`='" .
                mysqli_real_escape_string($db, $account1) . "' OR `account_number`=" . "'" .
                mysqli_real_escape_string($db, $account2) . "'";
            $query_result = mysqli_query($db, $sql);
            if (mysqli_num_rows($query_result) > 1) {

                return true;
            }
        }

        return false;
    }

    static function has_enough_fund($account, $amount)

    {

        $db = Db::getInstance()->getConnection();

        $sql = "SELECT `amount` FROM `users` WHERE `account_number`='" . mysqli_real_escape_string($db, $account) . "'";
        $query_result = mysqli_query($db, $sql)->fetch_assoc();
        if ($query_result['amount'] >= $amount) {
            return true;
        }

        return false;
    }


    static function tranfer($from, $to, $amount, $desc)
    {
        if (self::is_valid($from, $to)) {

            if (self::has_enough_fund($from, $amount)) {
                $db = Db::getInstance()->getConnection();

                $insert_format = "
                INSERT INTO `transaction` (`origin_account`, `destination_account`, `description`, `amount`)
                VALUES ('%s', '%s', '%s', '%s');";

                $insert_query=sprintf($insert_format, $from, $to, $desc, $amount);

                $sql = "
                UPDATE users SET
                    `amount` = IF(`account_number`=$from, (`amount`-$amount),  (`amount`+$amount))
                WHERE `account_number` IN ($from, $to);
                ";

                mysqli_query($db, $sql);
                mysqli_query($db, $insert_query);


            } else {
                return 'Non-sufficient funds';
            }
        } else {
            return 'Invalid account nr';
        }

        return 'Your payment is made';

    }
}
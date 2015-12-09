<?php
session_start();

function redirect()
{
    $_SESSION["failed"] = 'true';
    header("Location: login.php");
    exit();
}

require_once('Db.php');
require_once('functions.php');
if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST)) {
    if (login_auth($_POST['username'], $_POST['password'])) {
        $user_details = get_user_details($_POST['username']);

        $_SESSION["authenticated"] = 'true';
        $_SESSION["username"] = $_POST['username'];
    } else {
        failed_login();
        redirect();
    }

} else {

    if (!isset($_SESSION["authenticated"])) {
        require('authenticated.php');
    } else {
        $user_details = get_user_details($_SESSION["username"]);
        if (array_key_exists('statement', $_POST)) {

            $statement = get_user_statement($_SESSION["username"]);
            // var_dump($statement);

        }
    }

}

?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="assets/img/coin.gif">
    <link rel="stylesheet" type="text/css"
          href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8"
            src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" charset="utf8"
            src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>


    <title>PSEUDO BANK</title>


    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html {
            display: table;
            margin: auto;
        }

        #statement {
            display: none;
        }
    </style>


<body>
<div id="container">


    <h2 style="color: #ffa102">PSEUDO BANK</h2>

    <h2>Welcome <span style="color:green;"><?= $user_details['owner_name'] ?></span></h2>

    <h2>Summary statement</h2>

    <ul>
        <li>Current net credit: <?= $user_details['amount'] ?></li>
        <li>Account number: <?= $user_details['account_number'] ?></li>
    </ul>
    <button id="show-tbl" class="btn btn-group-lg btn-success btn-block">SHOW BANK STATEMENT</button>
    <br />
    <div id="statement">
        <?php $statement = get_user_statement($_SESSION["username"]); ?>

        <table id="tbl">
            <thead>
            <tr>
                <td>Date and time</td>
                <td>Description</td>
                <td>Amount</td>
                <td>FROM</td>
                <td>TO</td>
            </tr>
            </thead>
            <?php foreach ($statement as $row) { ?>

                <tr>
                    <td><?= $row['date'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['amount'] ?></td>
                    <td><?= $row['FROM'] ?></td>
                    <td><?= $row['TO'] ?></td>
                </tr>
            <?php }; ?>
        </table>

    </div>

    <br/>
</div>


<form action="logout.php" id="logout" method="post">
    <input class="btn btn-group-lg btn-danger" type="submit" value="Log Out!">
</form>
</body>
<script>

    $(document).ready(function() {
        show=false;
        $('#tbl').DataTable();
        $('#show-tbl').click(function () {

           $('#statement').toggle();
            if (!show) {
                $('#show-tbl').text('HIDE BANK STATEMENT');
                show=true;
            }
            else {
                $('#show-tbl').text('SHOW BANK STATEMENT');
                show=false;
            }
        });

    } );
</script>

</html>


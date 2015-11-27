<?php

//
//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    require_once('Database.php');
//
//    $username = $_POST["username"];
//    $password = $_POST["password"];
//
//
//    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
//        $username = $_POST["username"];
//        $password = $_POST["password"];
//
//        require_once('functions.php');
//
//        if (login_auth($username, $password)) {
//            session_start();
//            $_SESSION["authenticated"] = 'true';
//            $host  = $_SERVER['HTTP_HOST'];
//            $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
//            $extra = "?username=$username";  // change accordingly
//            header("Location: $uri/$extra");
//
//            exit();
//
//        } else {
//            header('Location: login.php');
//            exit();
//
//        }
//
//    } else {
//        header('Location: login.php');
//        exit();
//
//    }
//}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="assets/img/coin.gif">

    <title>PSEUDO BANK</title>

    <!-- Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div>
    <div style="width: 40px;

            height: 40px;
            background-image: url('assets/img/coin.gif');
            background-size: 100%;
            background-repeat: no-repeat;
            display: inline-block;
    ">
        </div>



    <div class="container">
        <span><h2 style="color: #ffa102">PSEUDO BANK</h2></span>
        <form class="form-signin" action="index.php" method="post">
            <h3 class="form-signin-heading">Please sign in</h3>
            <label for="inputAccountID" class="sr-only">Account ID</label>
            <input type="accountid" name="username" id="Account ID" class="form-control" placeholder="Account ID"
                   required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password"
                   required>


            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>


    </div>
    <!-- /container -->
</div>

</body>
</html>

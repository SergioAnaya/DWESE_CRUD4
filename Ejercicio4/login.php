<?php

require_once(realpath(dirname(__FILE__) . '/services/user-crud.service.php'));
require_once(realpath(dirname(__FILE__) . '/services/validations.service.php'));

$userCrud = new userCrud();
$validations = new Validations();

$username = $_POST['username'];
$password = $_POST['password'];
$printErrors = [];

if (!empty($_SESSION['username']) OR !empty($_SESSION['userType'])) {
    session_unset();
    session_destroy();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($_POST['submitBtn'])) {
    if ($validations -> isValidLogin()) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['userType'] = $userCrud -> userType($username);
        header('Location: index.php');
    } else $printErrors = $validations -> getErrors();
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<div class="container">
    <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" class="col s12 form">
        <span class="title">Login</span>
        <div class="row">
            <div class="input-field col s6">
                <i class="material-icons prefix">account_circle</i>
                <input id="username" type="text" class="validate" name="username" value="<?=!empty($username)?$username:''?>">
                <label for="username">Username</label>
                <span class="message"><?=$printErrors['username']?></span>
            </div>
            <div class="input-field col s6">
                <input id="password" type="password" class="validate" name="password" value="<?=!empty($password)?$password:''?>">
                <label for="password">Password</label>
                <span class="message"><?=$printErrors['password']?></span>
            </div>
        </div>
        <div class="row">
            <button class="btn waves-effect waves-custom-purple" type="submit" name="submitBtn">Submit</button>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <a href="register.php">Register now</a>
            </div>
        </div>
    </form>
</div>
</body>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</html>
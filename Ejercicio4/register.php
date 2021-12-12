<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/class//DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Config/config.php';
global $config;
require_once $config['paths']['models']['user'];
require_once $config['paths']['services']['crud']['user'];
require_once $config['paths']['services']['validations'];
require_once $config['paths']['services']['views'];

session_start();

$userCrud = new userCrud();
$validations = new Validations();
$views = new Views();

$name = $_POST['name'];
$lastnames = $_POST['lastnames'];
$username = $_POST['username'];
$password = $_POST['password'];
$adminUser = $_POST['adminUser'];

$printErrors = [];
$printAddAdminUser = '';
$printLoginNow = $views -> printLoginNow();
$printNav = '';
$userAdded = false;
$printMessageAddedOk = '';

if (isset($_SESSION['username']) AND isset($_SESSION['userType']) AND $_SESSION['userType'] !== 'Administrator') {
    header('Location: forbidden.php');
}

if (!empty($_SESSION['username']) AND !empty($_SESSION['userType']) AND $_SESSION['userType'] === 'Administrator') {
    $printAddAdminUser = $views -> printAddAdminUserCheck();
    $printNav = $views -> printNavAdminUserView();
    $printLoginNow = '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($_POST['submitBtn'])) {
    if ($validations -> isValidRegister()) {
        $user = new User($name, $lastnames, $username, $password);
        if (isset($adminUser) AND $adminUser === 'adminUser') {
            $userCrud -> createUser($user, 1);
        } else $userCrud -> createUser($user, 2);
        $userAdded = true;
    } else $printErrors = $validations -> getErrors();
}

if ($userAdded) {
    $printMessageAddedOk = 'The user has successfully registered.';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="Assets/style.css" type="text/css">
</head>
<body>
<?=$printNav?>
<div class="container">
    <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" class="col s12 form">
        <span class="title">Register</span>
        <div class="row">
            <div class="input-field col s6">
                <input id="name" type="text" class="validate" name="name" value="<?=!empty($name)?$name:''?>">
                <label for="name">Name</label>
                <span class="message"><?=$printErrors['name']?></span>
            </div>
            <div class="input-field col s6">
                <input id="lastnames" type="text" class="validate" name="lastnames" value="<?=!empty($lastnames)?$lastnames:''?>">
                <label for="lastnames">Lastnames</label>
                <span class="message"><?=$printErrors['lastnames']?></span>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
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
        <?=$printAddAdminUser?>
        <div class="row">
            <button class="btn waves-effect waves-custom-purple" type="submit" name="submitBtn">Submit</button>
        </div>
        <?=$printLoginNow?>
        <span class="message">
            <?=$printMessageAddedOk?>
        </span>
    </form>
</div>
</body>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</html>
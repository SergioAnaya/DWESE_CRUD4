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

$userId = '';
$userOld = '';

$printErrors = [];
$printAddAdminUser = '';
$printNav = '';
$userEdited = false;
$printMessageEditedOk = '';

if (isset($_SESSION['username']) AND isset($_SESSION['userType']) AND $_SESSION['userType'] !== 'Administrator') {
    header('Location: forbidden.php');
}

if (!empty($_SESSION['username']) AND !empty($_SESSION['userType']) AND $_SESSION['userType'] === 'Administrator') {
    $printAddAdminUser = $views -> printAddAdminUserCheck();
    $printNav = $views -> printNavAdminUserView();
}

if (isset($_GET['username'])) {
    $_SESSION['usernameForEdit'] = $_GET['username'];
}

if (isset($_SESSION['usernameForEdit'])) {
    $userId = $userCrud -> idByUsername($_SESSION['usernameForEdit']);
    $userOld = $userCrud -> userByUsername($_SESSION['usernameForEdit']);
} else header('Location: users.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($_POST['submitBtn'])) {
    if ($validations -> isValidEdit($userOld -> getUsername())) {
        $user = new User($name, $lastnames, $username, $password);
        if (isset($adminUser) AND $adminUser === 'adminUser') {
            $userCrud -> updateUser($user, $userId, 1);
        } else {
            $userCrud -> updateUser($user, $userId, 2);
        }
        $userOld = $userCrud -> userByUsername($user -> getUsername());
        $userEdited = true;
    } else $printErrors = $validations -> getErrors();
}

if ($userEdited) {
    $printMessageEditedOk = 'The user has successfully edited.';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit</title>

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
                <input id="name" type="text" class="validate" name="name" value="<?=!empty($userOld -> getName())?$userOld -> getName():''?>">
                <label for="name">Name</label>
                <span class="message"><?=$printErrors['name']?></span>
            </div>
            <div class="input-field col s6">
                <input id="lastnames" type="text" class="validate" name="lastnames" value="<?=!empty($userOld -> getLastnames())?$userOld -> getLastnames():''?>">
                <label for="lastnames">Lastnames</label>
                <span class="message"><?=$printErrors['lastnames']?></span>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input id="username" type="text" class="validate" name="username" value="<?=!empty($userOld -> getUsername())?$userOld -> getUsername():''?>">
                <label for="username">Username</label>
                <span class="message"><?=$printErrors['username']?></span>
            </div>
            <div class="input-field col s6">
                <input id="password" type="password" class="validate" name="password" value="<?=!empty($userOld -> getPassword())?$userOld -> getPassword():''?>">
                <label for="password">Password</label>
                <span class="message"><?=$printErrors['password']?></span>
            </div>
        </div>
        <?=$printAddAdminUser?>
        <div class="row">
            <button class="btn waves-effect waves-custom-purple" type="submit" name="submitBtn">Submit</button>
        </div>
        <span class="message">
            <?=$printMessageEditedOk?>
        </span>
    </form>
</div>
</body>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</html>
<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/class//DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Config/config.php';
global $config;
require_once $config['paths']['services']['crud']['user'];
require_once $config['paths']['services']['views'];

session_start();

$userCrud = new userCrud();
$views = new Views();

$printNav = $views -> printNavAdminUserView();
$printDeleteConfirm = '';
$userDeleted = false;
$printMessageDeletedOk = '';

if (empty($_SESSION['username']) OR empty($_SESSION['userType'])) {
    header('Location: login.php');
}

if (isset($_GET['action']) AND $_GET['action'] === 'delete') {
    $username = $_GET['username'];
    $user = $userCrud -> userByUsername($username);
    $printDeleteConfirm = $views -> printMessageDeleteUser($user);
}

if (isset($_POST['acceptDelete'])) {
    $userCrud -> deleteUser($_POST['usernameForDelete']);
    $userDeleted = true;
}

if ($userDeleted) {
    $printMessageDeletedOk = 'The user has been successfully deleted.';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Users</title>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="Assets/style.css" type="text/css">
</head>
<body>
<?=$printNav?>
<div class="container-users">
    <form action="register.php" method="POST" class="col s12 form">
        <button class="btn waves-effect waves-custom-purple" type="submit">Add user</button>
    </form>
    <div class="container-table">
        <table border="1">
            <tr>
                <td class="header">Name</td>
                <td class="header">Lastnames</td>
                <td class="header">Username</td>
                <td class="header">Password</td>
                <td colspan="2"></td>
            </tr>
            <?php $userCrud -> printUsersList() ?>
        </table>
    </div>
</div>
<div class="message-container">
    <form action="users.php" method="POST" class="col s12 form">
        <div class="delete-message-container">
            <?=$printDeleteConfirm?>
            <span class="message">
                <?=$printMessageDeletedOk?>
            </span>
        </div>
    </form>
</div>
</body>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</html>
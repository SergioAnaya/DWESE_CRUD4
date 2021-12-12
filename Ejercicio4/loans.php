<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/class//DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Config/config.php';
global $config;
require_once $config['paths']['services']['crud']['user'];
require_once $config['paths']['services']['crud']['loan'];
require_once $config['paths']['services']['views'];

session_start();

$userCrud = new userCrud();
$loanCrud = new loanCrud();
$views = new Views();

$printNav = $views -> printNavAdminUserView();
$printDeleteConfirm = '';
$loanDeleted = false;
$printMessageDeletedOk = '';

if (empty($_SESSION['username']) OR empty($_SESSION['userType'])) {
    header('Location: login.php');
} elseif ($_SESSION['userType'] === 'Administrator') {
    $printNav = $views -> printNavAdminUserView();
} else {
    $printNav = $views -> printNavStandardUserView();
}

if (isset($_GET['action']) AND $_GET['action'] === 'delete') {
    $loanCrud -> deleteLoan($_GET['userId'], $_GET['bookId']);
    $loanDeleted = true;
}

if ($loanDeleted) {
    $printMessageDeletedOk = 'The loan has been successfully deleted.';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Loans</title>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="Assets/style.css" type="text/css">
</head>
<body>
<?=$printNav?>
<div class="container-loans">
    <div class="container-table">
        <table border="1">

            <?php if ($_SESSION['userType'] === 'Administrator') {
                echo '
                    <tr>
                        <td class="header">Username</td>
                        <td class="header">Title</td>
                        <td class="header">Date</td>
                        <td></td>
                    </tr>';
                $loanCrud -> printLoansList();
            } else {
                echo '
                    <tr>
                        <td class="header">Title</td>
                        <td class="header">Date</td>
                        <td></td>
                    </tr>';
                $loanCrud -> printUsersLoansList($userCrud -> idByUsername($_SESSION['username']));
            }?>
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
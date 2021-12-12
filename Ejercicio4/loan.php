<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/class//DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Config/config.php';
global $config;
require_once $config['paths']['models']['user'];
require_once $config['paths']['services']['crud']['user'];
require_once $config['paths']['services']['crud']['loan'];
require_once $config['paths']['services']['crud']['book'];
require_once $config['paths']['services']['validations'];
require_once $config['paths']['services']['views'];

session_start();

$userCrud = new userCrud();
$loanCrud = new loanCrud();
$bookCrud = new bookCrud();
$validations = new Validations();
$views = new Views();

$username = $_POST['username'];
$bookId = '';
$bookTitle = '';

$printErrors = [];
$printNav = $views -> printNavAdminUserView();
$bookAdded = false;
$printMessageAddedOk = '';

if (empty($_SESSION['username']) OR empty($_SESSION['userType'])) {
    header('Location: login.php');
}
if ($_SESSION['userType'] !== 'Administrator') {
    header('Location: forbidden.php');
}

if (isset($_GET['bookId']) AND isset($_GET['bookTitle'])) {
    $_SESSION['bookTitle'] = $_GET['bookTitle'];
    $_SESSION['bookId'] = $_GET['bookId'];
    $bookId = $_SESSION['bookId'];
    $bookTitle = $_SESSION['bookTitle'];
}

if (isset($_SESSION['bookTitle']) AND isset($_SESSION['bookId'])) {
    $bookId = $_SESSION['bookId'];
    $bookTitle = $_SESSION['bookTitle'];
} else header('Location: books.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($_POST['loanBtn'])) {
    if ($validations -> isValidLoan($bookId)) {
        $userId = $userCrud -> idByUsername($username);
        $loanCrud -> addLoan($userId, $bookId, date('Y-m-d'));
        $bookAdded = true;
    } else $printErrors = $validations -> getErrors();
}

if ($bookAdded) {
    $printMessageAddedOk = 'The book has successfully loaned.';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Loan</title>

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
        <span class="title">Loan book</span>
        <div class="row">
            <div class="input-field col s6">
                <input id="username" type="text" class="validate" name="username" value="<?=!empty($username)?$username:''?>">
                <label for="username">Username</label>
                <span class="message"><?=$printErrors['username']?></span>
            </div>
            <div class="input-field col s6">
                <input disabled id="disabled" type="text" class="validate" name="book" value="<?=$bookTitle?>">
                <label for="book">Book title</label>
                <span class="message"><?=$printErrors['bookAvailability']?></span>
            </div>
        </div>
        <?=$printAddAdminUser?>
        <div class="row">
            <button class="btn waves-effect waves-custom-purple" type="submit" name="loanBtn">Loan</button>
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
<?php

require_once(realpath(dirname(__FILE__) . '/services/book-crud.service.php'));
require_once(realpath(dirname(__FILE__) . '/views/views.php'));

session_start();

$bookCrud = new bookCrud();
$views = new Views();

$printNav = $views -> printNavAdminUserView();

if (empty($_SESSION['username']) OR empty($_SESSION['userType'])) {
     header('Location: login.php');
}
if ($_SESSION['userType'] !== 'Administrator') {
    header('Location: forbidden.php');
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Books</title>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<?=$printNav?>
<div class="container-books">
    <div class="container-table">
        <table border="1">
            <tr>
                <td class="header">Title</td>
                <td class="header">Author</td>
                <td class="header">Editorial</td>
                <td></td>
            </tr>
            <?php $bookCrud -> printBooksList() ?>
        </table>
    </div>
</div>
</body>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</html>
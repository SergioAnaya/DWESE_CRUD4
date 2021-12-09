<?php

require_once(realpath(dirname(__FILE__) . '/services/database.service.php'));

session_start();

/**
 * Create db structure
 */

//$dbService = new Database();

/**
 * Redirection according to the type of user to the home page.
 */

if (empty($_SESSION['username']) OR empty($_SESSION['userType'])) {
    header('Location: login.php');
} else header('Location: loans.php');

/**
 * Logout nav btn
 */

if (isset($_GET['action']) AND $_GET['action'] === 'exit') {
    session_unset();
    session_destroy();
    header('Location: login.php');
}
<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/class//DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Config/config.php';
global $config;
require_once $config['paths']['services']['database'];

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
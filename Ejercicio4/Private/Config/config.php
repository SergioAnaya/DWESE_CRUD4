<?php

$config = array(
    'paths' => array(
        'db_connection' => $_SERVER['DOCUMENT_ROOT'] . '/class/DesWebEnEntSer/1Trim/EjerciciosCRUD/DBConn.php',
        'models' => array(
            'user' => $_SERVER['DOCUMENT_ROOT'] . '/class/DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Models/user.php',
            'book' => $_SERVER['DOCUMENT_ROOT'] . '/class/DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Models/book.php',
        ),
        'services' => array(
            'database' => $_SERVER['DOCUMENT_ROOT'] . '/class/DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Services/Database/database.php',
            'validations' => $_SERVER['DOCUMENT_ROOT'] . '/class/DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Services/Validations/validations.php',
            'crud' => array(
                'book' => $_SERVER['DOCUMENT_ROOT'] . '/class/DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Services/Crud/book.php',
                'user' => $_SERVER['DOCUMENT_ROOT'] . '/class/DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Services/Crud/user.php',
                'loan' => $_SERVER['DOCUMENT_ROOT'] . '/class/DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Services/Crud/loan.php',
            ),
            'views' => $_SERVER['DOCUMENT_ROOT'] . '/class/DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Services/Views/views.php',
        ),
    )
);
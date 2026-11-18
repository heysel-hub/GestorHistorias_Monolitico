<?php
$hostDB = 'localhost';
$userDB = 'root';
$pwdDB = '';
$nameDB = 'gestor_historias_db';

$conexDB = new mysqli($hostDB, $userDB, $pwdDB, $nameDB);

if ($conexDB->connect_error) {
    print($conexDB->connect_error);
    die();
}
$conexDB->set_charset('utf8mb4');
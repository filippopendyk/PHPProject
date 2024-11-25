<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$dbConnection = parse_ini_file("db_connection.ini");

extract($dbConnection);

$myPdo = new PDO($dsn, $user, $password);

?>

<?php

/**
 * 
 * Инициализация подключения к БД
 * 
 */

/**
 * Подключение к БД
 * 
 * @return object Объект соединения
 */
function db() {
    $dblocation = "127.0.0.1"; //$dbhost = "localhost";
    $dbname = "labservis";
    $dbuser = "root";
    $dbpassword = "";

    $db = new mysqli($dblocation, $dbuser, $dbpassword, $dbname);
    
    $db->set_charset('utf8');

    if ($db->connect_errno) {
      die('MySQL access denied.');
    }
    
    if(!mysqli_select_db($db, $dbname)) {
        die("The database {$dbname} could not be accessed.");
    }
    
    return $db;
}

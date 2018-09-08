<?php

session_start();

require_once '../config/config.php';        //Инициализация настроек
require_once '../config/db.php';            //Инициализация БД
require_once '../library/mainFunctions.php';//Основные функции
require_once '../library/fileFunctions.php';//Функции для работы с файлами

//определяем с каким контроллером и функцией работать
//берутся из url (пример: http://labservis/?controller=index&action=index)
//преобразование из чпу в .htaccess
if(isset($_SESSION['admin'])){    
    if (null !== filter_input(INPUT_GET, 'controller')) {
        $controllerName = ucfirst(filter_input(INPUT_GET, 'controller'));
    } else {
        $controllerName = 'Admin';
    }
} elseif(isset($_SESSION['teacher'])){
    if (null !== filter_input(INPUT_GET, 'controller')) {
        $controllerName = ucfirst(filter_input(INPUT_GET, 'controller'));
    } else {
        $controllerName = 'Teacher';
    }
} elseif(isset($_SESSION['course'])){
    if (null !== filter_input(INPUT_GET, 'controller')) {
        $controllerName = ucfirst(filter_input(INPUT_GET, 'controller'));
    } else {
        $controllerName = 'Student';
    }
} else {
    if (null !== filter_input(INPUT_GET, 'controller')) {
        $controllerName = ucfirst(filter_input(INPUT_GET, 'controller'));
    } else {
        $controllerName = 'Auth';
    }
}

if (null !== filter_input(INPUT_GET, 'action')) {
    $actionName = ucfirst(filter_input(INPUT_GET, 'action'));
} else {
    $actionName = 'index';
}
loadPage($twig, $controllerName, $actionName);


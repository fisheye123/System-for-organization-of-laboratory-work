<?php
session_start();


require_once '../config/config.php';        //Инициализация настроек
require_once '../config/db.php';            //Инициализация БД
require_once '../library/mainFunctions.php';//Основные функции

//определяем с каким контроллером и функцией экшн работать
//берутся из урла браузера (пример: http://shop.local/?controller=index&action=index)
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'Index';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';
 
//Проблема! Не знаю как в массив передать arTeacher
//в twig отсутствует(?) аналог assign(smarty) без передачи темплейта
if(isset($_SESSION['teacher'])){
    /*$tpppl = myLoadTemplate($twig, '');
    
    echo $tpppl->render(array(
        'arTeacher' => $_SESSION['teacher']
    ));*/
    /*
    $this->render('my_template.html.twig', array(
        'arTeacher' => $_SESSION['teacher']
    ));*/
    
    //$twig->render("add_lab.tpl", array('arTeacher' => $_SESSION['teacher']));
    //$this->render(array('arTeacher' => $_SESSION['teacher']));
} 

loadPage($twig, $controllerName, $actionName);

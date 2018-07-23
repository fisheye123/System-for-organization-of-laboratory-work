<?php

/**
 * 
 * Контроллер главной страницы
 * 
 */

include_once '../models/CoursesModel.php';
include_once '../models/LabsModel.php';

/**
 * Формирование главной страницы сайта
 * 
 * @param object $twig - шаблонизатор
 */
function indexAction ($twig) {
    
    $rsCourses = getAllCourses();  
    
    $title = "TomskSoft";
        
    $tpppl = myLoadTemplate($twig, 'add_lab');
    
    //Исправить. Проверку на существование сессии вынести в index.php
    if(isset($_SESSION['teacher'])){
        echo $tpppl->render(array(
            'title' => $title,
            'rsCourses' => $rsCourses,
            
            'arTeacher' => $_SESSION['teacher']
        ));
    } else {
        echo $tpppl->render(array(
            'title' => $title,
            'rsCourses' => $rsCourses
        ));
    }
    
}


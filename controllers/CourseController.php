<?php

/**
 * 
 * Контроллер страницы курсов
 * 
 */

include_once '../models/CoursesModel.php';
include_once '../models/LabsModel.php';

/**
 * Формирование страницы курса 
 * 
 * @param object $twig - шаблонизатор
 */
function indexAction ($twig) {
    $crumbs = breadcrumbs();
    
    $courseId = isset($_GET['id']) ? $_GET['id'] : null;
    if (!$courseId) {
        exit();
    }
    
    $rsCourse = getCourseById($courseId);
    $rsLabs = getLabForCourse($courseId);
    
    $rsCourses = getAllCourses();
    
    $title = "Курс {$rsCourse['title']}";
    
    $tpppl = myLoadTemplate($twig, 'course');
    
    //Исправить. Проверку на существование сессии вынести в index.php
    if(isset($_SESSION['teacher'])){
        echo $tpppl->render(array(
            'title' => $title,
            'crumbs' => $crumbs,
            'rsCourse' => $rsCourse,
            'rsLabs' => $rsLabs,

            'rsCourses' => $rsCourses,

            'arTeacher' => $_SESSION['teacher']
        ));
    } else {
        echo $tpppl->render(array(
            'title' => $title,
            'crumbs' => $crumbs,
            'rsCourse' => $rsCourse,
            'rsLabs' => $rsLabs,

            'rsCourses' => $rsCourses
        ));
    }
    
}


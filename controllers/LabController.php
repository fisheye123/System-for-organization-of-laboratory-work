<?php

/**
 * 
 * Контроллер страницы лабораторной для студента (пример: /lab/1)
 * 
 */

include_once '../models/CoursesModel.php';
include_once '../models/LabsModel.php';

/**
 * Формирование страницы лабораторной 
 * 
 * @param object $twig - шаблонизатор
 */
function indexAction ($twig) {
    $crumbs = breadcrumbs();
    
    $labId = isset($_GET['id']) ? $_GET['id'] : null;
    if (!$labId) {
        exit();
    }
    
    $rsLab = getLabById($labId);
    
    $rsCourses = getAllCourses();
    
    $title = "Лабораторная №{$rsLab['id']} - {$rsLab['title']}";
    
    $tpppl = myLoadTemplate($twig, 'lab');
    
    //Исправить. Проверку на существование сессии вынести в index.php
    if(isset($_SESSION['teacher'])){
        echo $tpppl->render(array(
            'title' => $title,
            'crumbs' => $crumbs,
            'rsLab' => $rsLab,

            'rsCourses' => $rsCourses,
            
            'arTeacher' => $_SESSION['teacher']
        ));
    } else {
        echo $tpppl->render(array(
            'title' => $title,
            'crumbs' => $crumbs,
            'rsLab' => $rsLab,

            'rsCourses' => $rsCourses
        ));
    }
    
}

function addAction() {
    $title = isset($_REQUEST['lab_title']) ? $_REQUEST['lab_title'] : null;    
    $task = isset($_REQUEST['lab_task']) ? $_REQUEST['lab_task'] : null;
    $courseId = isset($_REQUEST['lab_course']) ? $_REQUEST['lab_course'] : null;
    
    $resData = null; //хранит промежуточные данные об ошибках
    $resData = checkAddLabParam($title, $courseId);
    
    if(!$resData && checkLabTitle($title, $courseId)) {
        $resData['success'] = FALSE;
        $resData['message'] = "Лабораторная с таким названием ('{$title}') уже существует";
    }
    
    if (!$resData) {
        $labData = addNewLab($title, $task, $courseId);
        if($labData['success']) {
            $resData['message'] = 'Лабораторная добавлена';
            $resData['success'] = 1;
            
            $resData['labTitle'] = $title;
            $resData['labTask'] = $task;
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления лабораторной';
        }
    }
    
    echo json_encode($resData);
}
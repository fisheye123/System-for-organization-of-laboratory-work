<?php

/**
 * 
 * Контроллер страниц админки
 * 
 */

include_once '../models/CoursesModel.php';
include_once '../models/LabsModel.php';
include_once '../models/TeachersModel.php';
include_once '../models/StudentsModel.php';

/**
 * Загрузка главной страницы админки
 * 
 * @param object $twig - шаблонизатор
 */
function indexAction($twig) {
    $rsCourses = getCourseWithLab();
    
    if(isset($_SESSION['admin'])){
        $tpppl = myLoadTemplate($twig, 'admin');
        echo $tpppl->render(array(
            'title' => 'Управление сайтом',
            'rsCourses' => $rsCourses,
            'arAdmin' => $_SESSION['admin']
        ));
    } else {
        redirect();
    }
}

/**
 * Загрузка страницы управления курсами
 * 
 * @param object $twig - шаблонизатор
 */
function courseAction($twig) {
    $rsCourses = getAllCourse();
    
    if(isset($_SESSION['admin'])){
        $tpppl = myLoadTemplate($twig, 'adminCourse');
        echo $tpppl->render(array(
            'title' => 'Управление сайтом',
            'rsCourse' => $rsCourses,
            'arAdmin' => $_SESSION['admin']
        ));
    } else {
        redirect();
    }
}

/**
 * Загрузка страницы управления лабораторными
 * 
 * @param object $twig - шаблонизатор
 */
function labAction($twig) {
    $rsLab = getAllLab();
    $rsCourses = getCourseWithLab();
    
    if(isset($_SESSION['admin'])){
        $tpppl = myLoadTemplate($twig, 'adminLab');
        echo $tpppl->render(array(
            'title' => 'Управление сайтом',
            'rsLab' => $rsLab,
            'rsCourses' => $rsCourses,
            'arAdmin' => $_SESSION['admin']
        ));
    } else {
        redirect();
    }
}

/**
 * Загрузка страницы управления преподавателями
 * 
 * @param object $twig - шаблонизатор
 */
function teacherAction($twig) {
    $rsTeacher = getAllTeacher();
    $rsCourses = getCourseWithLab();
    
    for($i = 0; $i < count($rsTeacher); ++$i) {
        
        $rsTeacher[$i] += [
            "courses" => getTeachersCourses($rsTeacher[$i]['id']),
        ];
    }
    
    if(isset($_SESSION['admin'])){
        $tpppl = myLoadTemplate($twig, 'adminTeacher');
        echo $tpppl->render(array(
            'title' => 'Управление сайтом',
            'rsTeacher' => $rsTeacher,
            'rsCourses' => $rsCourses,
            'arAdmin' => $_SESSION['admin']
        ));
    } else {
        redirect();
    }
}

/**
 * Загрузка страницы изменения курсов преподавателя
 * 
 * @param object $twig - шаблонизатор
 */
function coursesAction ($twig) {
    $teacherId = filter_input(INPUT_GET, 'teacherid');
    $rsTeacher = getTeacherById($teacherId);
    $rsCourses = getCourseWithLab();
    
    if(isset($_SESSION['admin'])){
        $tpppl = myLoadTemplate($twig, 'adminTeacherCourse');
        echo $tpppl->render(array(
            'title' => 'Управление сайтом',
            'rsTeacher' => $rsTeacher,
            'rsCourses' => $rsCourses,
            'arAdmin' => $_SESSION['admin']
        ));
    } else {
        redirect();
    }
}

/**
 * Загрузка страницы управления студентами
 * 
 * @param object $twig - шаблонизатор
 */
function studentAction($twig) {
    $rsStudent = getAllStudent();
    
    if(isset($_SESSION['admin'])){
        $tpppl = myLoadTemplate($twig, 'adminStudent');
        echo $tpppl->render(array(
            'title' => 'Управление сайтом',
            'rsStudent' => $rsStudent,
            'arAdmin' => $_SESSION['admin']
        ));
    } else {
        redirect();
    }
}
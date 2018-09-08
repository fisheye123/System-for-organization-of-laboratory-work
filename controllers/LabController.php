<?php

/**
 * 
 * Контроллер страницы лабораторной и функций работы с ними
 * 
 */

include_once '../models/CoursesModel.php';
include_once '../models/StudentsModel.php';
include_once '../models/LabsModel.php';

/**
 * Загрузка страницы лабораторной для студента и для преподавателя
 * 
 * @param object $twig - шаблонизатор
 */
function indexAction ($twig) {
    $labId = filter_input(INPUT_GET, 'id');
    
    if (!$labId) {
        exit();
    }
    
    $rsLab = getLabById($labId);
    $title = "Лабораторная №{$rsLab['number']} - {$rsLab['title']}";
    $rsStudents = getStudentsByCourse($rsLab['course_id']);
    
    if(isset($_SESSION['teacher'])){
        $crumbs = breadcrumbs();
        $rsCourses = getCourseWithLab();
        
        $tpppl = myLoadTemplate($twig, 'lab');
        echo $tpppl->render(array(
            'title' => $title,
            'crumbs' => $crumbs,
            'rsLab' => $rsLab,
            'rsCourses' => $rsCourses,
            'rsStudents' => $rsStudents,
            'arTeacher' => $_SESSION['teacher']
        ));
    } elseif (isset($_SESSION['course'])) {
        $rsLabs = getLabForCourse($_SESSION['course']['id']);
        
        $tpppl = myLoadTemplate($twig, 'CourseLab');
        echo $tpppl->render(array(
            'title' => $title,
            'rsLab' => $rsLab,
            'rsLabs' => $rsLabs,
            'arCourse' => $_SESSION['course']
        ));
    } else {
        redirect();
    }
}

/**
 * Загрузка главной страницы преподавателя
 * 
 * @param object $twig - шаблонизатор
 */
function labaddAction ($twig) {
    $rsCourses = getCourseWithLab();
    
    if(isset($_SESSION['teacher'])){
        $tpppl = myLoadTemplate($twig, 'add_lab');
        echo $tpppl->render(array(
            'title' => 'TomskSoft',
            'rsCourses' => $rsCourses,
            'arTeacher' => $_SESSION['teacher']
        ));
    } else {
        redirect();
    }
}

/**
 * Добавление лабораторной
 * 
 * @return json массив, содержащий информацию о добавлении лабораторной
 */
function addlabAction() {    
    $title = filter_input(INPUT_POST, 'lab_title');    
    $task = filter_input(INPUT_POST, 'lab_task');
    $courseId = filter_input(INPUT_POST, 'lab_course');
    
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
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления лабораторной';
        }
    }
    
    echo json_encode($resData);
}

/**
 * Обновление данных лабораторной
 * 
 * @return json массив, содержащий информацию об обновлении данных лабораторной
 */
function updatelabAction() {
    $labId = filter_input(INPUT_POST, 'labId');
    $Number = filter_input(INPUT_POST, 'newNumber');
    $Title = filter_input(INPUT_POST, 'newTitle');
    $Task = filter_input(INPUT_POST, 'newTask');
    $Access = filter_input(INPUT_POST, 'newAccess');
    $CourseId = filter_input(INPUT_POST, 'newCourse_id');
    
    $res = updateLabData($labId, $Number, $Title, $Task, $Access, $CourseId);
    if($res) {
        $resData['success'] = 1;
        $resData['message'] = 'Данные лабораторной обновлены';
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка изменения данных лабораторной';
    }
    
    echo json_encode($resData);
}

/**
 * Удаление лабораторной
 * 
 * @return json массив, содержащий информацию об удалении лабораторной
 */
function deletelabAction() {
    $id = filter_input(INPUT_POST, 'id');
    
    $res = deleteLab($id);
    if($res) {
        $resData['success'] = 1;
        $resData['message'] = 'Лабораторная удалена';
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка удаления лабораторной';
    }
    
    echo json_encode($resData);
}

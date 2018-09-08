<?php

/**
 * 
 * Контроллер страницы курсов и функций работы с ними
 * 
 */

include_once '../models/CoursesModel.php';
include_once '../models/LabsModel.php';

/**
 * Загрузка главной страницы курса
 * 
 * @param object $twig - шаблонизатор
 */
function indexAction ($twig) {
    $courseId = filter_input(INPUT_GET, 'id');
    
    if (!$courseId) {
        exit();
    }
    
    $crumbs = breadcrumbs();
    $rsCourses = getCourseWithLab();
    $rsCourse = getCourseById($courseId);
    $title = "Курс {$rsCourse['title']}";
    $rsLabs = getLabForCourse($courseId);
    
    if(isset($_SESSION['teacher'])){
        $tpppl = myLoadTemplate($twig, 'course');
        echo $tpppl->render(array(
            'title' => $title,
            'crumbs' => $crumbs,
            'rsCourse' => $rsCourse,
            'rsLabs' => $rsLabs,
            'rsCourses' => $rsCourses,
            'arTeacher' => $_SESSION['teacher']
        ));
    } else {
        redirect();
    }
}

/**
 * Загрузка страницы добавления курса
 * 
 * @param object $twig - шаблонизатор
 */
function courseaddAction ($twig) {    
    $crumbs = breadcrumbs();
    $rsCourses = getCourseWithLab();
    
    if(isset($_SESSION['teacher'])){
        $tpppl = myLoadTemplate($twig, 'addCourse');
        echo $tpppl->render(array(
            'title' => "Добавление курса",
            'crumbs' => $crumbs,
            'rsCourses' => $rsCourses,
            'arTeacher' => $_SESSION['teacher']
        ));
    } else {
        redirect();
    }
}

/**
 * Добавление курса
 * 
 * @return json массив, содержащий информацию о добавлении курса
 */
function addcourseAction() {
    $title = filter_input(INPUT_POST, 'course_title');
    $description = filter_input(INPUT_POST, 'course_descripton');
    $login = trim(filter_input(INPUT_POST, 'course_login'));
    $password = filter_input(INPUT_POST, 'course_password');
    
    $resData = checkAddCourseParam($title, $login, $password);
    if(!$resData && checkCourseLogin($login)) {
        $resData['success'] = FALSE;
        $resData['message'] = "Курс с таким логином ('{$login}') уже зарегистрирован";
    }
    
    if(!$resData && checkCourseTitle($title)) {
        $resData['success'] = FALSE;
        $resData['message'] = "Курс с таким названием ('{$title}') уже существует";
    }
    
    if (!$resData) {
        $passwordMD5 = md5(trim($password));
        
        $labData = addNewCourse($title, $description, $login, $passwordMD5);
        if($labData['success']) {
            $resData['message'] = 'Курс добавлен';
            $resData['success'] = 1;
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления курса';
        }
    }
    
    echo json_encode($resData);
}

/**
 * Обновление данных курса
 * 
 * @return json массив, содержащий информацию об обновлении данных курса
 */
function updatecourseAction() {
    $id = filter_input(INPUT_POST, 'id');
    $newTitle = filter_input(INPUT_POST, 'newTitle');
    $newDesc = filter_input(INPUT_POST, 'newDescription');
    $newLogin = filter_input(INPUT_POST, 'newLogin');
    $newPassword = filter_input(INPUT_POST, 'newPassword');
    
    $passwordMD5 = md5(trim("$newPassword"));
    $resData = checkAddCourseParam($newTitle, $newLogin, $newPassword);
    if (!$resData) {
        //Нет проверки на совпадение названий и логинов 
        $res = updateCourseData($id, $newTitle, $newDesc, $newLogin, $passwordMD5);
        if($res) {
            $resData['success'] = 1;
            $resData['message'] = "Данные курса '{$newTitle}' обновлены";
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных курса';
        }
    }
    
    echo json_encode($resData);
}

/**
 * Удаление курса
 * 
 * @return json массив, содержащий информацию об удалении курса
 */
function deletecourseAction() {
    $id = filter_input(INPUT_POST, 'id');
    
    $res = deleteCourse($id);
    if($res) {
        $resData['success'] = 1;
        $resData['message'] = 'Курс удален';
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка удаления курса';
    }
    
    echo json_encode($resData);
}


<?php

/**
 * 
 * Контроллер страницы преподавателя и функции работы с ним
 * 
 */

include_once '../models/CoursesModel.php';
include_once '../models/LabsModel.php';
include_once '../models/TeachersModel.php';

/**
 * Загрузка главной страницы преподавателя
 * 
 * @param object $twig - шаблонизатор
 */
function indexAction ($twig) {
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
 * Загрузка страницы преподавателя
 * 
 * @param object $twig шаблонизатор
 */
function aboutAction($twig) {
    $crumbs = breadcrumbs();
    $rsCourses = getCourseWithLab();
    $title = "Страница пользователя {$_SESSION['teacher']['login']}";
    
    if(isset($_SESSION['teacher'])){
        $tpppl = myLoadTemplate($twig, 'teacher');
        echo $tpppl->render(array(
            'title' => $title,
            'crumbs' => $crumbs,
            'rsCourses' => $rsCourses,
            'arTeacher' => $_SESSION['teacher']
        ));
    } else {
        redirect();
    }
}

/**
 * Регистрация преподавателя
 * 
 * @return json массив данных зарегистрированного преподавателя
 */
function registerAction() {
    $login = trim(filter_input(INPUT_POST, 'login'));
    $name = filter_input(INPUT_POST, 'name');
    $password = filter_input(INPUT_POST, 'password');
    $email = filter_input(INPUT_POST, 'email');
    
    $resData = checkRegisterParam($name, $login, $password);
    if(!isset($resData['success']) && checkTeacherLogin($login)) {
        $resData['success'] = FALSE;
        $resData['message'] = "Пользователь с таким логином ('{$login}') уже зарегистрирован";
    }
    
    if (!isset($resData['success'])) {
        $passwordMD5 = md5(trim($password));
        
        $teacherData = registerNewTeacher($name, $email, $login, $passwordMD5);
        if(isset($teacherData['success'])) {
            $resData['message'] = 'Пользователь зарегистрирован';
            $resData['success'] = TRUE;
            
            $teacherData = $teacherData[0];
            $resData['teacherName'] = $teacherData['name'];
            $resData['teacherEmail'] = $email;
            
            $_SESSION['teacher'] = $teacherData;
            $_SESSION['teacher']['displayName'] = $resData['teacherName'];
        } else {
            $resData['success'] = FALSE;
            $resData['message'] = 'Ошибка регистрации';
        }
    }
    
    echo json_encode($resData);
}

/**
 * Обновление данных преподавателя из админки (из admin.js)
 * 
 * @return json массив, содержащий информацию об обновлении данных преподавателя
 */
function updateteacherAction() {
    $teacherId = filter_input(INPUT_POST, 'teacherId');
    $Name = filter_input(INPUT_POST, 'newName');
    $Email = filter_input(INPUT_POST, 'newEmail');
    $Login = filter_input(INPUT_POST, 'newLogin');
    $Password = filter_input(INPUT_POST, 'newPassword');
    
    $resData = checkRegisterParam($Name, $Login, $Password);
    if (!isset($resData['success'])) {
        //Нет проверки на совпадение логинов
        $res = updateTeacherData($teacherId, $Name, $Email, $Login, $Password);
        if($res) {
            $resData['success'] = 1;
            $resData['message'] = 'Данные преподавателя обновлены';
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных преподавателя';
        }
    }
    
    echo json_encode($resData);
    
    
    
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
 * Обновление данных преподавателя из страницы преподавателя (из teacher.js)
 * 
 * @return json массив, содержащий информацию об обновлении данных преподавателя
 */
function updateAction() {
    $resData = array();
    
    $name = filter_input(INPUT_POST, 'name');
    $email = filter_input(INPUT_POST, 'email');
    $pass1 = filter_input(INPUT_POST, 'password1');
    $pass2 = filter_input(INPUT_POST, 'password2');
    $curPass = filter_input(INPUT_POST, 'curPassword');
    
    if($pass1 !== $pass2) {
        $resData['message'] = 'Введенные пароли не совпадают';
        echo json_encode($resData);
        return FALSE;
    }
    
    $curPasswordMD5 = md5($curPass);
    if( !$curPass || ($_SESSION['teacher']['password'] != $curPasswordMD5) ) {
        $resData['success'] = 0;
        $resData['message'] = 'Текущий пароль введен неверно';
        echo json_encode($resData);
        return FALSE;
    }
    
    $resData = checkTeacherName($name);
    if (!isset($resData['success'])) {
        //Нет проверки на совпадение логинов
        $res = updateTeacherDatalk($name, $email, $pass1, $pass2, $curPasswordMD5);
        if($res) {
            $resData['success'] = 1;
            $resData['message'] = 'Изменения сохранены';
            $resData['teacherName'] = $name;

            $_SESSION['teacher']['name'] = $name;
            $_SESSION['teacher']['email'] = $email;

            $newPassword = $_SESSION['teacher']['password'];
            if( $pass1 && ($pass1 == $pass2) ) {
                $newPassword = md5(trim($pass1));
            }

            $_SESSION['teacher']['password'] = $newPassword;
            $_SESSION['teacher']['displayName'] = $name ? $name : $_SESSION['teacher']['login'];
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка сохранения данных';
        }
    }
    
    echo json_encode($resData);
}

/**
 * Изменение курсов преподавателя
 * 
 * @return json массив данных курсов преподавателя
 */
function updatecourseAction() {
    $login = trim(filter_input(INPUT_POST, 'login'));
    $name = filter_input(INPUT_POST, 'name');
    $password = filter_input(INPUT_POST, 'password');
    $email = filter_input(INPUT_POST, 'email');
    
    $resData = checkRegisterParam($name, $login, $password);
    if(!isset($resData['success']) && checkTeacherLogin($login)) {
        $resData['success'] = FALSE;
        $resData['message'] = "Пользователь с таким логином ('{$login}') уже зарегистрирован";
    }
    
    if (!isset($resData['success'])) {
        $passwordMD5 = md5(trim($password));
        
        $teacherData = registerNewTeacher($name, $email, $login, $passwordMD5);
        if(isset($teacherData['success'])) {
            $resData['message'] = 'Пользователь зарегистрирован';
            $resData['success'] = TRUE;
            
            $teacherData = $teacherData[0];
            $resData['teacherName'] = $teacherData['name'];
            $resData['teacherEmail'] = $email;
            
            $_SESSION['teacher'] = $teacherData;
            $_SESSION['teacher']['displayName'] = $resData['teacherName'];
        } else {
            $resData['success'] = FALSE;
            $resData['message'] = 'Ошибка регистрации';
        }
    }
    
    echo json_encode($resData);
}

/**
 * Удаление преподавателя
 * 
 * @return json массив, содержащий информацию об удалении преподавателя
 */
function deleteteacherAction() {
    $teacherId = filter_input(INPUT_POST, 'teacherId');
    
    $res = deleteTeacher($teacherId);
    if($res) {
        $resData['success'] = 1;
        $resData['message'] = 'Преподаватель удален';
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка удаления преподавателя';
    }
    
    echo json_encode($resData);
}
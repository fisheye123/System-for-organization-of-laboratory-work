<?php

/**
 * 
 * Контроллер функций пользователя
 * 
 */

include_once '../models/CoursesModel.php';
include_once '../models/LabsModel.php';
include_once '../models/TeachersModel.php';

/**
 * AJAX регистрация преподавателя.
 * Инициализация сессионной переменной ($SESSION['teacher'])
 * 
 * @return json массив данных нового преподавателя
 */
function registerAction() {
    $login = isset($_REQUEST['login']) ? $_REQUEST['login'] : null;
    $login = trim($login);
    
    $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
    $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
    
    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
    
    
    $resData = null; //хранит промежуточные данные об ошибках
    $resData = checkRegisterParam($login, $password);
    
    if(!$resData && checkTeacherLogin($login)) {
        $resData['success'] = FALSE;
        $resData['message'] = "Пользователь с таким логином ('{$login}') уже зарегистрирован";
    }
    
    if (!$resData) {
        $passwordMD5 = md5(trim($password));
        
        $teacherData = registerNewTeacher($name, $email, $login, $passwordMD5);
        if($teacherData['success']) {
            $resData['message'] = 'Пользователь зарегистрирован';
            $resData['success'] = 1;
            
            $teacherData = $teacherData[0];
            $resData['teacherName'] = $teacherData['name'] ? $teacherData['name'] : $teacherData['login'];
            $resData['teacherEmail'] = $email;
            
            $_SESSION['teacher'] = $teacherData;
            $_SESSION['teacher']['displayName'] = $resData['teacherName'];
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка регистрации';
        }
        
    }
    
    echo json_encode($resData);
}

/**
 * Разлогин пользователя
 * 
 */
function logoutAction(){
    if(isset($_SESSION['teacher'])){
        unset($_SESSION['teacher']);
    }
    
    redirect();
}

/**
 * AJAX авторизация пользователя
 * 
 * @return json массив данных пользователя
 */
function loginAction() {
    $login = isset($_REQUEST['login']) ? $_REQUEST['login'] : null;
    $login = trim($login);
    
    $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
    $password = md5(trim($password));
    
    $userData = loginUser($login, $password);
    
    if($userData['success']) {
        $userData = $userData[0];
        
        $_SESSION['teacher'] = $userData;
        $_SESSION['teacher']['displayName'] = $userData['name'] ? $userData['name'] : $userData['login'];
        
        $resData = $_SESSION['teacher'];
        $resData['success'] = 1;
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Неверный логин или пароль';
    }
    
    echo json_encode($resData);
}

/**
 * Формирование страницы преподавателя
 * 
 * @link /teacher/
 * @param object $twig шаблонизатор
 */
function indexAction($twig) {    
    $crumbs = breadcrumbs();
    
    //получение списка курсов и лабораторных в них
    $rsCourses = getAllCourses();
    
    $title = "Страница пользователя {$_SESSION['teacher']['login']}";
    
    $tpppl = myLoadTemplate($twig, 'teacher');
    
    //Исправить. Проверку на существование сессии вынести в index.php
    if(isset($_SESSION['teacher'])){
        echo $tpppl->render(array(
            'title' => $title,
            'crumbs' => $crumbs,
            'rsCourses' => $rsCourses,

            'arTeacher' => $_SESSION['teacher']
        ));
    } else { //если пользователь не залогинен, то перенаправляем на главную страницу
        redirect();
    }
}

/**
 * Обновление данных преподавателя
 * 
 * @return json обновленные данные
 */
function updateAction() {
    //Если пользователь не авторизован, то переход на главную страницу
    if( !isset($_SESSION['teacher']) ) {
        redirect();
    }
    
    $resData = array();
    //Можно заменить $_REQUEST на $_POST в целях безопастности
    $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : NULL;
    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : NULL;
    $password1 = isset($_REQUEST['password1']) ? $_REQUEST['password1'] : NULL;
    $password2 = isset($_REQUEST['password2']) ? $_REQUEST['password2'] : NULL;
    $curPassword = isset($_REQUEST['curPassword']) ? $_REQUEST['curPassword'] : NULL;
    
    if($password1 !== $password2) {
        $resData['message'] = 'Введенные пароли не совпадают';
        echo json_encode($resData);
        return false;
    }
    
    //Проверка правильности введенного текущего пароля
    $curPasswordMD5 = md5($curPassword);
    if( !$curPassword || ($_SESSION['teacher']['password'] != $curPasswordMD5) ) {
        $resData['success'] = 0;
        $resData['message'] = 'Текущий пароль введен неверно';
        echo json_encode($resData);
        return FALSE;
    }
    
    //Обновление данных преподавателя
    $res = updateTeacherData($name, $email, $password1, $password2, $curPasswordMD5);
    
    if($res) {
        $resData['success'] = 1;
        $resData['message'] = 'Изменения сохранены';
        $resData['teacherName'] = $name;
        
        $_SESSION['teacher']['name'] = $name;
        $_SESSION['teacher']['email'] = $email;
        
        $newPassword = $_SESSION['teacher']['password'];
        if( $password1 && ($password1 == $password2) ) {
            $newPassword = md5(trim($password1));
        }
        
        $_SESSION['teacher']['password'] = $newPassword;
        $_SESSION['teacher']['displayName'] = $name ? $name : $_SESSION['teacher']['login'];
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка сохранения данных';
    }
    
    echo json_encode($resData);
}



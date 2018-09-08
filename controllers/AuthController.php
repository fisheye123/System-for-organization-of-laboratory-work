<?php

/**
 * 
 * Контроллер страницы авторизации, авторизация и деавторизация
 * 
 */

include_once '../models/AuthModel.php';

/**
 * Загрузка страницы авторизации
 * 
 * @param object $twig - шаблонизатор
 */
function indexAction ($twig) {
    $tpppl = myLoadTemplate($twig, 'auth');
    echo $tpppl->render(array(
        'title' => "Вход на сайт"
    ));
}

/**
 * Авторизация пользователя
 * 
 * @return json массив данных пользователя
 */
function loginAction() {
    $login = trim(filter_input(INPUT_POST, 'login'));
    $password = md5(trim(filter_input(INPUT_POST, 'password')));
    
    $userTeacher = loginTeacher($login, $password);
    $userAdmin = loginAdmin($login, $password);
    $userCourse = loginCourse($login, $password);
    
    if($userAdmin['success']) {
        $_SESSION['admin']['displayName'] = 'Администратор';
        
        $resData = $_SESSION['admin'];
        $resData['success'] = 1;
    } elseif($userTeacher['success']) {
        $userTeacher = $userTeacher[0];
        $_SESSION['teacher'] = $userTeacher;
        $_SESSION['teacher']['displayName'] = $userTeacher['name'];
        
        $resData = $_SESSION['teacher'];
        $resData['success'] = 1;
    } elseif($userCourse['success']) {
        $userCourse = $userCourse[0];
        $_SESSION['course'] = $userCourse;
        $_SESSION['course']['displayName'] = $userCourse['title'];
        
        $resData = $_SESSION['course'];
        $resData['success'] = 1;
    } else {
        $resData['message'] = 'Неверный логин или пароль';
        $resData['success'] = 0;
    }
    
    echo json_encode($resData);
}

/**
 * Выход из авторизации
 * 
 */
function logoutAction(){
    unset($_SESSION['admin']);
    unset($_SESSION['teacher']);
    unset($_SESSION['course']);
    
    redirect();
}


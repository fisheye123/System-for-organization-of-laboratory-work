<?php

/**
 * 
 * Контроллер функций студента
 * 
 */

include_once '../models/CoursesModel.php';
include_once '../models/LabsModel.php';
include_once '../models/StudentsModel.php';

/**
 * Загрузка главной страницы курса
 * 
 * @param object $twig - шаблонизатор
 */
function indexAction ($twig) {
    $rsLabs = getLabForCourse($_SESSION['course']['id']);
    
    if (isset($_SESSION['course'])) {
        $tpppl = myLoadTemplate($twig, 'courseMain');
        echo $tpppl->render(array(
            'title' => $_SESSION['course']['title'],
            'rsLabs' => $rsLabs,
            'arCourse' => $_SESSION['course']
        ));
    } else {
        redirect();
    }
}

/**
 * Добавление студента
 * 
 * @return json массив, содержащий информацию о добавлении студента
 */
function addstudentAction() {
    $name = filter_input(INPUT_POST, 'student_name');
    $group = filter_input(INPUT_POST, 'student_group');
    
    $resData = checkAddStudentParam($name);
    if(!$resData && checkStudentName($name)) {
        $resData['success'] = FALSE;
        $resData['message'] = "Студент с таким именем ('{$name}') уже зарегистрирован";
    }
    
    if (!$resData) {
        
        $labData = addNewStudent($name, $group);
        if($labData['success']) {
            $resData['message'] = 'Студент добавлен';
            $resData['success'] = 1;
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления студента';
        }
    }
    
    echo json_encode($resData);
}

/**
 * Обновление данных студента
 * 
 * @return json массив, содержащий информацию об обновлении данных студента
 */
function updatestudentAction() {
    $id = filter_input(INPUT_POST, 'id');
    $newName = filter_input(INPUT_POST, 'newName');
    $newGroup = filter_input(INPUT_POST, 'newGroup');
    
    $resData = checkAddStudentParam($newName);
    if(!$resData && checkStudentName($newName)) {
        $resData['success'] = FALSE;
        $resData['message'] = "Студент с таким именем ('{$newName}') уже зарегистрирован";
    }
    if (!$resData) {
        $res = updateStudentData($id, $newName, $newGroup);
        if($res) {
            $resData['success'] = 1;
            $resData['message'] = "Данные студента '{$newName}' обновлены";
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных студента';
        }
    }
    
    echo json_encode($resData);
}

/**
 * Удаление студента
 * 
 * @return json массив, содержащий информацию об удалении студента
 */
function deletestudentAction() {
    $id = filter_input(INPUT_POST, 'id');
    
    $res = deleteStudent($id);
    if($res) {
        $resData['success'] = 1;
        $resData['message'] = 'Студент удален';
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка удаления студента';
    }
    
    echo json_encode($resData);
}


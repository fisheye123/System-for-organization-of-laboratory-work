<?php

/**
 * 
 * Контроллер для работы с файлами (pdf, jpg, gif, png)
 * 
 */

include_once '../models/FileModel.php';

/**
 * Получение файла
 * 
 * @return string строка, содержащая статус добавления файла
 */
function uploadAction(){   
    $resData = "";
    $myFile = $_FILES['file'];
    $labId = filter_input(INPUT_GET, 'labId');
    $answer = filter_input(INPUT_GET, 'answer');
    
    $uploaddir = './templates/course/attachments/';
    $uploadfile = $uploaddir . basename($myFile['name']);
    
    $error = checkError($myFile);
    $resData = $resData . $error['message'];
    
    $type = checkType($myFile);
    $resData = $resData . $type['message'];
    
    if($error['success'] && $type['success']) {
        if (move_uploaded_file($myFile['tmp_name'], $uploadfile)) {
            $labExec = createLabExec($labId);
            updateLabHistory($labExec, $answer, $uploadfile);
            
            $resData = $resData . "Файл корректен и был успешно загружен. ";
        }
    }
    
    echo $resData;
}

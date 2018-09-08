<?php

/**
 * 
 * Функции для работы с файлами
 * 
 */


/**
 * Проверка на ошибки загрузки файла
 * 
 * @param array $file полученный файл
 * @return array массив
 */
function checkError ($file) {
    $resData['message'] = "";
    $resData['success'] = TRUE;
    $err = array();
    
    $errUpload = array( 
        0 => 'Ошибок не возникло, файл был успешно загружен на сервер. ', 
        1 => 'Размер принятого файла превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini. ', 
        2 => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме. ', 
        3 => 'Загружаемый файл был получен только частично. ', 
        4 => 'Файл не был загружен. ', 
        6 => 'Отсутствует временная папка. ',
        7 => 'Не удалось записать файл на диск. ', 
        8 => 'PHP-расширение остановило загрузку файла. '
    );
    
    
    if ($file['error'] > 0) {
        $err[] = $errUpload[$file['error']];
    }
    
    if(!empty($err)) {
        $resData['message'] = implode(',', $err);
        $resData['success'] = FALSE;
    }
    
    return $resData;
}

/**
 * Проверка типа файла
 * 
 * @param array $file полученный файл
 * @return array массив
 */
function checkType ($file) {
    $resData['message'] = "";
    $resData['success'] = TRUE;
    
    $fileTypes =  array('pdf','png' ,'jpg');
    
    $type = pathinfo($file['name'], PATHINFO_EXTENSION);
    if(!in_array($type, $fileTypes)) {
        $resData['message'] = 'Данный тип файла ' . $type . ' не подходит для загрузки! ';
        $resData['success'] = FALSE;
    }
    
    return $resData;
}

<?php

/**
 * 
 * Модель для таблицы lab_exec, lab_history
 *
 */


/**
 * Создание записи в таблице lab_exec
 * 
 * @return array id созданной записи
 */
function createLabExec($labId){
    //FIX: Передалать все под ООП. Не стоит открывать соединение здесь 
    $dblocation = "127.0.0.1"; //$dbhost = "localhost";
    $dbname = "labservis";
    $dbuser = "root";
    $dbpassword = "";
    
    $db = new mysqli($dblocation, $dbuser, $dbpassword, $dbname);
    
    $sql = "INSERT INTO `lab_exec` (`lab_id`)
            VALUES ('{$labId}')";
    $rs = $db->query($sql);
    
    if ($rs) {
        $rs = lastInsertId($db);
    }
    
    return $rs;
}

/**
 * Записывает в таблицу lab_history ответ студента к выполнению лабораторной
 * 
 * @param integer $labExec номер выполнения лабораторной (id из таблицы lab_exec)
 * @param string $answer ответ
 * @param string $file путь к сохраненному файлу
 * @return array история выполнения лабораторной
 */
function updateLabHistory($labExec, $answer, $file) {
    date_default_timezone_set('Asia/Tomsk');
    $date = date("y.m.d");
    
    
    $sql = "INSERT INTO 
            `lab_history` (`date`, `answer`, `attachment`, `lab_exec_id`)
            VALUES ('{$date}', '{$answer}', '{$file}', '{$labExec}')";
            
    $rs = db()->query($sql);
    
    if ($rs) {
        $sql = "SELECT * FROM `lab_history`
                WHERE (`lab_exec_id` = '{$labExec}')";
        
        $rs = db()->query($sql);
        $rs = createRsTwigArray($rs);
        
        if (isset($rs[0])) {
            $rs['success'] = TRUE;
        } else {
            $rs['success'] = FALSE;
        }
    } else {
        $rs['success'] = FALSE;
    }
    
    return $rs;
}

/**
 * Возвращает все ответы, прикретпленные к выполнению лр ($labExec)
 * 
 * @param integer $labExec номер выполнения лабораторной (id из таблицы lab_exec)
 * @return array история выполнения лабораторной
 */
function labHistory($labExec) {
    $sql = "SELECT * FROM `lab_history`
            WHERE (`lab_exec_id` = '{$labExec}')";

    $rs = db()->query($sql);
    
    return createRsTwigArray($rs);
}



<?php

/**
 * 
 * Модель для таблицы lab
 * 
 */


/**
 * Получение всех лабораторных
 * 
 * @return array массив лабораторных
 */
function getAllLab() {
    $sql = "SELECT * 
            FROM `lab`
            ORDER BY `course_id`, `number`";
    
    $rs = db()->query($sql);

    return createRsTwigArray($rs);
}

function getLastLab($courseId) {
    $sql = "SELECT max(number) 
            FROM `lab`
            WHERE `course_id` = '{$courseId}'";
    
    $rs = db()->query($sql);
    
    return $rs->fetch_assoc();
}
/**
 * Получение лабораторных курса с кодом $courseId
 * 
 * @param integer $courseId id курса
 * @return array массив лабораторных
 */
function getLabForCourse($courseId) {
    $courseId = intval($courseId);
    $sql = "SELECT * 
            FROM `lab`
            WHERE `course_id` = '{$courseId}'";
    
    $rs = db()->query($sql);
    
    return createRsTwigArray($rs);
}

/**
 * Получить данные курса по id
 * 
 * @param integer $courseId ID курса
 * @return array
 */

/**
 * Получить данные лабораторной по id
 * 
 * @param integer $labId ID лабораторной
 * @return array
 */
function getLabById($labId) {
    $labId = intval($labId);
    $sql = "SELECT * 
            FROM `lab`
            WHERE `id` = '{$labId}'";
    
    $rs = db()->query($sql);
    
    return $rs->fetch_assoc();
}

function checkAddLabParam($title, $courseId) {
    $res = null;
    
    if(!$title) {
        $res['success'] = FALSE;
        $res['message'] = "Введите название лабораторной";
    }
    
    if(!$courseId) {
        $res['success'] = FALSE;
        $res['message'] = "Выберите курс";
    }
    
    return $res;
}

/**
 * Проверяет нет ли лабораторной с названием $title в курсе $courseId
 * 
 * @param string $title
 * @return array строка из таблицы lab, либо пустой массив
 */
function checkLabTitle($title, $courseId) {    
    $title = htmlspecialchars(mysqli_real_escape_string(db(), $title));
    
    $sql = "SELECT `id` FROM `lab`
            WHERE (`title` = '{$title}' AND `course_id` = '{$courseId}')";
        
    $rs = db()->query($sql);
    $rs = createRsTwigArray($rs);
    
    return $rs;
}

function addNewLab($title, $task, $courseId) {
    $title = htmlspecialchars(mysqli_real_escape_string(db(), $title));
    $task = htmlspecialchars(mysqli_real_escape_string(db(), $task));
    $courseId = htmlspecialchars(mysqli_real_escape_string(db(), $courseId));
    $number = getLastLab($courseId)['max(number)'] + 1;
    
    $sql = "INSERT INTO 
            `lab` (`number`, `title`, `task`, `access`, `course_id`)
            VALUES ('{$number}', '{$title}', '{$task}', 0, '{$courseId}')";
    
    //db()->query($sql);
    
    $rs = db()->query($sql);
    
    if ($rs) {
        $sql = "SELECT * FROM `lab`
                WHERE (`title` = '{$title}' AND `course_id` = '{$courseId}')
                LIMIT 1";
        
        $rs = db()->query($sql);
        $rs = createRsTwigArray($rs);
        
        if (isset($rs[0])) {
            $rs['success'] = 1;
        } else {
            $rs['success'] = 0;
        }
    } else {
        $rs['success'] = 0;
    }
    
    //РАЗОБРАТЬСЯ ПОЧЕМУ ВСЕГДА ВОЗВРАЩАЕТ НОЛЬ
    //УДАЛИТЬ ПРОВЕРКУ IF КОГДА РЕШУ ПРОБЛЕМУ 
    //$id = mysqli_insert_id(db());
    
    return $rs;
}


function updateLabData($labId, $newNumber=-1, $newTitle='', $newTask='', $newAccess=-1, $newCourseId=-1) {
    $set = array();
    
    if($newNumber > -1) {
        $set[] = "`number` = '{$newNumber}'";
    }
    
    if($newTitle) {
        $set[] = "`title` = '{$newTitle}'";
    }
    
    if($newTask) {
        $set[] = "`task` = '{$newTask}'";
    }
    //!!!!!!!!!!!!!!!!! - 0/1
    if($newAccess > -1) {
        $set[] = "`access` = '{$newAccess}'";
    }
    // !!!!!!!!!!!!!!!! is defined
    if($newCourseId > -1) {
        $set[] = "`course_id` = '{$newCourseId}'";
    }
    
    $setStr = implode($set, ", ");
    $sql = "UPDATE lab
            SET {$setStr}
            WHERE id = '{$labId}'";
    
    $rs = db()->query($sql);
    
    return $rs;
}


/**
 * Получение lab_exec_id соответсвующих id из таблицы lab_exec
 * 
 * @param integer $id лабораторной
 * @return array массив lab_exec_id
 */
function getLabExecId($id) {
    $sql = "SELECT `id` FROM `lab_exec` WHERE `lab_id` = '{$id}'";
    
    $rs = db()->query($sql);
    
    return createRsTwigArray($rs);
}

/**
 * Удаление лабораторной
 * 
 * @param integer $id лабораторной
 * @return array
 */
function deleteLab($id) {
    $sql = "";
    $labExec = getLabExecId($id);
    if (!empty($labExec)) {
        $count = count($labExec);        
        for ($i = 0; $i < $count; $i++) {
            $labExecId = $labExec[$i]['id'];
            $sql .= "DELETE FROM `lab_history` WHERE `lab_exec_id` = {$labExecId}; ";
            $sql .= "DELETE FROM `student_lab_exec` WHERE `lab_exec_id` = {$labExecId}; ";   
        }
    }
    
    $sql .= "DELETE FROM `lab_exec` WHERE `lab_id` = {$id}; ";
    $sql .= "DELETE FROM `lab` WHERE `id` = {$id}; ";
    $rs = db()->multi_query($sql);
    
    return $rs;
}


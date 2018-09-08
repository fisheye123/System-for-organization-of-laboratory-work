<?php

/**
 * 
 * Модель для таблицы student, student_course, student_lab_exec
 *
 */

/**
 * Получение всех студентов
 * 
 * @return array массив студентов
 */
function getAllStudent() {
    $sql = "SELECT * 
            FROM `student`
            ORDER BY `learn_group`";
    
    $rs = db()->query($sql);

    return createRsTwigArray($rs);
}

/**
 * Получение всех студентов, которым открыт курс
 * 
 * @return array массив студентов
 */
function getStudentsByCourse($courseId) {
    $sql = "SELECT `student_id` 
            FROM `student_course`
            WHERE `course_id` = '{$courseId}'";
    
    $rs = db()->query($sql);
    
    if ($rs) {
        $rs = createRsTwigArray($rs);
        $arr = array(); 
        $sql = "SELECT * FROM `student`
                WHERE";
        
        foreach ($rs as &$student) {
            array_push($arr, "`id` = '{$student['student_id']}'");
        }
        
        $comma_separated = implode(" OR ", $arr);
        $sql = $sql . $comma_separated . " ORDER BY `learn_group`";
        
        $resData = db()->query($sql);
    }
    
    return createRsTwigArray($resData);
}

function addNewStudent($name, $group) {
    $name = htmlspecialchars(mysqli_real_escape_string(db(), $name));
    $group = htmlspecialchars(mysqli_real_escape_string(db(), $group));
    
    $sql = "INSERT INTO 
            `student` (`name`, `learn_group`)
            VALUES ('{$name}', '{$group}')";
    
    //db()->query($sql);
    
    $rs = db()->query($sql);
    
    if ($rs) {
        $sql = "SELECT * FROM `student`
                WHERE (`name` = '{$name}')
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

function checkAddStudentParam($name) {
    $res = null;
    
    if(!$name) {
        $res['success'] = FALSE;
        $res['message'] = "Введите имя студента";
    }
    
    return $res;
}

/**
 * Проверяет не занято ли имя в БД
 * 
 * @param string $name
 * @return array строка из таблицы student, либо пустой массив
 */
function checkStudentName($name) {    
    $name = htmlspecialchars(mysqli_real_escape_string(db(), $name));
    
    $sql = "SELECT `id` FROM `student`
            WHERE `name` = '{$name}'";
        
    $rs = db()->query($sql);
    $rs = createRsTwigArray($rs);
    
    return $rs;
}

function updateStudentData($id, $newName='', $newGroup='') {
    $set = array();
    
    if($newName) {
        $set[] = "`name` = '{$newName}'";
    }
    
    if($newGroup) {
        $set[] = "`learn_group` = '{$newGroup}'";
    }
    
    $setStr = implode($set, ", ");
    $sql = "UPDATE `student`
            SET {$setStr}
            WHERE id = '{$id}'";
    
    $rs = db()->query($sql);
    
    return $rs;
}

function deleteStudent($id) {
    $sql = "DELETE FROM `student_lab_exec` WHERE `student_id` = {$id}; ";
    $sql .= "DELETE FROM `student_course` WHERE `student_id` = {$id}; ";
    $sql .= "DELETE FROM `student` WHERE `id` = {$id}; ";
    $rs = db()->multi_query($sql);
    
    return $rs;
}


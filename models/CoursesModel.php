<?php

/**
 * 
 * Модель для таблицы course
 *
 */


/**
 * Получение курсов и лабораторных в них
 * 
 * @return array массив курсов
 */
function getCourseWithLab(){
    $sql = "SELECT * 
            FROM `course`";
    
    $rs = db()->query($sql);
    $rsTwig = array();
    
    while($row = $rs->fetch_assoc()) {
        
        $rsLabs = getLabForCourse($row['id']);
        if($rsLabs) {
            $row['lab'] = $rsLabs;
        }
        
        $rsTwig[] = $row;
    }
    
    return $rsTwig;
}

/**
 * Получить данные курса по id
 * 
 * @param integer $courseId ID курса
 * @return array строка курса
 */
function getCourseById($courseId) {
    $courseId = intval($courseId);
    $sql = "SELECT * 
            FROM `course`
            WHERE `id` = '{$courseId}'";
    
    $rs = db()->query($sql);
    
    return $rs->fetch_assoc();
}

function checkAddCourseParam($title, $login, $password) {
    $res = null;
    
    if(!$title) {
        $res['success'] = FALSE;
        $res['message'] = "Введите название лабораторной";
    }
    
    if(!$login) {
        $res['success'] = FALSE;
        $res['message'] = "Введите логин";
    }
    
    
    if(!$password) {
        $res['success'] = FALSE;
        $res['message'] = "Введите пароль";
    }
    
    return $res;
}

/**
 * Проверяет логин ( не занят ли login в БД)
 * 
 * @param string $login
 * @return array строка из таблицы course, либо пустой массив
 */
function checkCourseLogin($login) {    
    $login = htmlspecialchars(mysqli_real_escape_string(db(), $login));
    
    $sql = "SELECT `id` FROM `course`
            WHERE `login` = '{$login}'";
        
    $rs = db()->query($sql);
    $rs = createRsTwigArray($rs);
    
    return $rs;
}

function addNewCourse($title, $description, $login, $password) {
    $title = htmlspecialchars(mysqli_real_escape_string(db(), $title));
    $description = htmlspecialchars(mysqli_real_escape_string(db(), $description));
    $login = htmlspecialchars(mysqli_real_escape_string(db(), $login));
    $password = htmlspecialchars(mysqli_real_escape_string(db(), $password));
    
    $sql = "INSERT INTO 
            `course` (`title`, `description`, `login`, `password`)
            VALUES ('{$title}', '{$description}', '{$login}', '{$password}')";
    
    //db()->query($sql);
    
    $rs = db()->query($sql);
    
    if ($rs) {
        $sql = "SELECT * FROM `course`
                WHERE (`title` = '{$title}')
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
    
    return $rs;
}

/**
 * Получение всех курсов
 * 
 * @return array массив лабораторных
 */
function getAllCourse() {
    $sql = "SELECT * 
            FROM `course`
            ORDER BY `id`";
    
    $rs = db()->query($sql);

    return createRsTwigArray($rs);
}

/**
 * Проверяет нет ли лабораторной с названием $title в курсе $courseId
 * 
 * @param string $title
 * @return array строка из таблицы lab, либо пустой массив
 */
function checkCourseTitle($title) {    
    $title = htmlspecialchars(mysqli_real_escape_string(db(), $title));
    
    $sql = "SELECT `id` FROM `course`
            WHERE (`title` = '{$title}')";
        
    $rs = db()->query($sql);
    $rs = createRsTwigArray($rs);
    
    return $rs;
}

function updateCourseData($id, $newTitle='', $newDescription='', $newLogin='', $newPassword='') {
    $set = array();
    
    if($newTitle) {
        $set[] = "`title` = '{$newTitle}'";
    }
    
    if($newDescription) {
        $set[] = "`description` = '{$newDescription}'";
    }
    
    if($newLogin) {
        $set[] = "`login` = '{$newLogin}'";
    }
    
    if($newPassword) {
        $set[] = "`password` = '{$newPassword}'";
    }
    
    $setStr = implode($set, ", ");
    $sql = "UPDATE course
            SET {$setStr}
            WHERE id = '{$id}'";
    
    $rs = db()->query($sql);
    
    return $rs;
}

function deleteCourse($id) {
    $sql = "DELETE FROM `lab` WHERE `course_id` = {$id}; ";
    $sql .= "DELETE FROM `teacher_course` WHERE `course_id` = {$id}; ";
    $sql .= "DELETE FROM `student_course` WHERE `course_id` = {$id}; ";
    $sql .= "DELETE FROM `course` WHERE `id` = {$id}; ";
    $rs = db()->multi_query($sql);
    
    return $rs;
}


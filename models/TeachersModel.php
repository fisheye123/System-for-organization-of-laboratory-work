<?php

/**
 * 
 * Модель для таблицы teacher
 *
 */

/**
 * Получение всех преподавателей
 * 
 * @return array массив лабораторных
 */
function getAllTeacher() {
    $sql = "SELECT * 
            FROM `teacher`
            ORDER BY `id`";
    
    $rs = db()->query($sql);

    return createRsTwigArray($rs);
}

/**
 * Получить данные преподавателя по id
 * 
 * @param integer $teacherId ID преподавателя
 * @return array строка преподавателя
 */
function getTeacherById($teacherId) {
    $teacherId = intval($teacherId);
    $sql = "SELECT * 
            FROM `teacher`
            WHERE `id` = '{$teacherId}'";
    
    $rs = db()->query($sql);
    
    return $rs->fetch_assoc();
}

/**
 * Получение всех курсов данного преподавателя
 * 
 * @return array массив курсов
 */
function getTeachersCourses($teacherId) {
    $sql = "SELECT `course_id` 
            FROM `teacher_course`
            WHERE `teacher_id` = '{$teacherId}'";
    
    $rs = db()->query($sql);
    
    return createRsTwigArray($rs);
}

/**
 * Регистрация нового преподавателя
 * 
 * @param string $name полное ФИО
 * @param string $email почта
 * @param string $login логин
 * @param string $password пароль, защифрованный в MD5
 * @return array
 */
function registerNewTeacher($name, $email, $login, $password) {
    $name = htmlspecialchars(mysqli_real_escape_string(db(), $name));
    $email = htmlspecialchars(mysqli_real_escape_string(db(), $email));
    $login = htmlspecialchars(mysqli_real_escape_string(db(), $login));
    $password = trim($password);    
    
    $sql = "INSERT INTO 
            `teacher` (`name`, `email`, `login`, `password`)
            VALUES ('{$name}', '{$email}', '{$login}', '{$password}')";
    
    $rs = db()->query($sql);
    
    if ($rs) {
        $sql = "SELECT * FROM `teacher`
                WHERE (`login` = '{$login}' AND `password` = '{$password}')
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
 * Проверяет логин ( не занят ли login в БД)
 * 
 * @param string $login
 * @return array строка из таблицы teacher, либо пустой массив
 */
function checkTeacherLogin($login) {    
    $login = htmlspecialchars(mysqli_real_escape_string(db(), $login));
    
    $sql = "SELECT `id` FROM `teacher`
            WHERE `login` = '{$login}'";
        
    $rs = db()->query($sql);
    $rs = createRsTwigArray($rs);
    
    return $rs;
}

/**
 * Проверяет существование имени
 * 
 * @param string $name
 * @return array 
 */
function checkTeacherName($name) {
    if(!$name) {
        $res['success'] = FALSE;
        $res['message'] = "Введите имя преподавателя ";
    }
    
    return $res;
}

function checkRegisterParam($name, $login, $password) {
    $res['message'] = "Введите ";
    
    if(!$name) {
        $res['success'] = FALSE;
        $res['message'] = $res['message'] . "имя преподавателя ";
    }
    
    if(!$login) {
        $res['success'] = FALSE;
        $res['message'] = $res['message'] . "логин ";
    }
    
    if(!$password) {
        $res['success'] = FALSE;
        $res['message'] = $res['message'] . "пароль";
    }
    
    return $res;
}

/**
 * Изменение данных преподавателя
 * 
 * @param string $name имя
 * @param string $email адрес электронной почты
 * @param string $password1 новый пароль
 * @param string $password2 повтор нового пароля
 * @param string $curPassword текущий пароль
 * @return boolean TRUE в случае успеха
 */
function updateTeacherDatalk($name, $email, $password1, $password2, $curPassword) {
    $login = htmlspecialchars(mysqli_real_escape_string(db(), $_SESSION['teacher']['login']));
    $name = htmlspecialchars(mysqli_real_escape_string(db(), $name));
    $email = htmlspecialchars(mysqli_real_escape_string(db(), $email));
    $password1 = trim($password1);
    $password2 = trim($password2);
    
    $newPassword = NULL;
    if( $password1 && ($password1 == $password2) ) {
        $newPassword = md5($password1);
    }
    
    $sql = "UPDATE `teacher`
            SET ";
    
    if( $newPassword ) {
        $sql .= " `password` = '{$newPassword}',";
    }
    
    $sql .= "`name` = '{$name}',
             `email` = '{$email}'
            WHERE (`login` = '{$login}' AND `password` = '{$curPassword}')
            LIMIT 1";
    
    $rs = db()->query($sql);
    
    return $rs;
}

function updateTeacherData($teacherId, $name='', $email='', $login='', $password='') {
    $set = array();

    if($name) {
        $set[] = "`name` = '{$name}'";
    }
    
    if($email) {
        $set[] = "`email` = '{$email}'";
    }
    
    if($login) {
        $set[] = "`login` = '{$login}'";
    }
    
    if($password) {
        $password = md5(trim($password));
        $set[] = "`password` = '{$password}'";
    }
    
    $setStr = implode($set, ", ");
    $sql = "UPDATE teacher
            SET {$setStr}
            WHERE id = '{$teacherId}'";
    
    $rs = db()->query($sql);
    
    return $rs;
}

function deleteTeacher($id) {
    $sql = "DELETE FROM `teacher_course` WHERE `teacher_id` = {$id}; ";
    $sql .= "DELETE FROM `teacher` WHERE `id` = {$id}; ";
    $rs = db()->multi_query($sql);
    
    return $rs;
}



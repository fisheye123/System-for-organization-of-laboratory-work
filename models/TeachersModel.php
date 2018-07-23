<?php

/**
 * 
 * Модель для таблицы teacher
 *
 */

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

function checkRegisterParam($login, $password) {
    $res = null;
    
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
 * 
 * @param string $login логин
 * @param string $password пароль, защифрованный в MD5
 * @return array
 */
function loginUser($login, $password) {
    $login = htmlspecialchars(mysqli_real_escape_string(db(), $login));
    $password = trim($password);
    
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
    
    return $rs;
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
function updateTeacherData($name, $email, $password1, $password2, $curPassword) {
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





<?php

/**
 * 
 * Модель авторизации. 
 * Обращается к таблицам teacher, student
 *
 */

/**
 * 
 * @param string $login логин
 * @param string $password пароль, защифрованный в MD5
 * @return array
 */
function loginTeacher($login, $password) {
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
 * 
 * @param string $login логин
 * @param string $password пароль, защифрованный в MD5
 * @return array
 */
function loginAdmin($login, $password) {
    $login = htmlspecialchars(mysqli_real_escape_string(db(), $login));
    $password = trim($password);
    
    if ($login == 'admin' && $password == md5('admin')) {
        $rs['success'] = 1;
    } else {
        $rs['success'] = 0;
    }
    
    return $rs;
}

/**
 * 
 * @param string $login логин
 * @param string $password пароль, защифрованный в MD5
 * @return array
 */
function loginCourse($login, $password) {
    $login = htmlspecialchars(mysqli_real_escape_string(db(), $login));
    $password = trim($password);
    
    $sql = "SELECT * FROM `course`
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


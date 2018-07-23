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
function getAllCourses(){
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

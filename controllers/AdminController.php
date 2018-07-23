<?php

/**
 * 
 * Контроллер бэка
 * 
 */

include_once '../models/CoursesModel.php';
include_once '../models/LabsModel.php';
include_once '../models/TeachersModel.php';

function indexAction($twig) {
    $title = "Управление сайтом";
    
    $tpppl = myLoadTemplate($twig, 'admin');
    
    echo $tpppl->render(array(
            'title' => $title
        ));
}




















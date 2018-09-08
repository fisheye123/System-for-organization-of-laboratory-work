<?php

/**
 * 
 * Основные функции
 * 
 */


/**
 * Формирование запрашиваемой страницы
 * 
 * @param string $controllerName название контроллера
 * @param string $actionName название функции обработки страницы
 */
function loadPage ($twig, $controllerName, $actionName = 'index') {
    //подключение контроллера
    include_once PathPrefix . $controllerName . PathPostfix;
    
    //вызов функции (экшн)
    $function = $actionName . 'Action';
    $function($twig);
}

/**
 * Загрузка шаблона
 * 
 * @param object $twig объект шаблонизатора
 * @param string $templateName название файла шаблонизатора
 */
function myLoadTemplate ($twig, $templateName) {
    return $twig->loadTemplate($templateName . TemplatePostfix);
}

/**
 * Функция отладки. Останавливает работу программы выводя $value
 * 
 * @param variant $value переменная для вывода на страницу
 * @param $die Определяет остановку программы. Если 0, то прерывания не проиходит
 */
function d($value = null, $die = 1) {
    echo 'Debug: ';
    print_r($value);
    
    if ($die) {
        die;
    }
}

/**
 * Преобразование выборки (SELECT) в ассоциативный массив
 * 
 * @param recordset $rs набор строк - результат работы SELECT
 * @return array преобразованный массив
 */
function createRsTwigArray($rs) {
    if (!$rs) {
        return FALSE;
    }

    $rsTwig = array();
    while ($row = $rs->fetch_assoc()) {
        $rsTwig[] = $row;
    }
    
    return $rsTwig;
}

/**
 * Перенаправление по адресу
 * 
 * @param string $url адрес
 */
function redirect($url = '/') {
    header("Location: {$url}");
    exit();
}

/**
 * Формирование навигации "хлебные крошки"
 * 
 * @return array массив, содержащий элементы крошек. Элемент содержит url, text.
 * Где url - ссылка на элемент, text - название элемента
 */
function breadcrumbs() {
    //Получение текущего url 
    $cur_url = $_SERVER['REQUEST_URI'];
    
    $urls = explode('/', $cur_url);
    $crumbs = array();
    $crumbs[0]['url'] = "/";
    $crumbs[0]['text'] = 'Главная страница';
    if (!empty($urls) && $cur_url != '/') {
        foreach ($urls as $key => $value) {
            switch ($value) {
                case 'course' :
                    $crumbs[$key]['url'] = "/course/{$urls[$key+1]}/";
                    $crumbs[$key]['text'] = getCourseById($urls[$key+1])['title'];
                    break;
                case 'lab' :
                    $crumbs[$key]['url'] = "/course/{$urls[$key-1]}/lab/{$urls[$key+1]}/";
                    $crumbs[$key]['text'] = getLabById($urls[$key+1])['title'];
                    break;
                case 'teacher' :
                    $crumbs[$key]['url'] = "/teacher/";
                    $crumbs[$key]['text'] = 'Преподаватель';
                    break;
                case 'courseadd' :
                    unset($crumbs[$key-1]);
                    $crumbs[$key]['url'] = "/courseadd/";
                    $crumbs[$key]['text'] = 'Добавить курс';
                    break;
                case 'labadd' :
                    unset($crumbs[$key-1]);
                    $crumbs[$key]['url'] = "/labadd/";
                    $crumbs[$key]['text'] = 'Добавить лабораторную';
                    break;
            }
        }
    }
    
    return $crumbs;
}

function lastInsertId($db) {
    $sql = "SELECT LAST_INSERT_ID()";
    $rs = $db->query($sql);
    $rs = createRsTwigArray($rs);
    $res = $rs[0]['LAST_INSERT_ID()'];
    
    return $res;
}



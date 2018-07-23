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
    
    //вызов экшена
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
 * @param $die определяет завершение программы (1 - да, 0 - нет)
 */
function d ($value = null, $die = 1) {
    echo 'Debug: <br/><pre>';
    print_r($value);
    echo '</pre>';
    
    if ($die) {
        die;
    }
}

/**
 * Преобразование выборки (SELECT) в ассоциативный массив
 * 
 * @param recordset $rs набор строк - результат работы SELECT
 * @return array
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
 * Перенаправление
 * 
 * @param string $url адрес для перенаправления
 */
function redirect($url = '/') {
    header("Location: {$url}");
    exit();
}


function breadcrumbs() {
    //Получение текущего url 
    $cur_url = $_SERVER['REQUEST_URI'];
    
    $urls = explode('/', $cur_url);
    
    //Содержит информацию о названиях элементов «хлебных крошек» и их url
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
                case 'teacher' : $crumbs[$key]['text'] = 'Преподаватель';
                    break;
            }
        }
    }
    
    return $crumbs;
}



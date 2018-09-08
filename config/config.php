<?php

/**
 * 
 * Файл настроек
 * 
 */

//>константы для обращения к контроллерам
define('PathPrefix', '../controllers/');
define('PathPostfix', 'Controller.php');
//<

//>используемые шаблоны
$template = 'default';
$templateAdmin = 'admin';
$templateCourse = 'course';

//>пути к фалам фаблонов (*.tpl) - views
define('TemplatePrefix', "../views/{$template}/");
define('TemplateAdminPrefix', "../views/{$templateAdmin}/");
define('TemplateCoursePrefix', "../views/{$templateCourse}/");
define('TemplatePostfix', '.tpl');
//<

//>инициализация шаблонизатора Twig
require_once '../library/twig/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(array(
        TemplatePrefix, 
        TemplateAdminPrefix, 
        TemplateCoursePrefix
    ));
$twig = new Twig_Environment($loader);
//<





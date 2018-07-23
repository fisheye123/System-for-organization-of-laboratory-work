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

//>используемый шаблон
$template = 'default';
$templateAdmin = 'admin';

//>пути к фалам фаблонов (*.tpl) - views
define('TemplatePrefix', "../views/{$template}/");
define('TemplateAdminPrefix', "../views/{$templateAdmin}/");
define('TemplatePostfix', '.tpl');
//<

//>путь к файлам шаблонов в веб пространстве - www
define("TemplateWebPath", "/templates/{$template}/");
define("TemplateAdminWebPath", "/templates/{$templateAdmin}/");
//<

//>инициализация шаблонизатора Twig
require_once '../library/twig/vendor/autoload.php';

//$loader = new Twig_Loader_Filesystem(TemplatePrefix);
$loader = new Twig_Loader_Filesystem(array(TemplatePrefix, TemplateAdminPrefix));
$twig = new Twig_Environment($loader);
//<







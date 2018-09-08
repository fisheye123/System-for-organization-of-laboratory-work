<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ title }}</title>
    <meta charset="utf-8">
    
    <!-- Поправить линк. Нужно чтобы доставал через Twig TemplateWebPath -->
    <link rel="stylesheet" href="/templates/admin/css/main.css" type="text/css"/>
    <link rel="stylesheet" href="/templates/default/css/main.css" type="text/css"/>
    
    <script type="text/javascript" src="/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="/js/main.js"></script>
    <script type="text/javascript" src="/templates/admin/js/admin.js"></script>
    <script type="text/javascript" src="/templates/default/js/teacher.js"></script>
    <script type="text/javascript" src="/templates/course/js/course.js"></script>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <div class="user-block">
                <div class="user-block__name">
                    {% if arAdmin is defined %}
                        <div id="teacherBox">
                            {{ arAdmin['displayName'] }}<br />
                            <a href="/auth/logout/" id="teacherLogoutImg" onclick="logout();">
                                <div class="exit">
                                    <!-- Поправить линк. Нужно чтобы доставал через Twig TemplateWebPath -->
                                    <img class="img" width="10" height="10" src="/templates/default/sourses/logout.svg"/>
                                </div>
                            </a>
                        </div>
                    {% endif %}
                </div>
            </div>
            
        </header>
        
        <main class="main-block">
        
            {% include "adminLeftColumn.tpl" %}
            
            <div class="page">
                

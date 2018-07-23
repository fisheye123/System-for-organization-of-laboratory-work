<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ title }}</title>
    <meta charset="utf-8">
    
    <!-- Поправить линк. Нужно чтобы доставал через Twig TemplateWebPath -->
    <link rel="stylesheet" href="/templates/default/css/main.css" type="text/css"/>
    <!-- Поключить локально посленюю версию jquery -->
    <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>-->
    <script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/js/main.js" type="text/javascript"></script>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <div class="user-block">
                <div class="user-block__name">
                    {% if arTeacher is defined %}
                        <div id="teacherBox">
                            <a href="/teacher/" id="teacherLink">{{ arTeacher['displayName'] }}</a><br />
                            <a href="/teacher/logout/" id="teacherLogoutImg" onclick="logout();">
                                <div class="exit">
                                    <!-- Поправить линк. Нужно чтобы доставал через Twig TemplateWebPath -->
                                    <img class="img" width="10" height="10" src="/templates/default/sourses/logout.svg"/>
                                </div>
                            </a>
                        </div>
                    
                    {% endif %}
                </div>
            </div>
            
            {% if crumbs is not empty %}
                <nav class="bread-crumbs">
                    <ul class="bread-crumbs__list">                               
                        {% for item in crumbs %}                
                            {% if item['url'] is not empty %}
                                <li class="bread-crumbs__item">
                                    {% if item['url'] is not empty %}
                                        <a href="{{ item['url'] }}">{{ item['text'] }}</a>
                                    {% else %}
                                        {{ item['text'] }}
                                    {% endif %}
                                </li>
                            {% endif %}
                        {% endfor %}
                    </ul>
                </nav>
            {% endif %}
            
        </header>
        
        <main class="main-block">
        
            {% include "leftColumn.tpl" %}
            
            <div class="page">
                

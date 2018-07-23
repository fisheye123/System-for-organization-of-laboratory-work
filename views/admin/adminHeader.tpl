<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ title }}</title>
    <meta charset="utf-8">
    
    <!-- Поправить линк. Нужно чтобы доставал через Twig TemplateWebPath -->
    <link rel="stylesheet" href="/templates/admin/css/main.css" type="text/css"/>
    <!-- Поключить локально посленюю версию jquery -->
    <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>-->
    <script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/js/admin.js" type="text/javascript"></script>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1>{{ title }}</h1> 
            
        </header>
        
        <main class="main-block">
        
            {% include "adminLeftColumn.tpl" %}
            
            <div class="page">
                


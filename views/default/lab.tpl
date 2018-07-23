{# Шаблон вывода лабораторной для студента #}

{% extends "base.tpl" %}

{% block content %}

    <h1 class="page__title">Лабораторная №{{ rsLab.number }} - {{ rsLab.title }}</h1>

    <div class="page__content">
        <form id="lab-form" class="lab-form">
            <div class="lab-form__wrapper lab-form__wrapper_top">{{ rsLab.task }}</div>
            <h3 class="lab-form__title">Отчёт</h3>
            <div class="lab-form__wrapper lab-form__wrapper_main">
                <div class="lab-form__wrapper lab-form__wrapper_left">
                    <label for="lab_answer" class="lab-form__item ">Ваш ответ:</label>
                    <label for="lab_students" class="lab-form__item">Выполнили:</label>
                </div>
                <div class="lab-form__wrapper lab-form__wrapper_right">
                    <textarea id="lab_answer" form="lab-form" class="lab-form__textarea"></textarea>
                    <button class="lab-form__button lab-form__button_file">Прикрепить файл</button>
                    <input id="lab_students" class="lab-form__input" type="text">
                </div>
            </div>
            <button class="lab-form__button lab-form__button_submit" type="submit">Отправить</button>
        </form>
    </div>
            
{% endblock %}
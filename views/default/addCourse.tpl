{% extends "base.tpl" %}

{% block content %}

    <h1 class="page__title">Добавить курс</h1>
    <div class="page__content">
        <form id="add-course-form" class="add-course-form">
            <div class="add-course-form__wrapper add-course-form__wrapper_main">
                <div class="add-course-form__wrapper add-course-form__wrapper_left">
                    <label for="course_title" class="add-course-form__item ">Название:</label>
                    <label for="course_desc" class="add-course-form__item">Описание:</label>
                    <label for="course_login" class="add-course-form__item ">Логин:</label>
                    <label for="course_password" class="add-course-form__item">Пароль:</label>
                </div>
                <div class="add-course-form__wrapper add-course-form__wrapper_right">
                    <input type="text" id="course_title" name="course_title" value="">
                    <textarea id="course_desc" name="course_desc" form="add-course-form" class="add-course-form__textarea"></textarea>
                    <input type="text" id="course_login" name="course_login" value="">
                    <input type="text" id="course_password" name="course_password" value="">
                </div>
            </div>
            <input class="add-course-form__button add-course-form__button_submit" type="button" onclick="addcourse();" value="Добавить"><br>
        </form>
    </div>

{% endblock %}

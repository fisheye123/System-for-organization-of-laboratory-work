{% extends "adminBase.tpl" %}

{% block content %}
    <h1 class="page__title">Преподаватели</h1>
    
    <h2 class="page__title">Изменить курсы преподавателя</h2>
    <div class="page__content">
        Преподаватель: {{ rsTeacher.name }}<br>
        Выберите курсы: <br>
        <div id="myDiv" class="padd">
            <p><select id="mySelect">
                {% for course in rsCourses %}
                    <option value="{{ course.id }}" >{{ course.title }}</option>
                {% endfor %}
            </select></p>
            <form id="myForm" method="post">
                <br><input type="submit" value="Сохранить">
            </form>
        </div>
        <br>Ваши курсы:<br>
        <div id="results" class="padd"></div>
    </div>
{% endblock %}

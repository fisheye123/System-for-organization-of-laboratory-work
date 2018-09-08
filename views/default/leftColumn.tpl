<nav class="menu">
    <ul class="menu__list">
        <h1 class="menu-list__title">МОИ КУРСЫ</h1>
        {% for course in rsCourses %}
            <li class="menu-list__item"><a href="/course/{{ course.id }}/">{{ course.title }}</a>
                {% if course['lab'] is defined %}
                    <ul class="menu-list__submenu">
                        {% for lab in course['lab'] %}
                            <li class="menu-list__sub-item"><a href="/course/{{ lab.course_id }}/lab/{{ lab.id }}/">{{ lab.title }}</a></li>
                        {% endfor %}
                    </ul>
                {% endif %}
            </li>
        {% endfor %}
    </ul>
    <a href="/course/courseadd/" class="button">Добавить курс</a>
</nav>
 
        

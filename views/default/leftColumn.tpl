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
            
        {% if arTeacher is not defined %}
            <div id="loginBox">
                <div class="menu__list showHidden" onclick="showLoginBox();">Авторизация</div>
                <div id="loginBoxHidden" class="hideme">
                    login:<br>
                    <input type="text" id="loginLogin" name="loginLogin" value=""/><br/>
                    password:<br>
                    <input type="password" id="loginPassword" name="loginPassword" value=""/><br/>
                    <input type="button" onclick="login();" value="Войти"><br>
                </div>
            </div>

            <div id="registerBox">
                <div class="menu__list showHidden" onclick="showRegisterBox();">Регистрация</div>
                <div id="registerBoxHidden" class="hideme">
                    name:<br>
                    <input type="text" id="name" name="name" value=""><br>
                    email:<br>
                    <input type="text" id="email" name="email" value=""><br>
                    login:<br>
                    <input type="text" id="login" name="login" value=""><br>
                    password:<br>
                    <input type="password" id="password" name="password" value=""><br>
                    <input type="button" onclick="registerNewTeacher();" value="Зарегистрироваться"><br>
                </div>
            </div>
        {% endif %}
                
    </ul>
</nav>
 
        

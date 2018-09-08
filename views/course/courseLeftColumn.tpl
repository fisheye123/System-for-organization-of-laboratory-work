<nav class="menu">
    <ul class="menu__list">
        <h1 class="menu-list__title">ЛАБОРАТОРНЫЕ</h1>
        {% for lab in rsLabs %}
            {% if lab.access %}
                <li class="menu-list__sub-item"><a href="/lab/{{ lab.id }}/">{{ lab.title }}</a></li>
            {% endif %}
        {% endfor %}
    </ul>
</nav>

<html>
<head>
    <title>{% block title %}Default Title{% endblock %}</title>
</head>

<body>
    <h1>Menu</h1>
    {% block menu %}
    <ul>
        {% for item in menu %}
            <li><a href="{{ item.url|safe }}">{{ item.name }}</a></li>
        {% endfor %}
    </ul>
    {% endblock %}
    {% include "assert_templates/partial.tpl" %}
</body>
</html>

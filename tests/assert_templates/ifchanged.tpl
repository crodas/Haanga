{% for user in users %}
    {% ifchanged %}Users with {{user.age}} years{% endifchanged %}
    {{ user.name }}
{% endfor %}

{% for user in users %}
    {% ifchanged user.age %}Users with {{user.age}} years{% endifchanged %}
    {{ user.name }}
{% endfor %}

{% for a in obj.method %}
    {{ a }}

    {% if forloop.last %}
        test
    {% endif %}
{% endfor %}

{% regroup users by age as sorted_users %}

{% for user in sorted_users %}
    {{user.grouper}}
    {% for u in user.list %}
        {{forloop.counter}}. {{ u.name|capfirst }}
    {% endfor %}
{% endfor %}

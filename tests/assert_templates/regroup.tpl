{% regroup users|dictsort:"age" by age as sorted_users %}

{% for user in sorted_users %}
    {{user.grouper}}
    {% for u in user.list %}
        {{forloop.counter}}-{{forloop.revcounter}}-{{forloop.revcounter0}} ({{forloop.parentloop.counter}}). {{ u.name|capfirst }} ({% if forloop.first %}first{% else %}{% if forloop.last %}last{% endif %}{% endif %})
    {% endfor %}
{% endfor %}

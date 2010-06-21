<table>
{% for var in some_list %}
    <tr class="{% cycle 'row1 cesar' 'row2' %}">
        Foobar {{ var }}
    </tr>
{% endfor %}
</table>

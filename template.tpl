<table>
{% for var in some_list %}
    <tr class="{% cycle 'row1 cesar' 'row2' %}">
        <td style="background-color: {% ifchanged var %} {%cycle 'red' 'back' %} {% else %} gray {% endifchanged %}">
            Foobar {{ var }}

            {% ifchanged %}{{ var }}{% endifchanged %}
        </td>
    </tr>
{% empty %} 
    Dear {{user}} you found a bug ;-)
{% endfor %}
</table>

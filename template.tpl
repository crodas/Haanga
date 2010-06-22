<table>
{% for var in some_list %}
    <tr class="{% cycle 'row1 cesar' 'row2' %}">
        <td>
            Foobar {{ var }}
        </td>
    </tr>
{% endfor %}
</table>

<script>
var i = 5 % 4;
function foo_bar  () {
    cesar {$rodas}
}
</script>
{# Testing Comment #}
<table>
{% for var in some_list %}
    {% for var in some_list %}
        {{ forloop.counter0 }}
    {% endfor %}

    <tr class="{% cycle 'row1 cesar' 'row2' %}">
        <td style="background-color: {% ifchanged var %} {%cycle 'red' 'back' %} {% else %} {%cycle 'gray' 'white' %} {% endifchanged %}">
            Foobar {{ var }}
            {% filter strtolower|strtoupper %}
            {% ifchanged %}Date {{ var }} foo {% endifchanged %}
            {% endfilter %}
        </td>
        <td>
            {{ forloop.counter0 }}
        </td>
        <td>
        {% block td %} 
            {% filter strtolower|strtoupper %}
                Testing block with filter {{ forloop.counter }} :-)
            {% endfilter %}
        {% endblock %}
        </td>
{% empty %} 
<tr> 
    <td>
        Dear {{user}} you found a bug ;-)
    </td>
</tr>
{% endfor %}
    </tr>
</table>

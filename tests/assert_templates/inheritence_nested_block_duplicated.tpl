{% extends "assert_templates/nested_block.tpl" %}

{% block outer %}
{{ block.super }}

new stuff
{% endblock outer %}

{% block inner2 %}
new inner2
{% endblock inner2 %}

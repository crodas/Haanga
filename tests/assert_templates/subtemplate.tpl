{% extends "assert_templates/base.tpl" %}

{% block title %}My Title - {{ block.super }}{% endblock %}

{% block menu %}
    {{ block.super}}

    :-)
{% endblock %}

{{ var|upper }}
{{ var|upper|lower }}
{{ var|cut:"u" }}
{{ var|length }}
{{ foobar|default:"default value"|upper}}
{% upper %}
    hola que 
{% endupper %}
{% lower %}TAL{% endlower %}
{% filter upper|lower %}
    hello world
{% endfilter %}

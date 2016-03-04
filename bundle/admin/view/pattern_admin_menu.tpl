{% for key,i in menu|reverse %}
	{% for key2,i2 in i %}
	<li>
		<a href="{{ router(i2.router) }}">
			<i class="tiny material-icons" style="padding-right:10px;">{{ i2.icon }}</i> 
			{{ key2 }}
		</a>
	</li>
	{% endfor %}
{% endfor %}
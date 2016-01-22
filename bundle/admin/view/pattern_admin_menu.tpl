{% for key,i in menu|reverse %}

<div class="panel panel-primary">
	<div class="panel-heading">
		<a href="{{ router( i.router ) }}" style="color:#FFF;">{{ key }}</a>
	</div>

	<div class="panel-body">
		{% for key2,i2 in i %}
			<a href="{{ router(i2.router) }}">
				<span class="glyphicon {{ i2.icon }}" aria-hidden="true"></span>
				{{ key2 }}
			</a><br/>
		{% endfor %}
	</div>
</div>
{% endfor %}
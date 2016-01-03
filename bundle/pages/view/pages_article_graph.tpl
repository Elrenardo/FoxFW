{% for i in liste %}
<div class="card">
	{% if i.img is not empty %}
	<div class="card-image waves-effect waves-block waves-light">
		<img class="activator" src="{{ i.img }}">
	</div>
	{% endif %}

	<div class="card-content">
		<span class="card-title activator grey-text text-darken-4">{{ i.titre }}</span>
		<br/>
		<div>
			<a href="{{ router('Page_viewPage', i.url) }}">Lire l'article au complet</a>
			<div style="float:right;" >
				<i class="tiny material-icons">query_builder</i> {{i.date|date("d/m/Y")}}
			</div>
		</div>
	</div>
</div>
{% endfor %}
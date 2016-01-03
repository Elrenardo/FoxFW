{% extends getView('pattern_index') %}

{% block title %}Calendrier {{ parent() }}{% endblock %}

{% block css %}{{ parent() }}
<link rel="stylesheet" href="{{ path('web/css/calendrier.css') }}"/>
{% endblock %}

{% block container %}

{% set compte = 0 %}
{% for i in event %}
	{% set compte = compte +1 %}
	<div class="row">
		<div class="col s12 m6 offset-m3">
			<div class="card" style="background-color:{{ tagColor[ i.tag ] }};">
				<div class="card-content white-text">
					<span class="card-title">[{{ i.tag }}] {{ i.titre }}</span>
					<p>{{ i.body|raw }}</p>
				</div>

				<div class="card-action">
					<table class="table" style="color:#FFF;">
						<tr>
							<td>Du</td><td>{{ timeToDate(i.date) }}</td>
						</tr>
						<tr>
							<td>Au</td><td>{{ timeToDate(i.date_end) }}</td>
						</tr>
						<tr>
							<td>A</td><td>{{ i.lieu }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- {{ router('calendrier_listeTag', i.tag ) }} -->

{% endfor %}
{% if compte == 0 %}
	<h5 style="text-align:center;">Aucun Evénement futur trouvé !</h5>
{% endif %}

{% endblock %}
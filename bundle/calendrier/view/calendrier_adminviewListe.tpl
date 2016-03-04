{% extends getView('pattern_admin') %}

{% block title %}Calendrier {{ parent() }}{% endblock %}

{% block head_base %}
<link rel="stylesheet" href="{{ path('web/css/calendrier.css') }}"/>
{% endblock %}

{% block container %}
<div class="container">
	<a href="{{ router('calendrier_addEvent') }}" class="waves-effect waves-light btn amber darken-1">Ajouter un événement</a>
	<hr/>
	
		<table class="table table-hover table-striped">
		<tr>
			<th>Titre</th>
			<th>Tag</th>
			<th>Date</th>
			<th>Modifier</th>
			<th>Supprimer</th>
		</tr>
		{% set compte = 0 %}
		{% for i in event %}
			{% set compte = compte +1 %}
			<tr>
				<td>
					<a href="{{ router('calendrier_view',i.url) }}" target="_blank">{{ i.titre }}</a>
				</td>

				<td>
					{{ i.tag }}
				</td>

				<td>
					Du: <b>{{ timeToDate(i.date) }}</b><br/>
		      		Au: <b>{{ timeToDate(i.date_end) }}</b><br/>
		      		A: <b>{{ i.lieu }}</b>
	      		</td>

	      		<td>
	      			<a href="{{ router('calendrier_editEvent', i.id) }}">Modifier</a>
	      		</td>
	      		<td>
	      			<a href="{{ router('calendrier_removeEvent', i.id ) }}">[ X ]</a>
	      		</td>
      		</tr>
		{% endfor %}
		</table>
		{% if compte == 0 %}
			<h5 style="text-align:center;">Aucun Evénement futur trouvé !</h5>
		{% endif %}
	</div>
</div>
{% endblock %}
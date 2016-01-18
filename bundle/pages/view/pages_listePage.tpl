{% extends getView('pattern_admin') %}

{% block title %}Liste Page {{ parent() }}{% endblock %}

{% block container %}
	<div>

		<form method="POST" class="fil_ariane" action="{{ router('Page_searchAdminPage') }}">
		{{ securityForm() }}
		    <div class="form-inline form-group">
		    	<input type="search" class="input-sm form-control" placeholder="Recherche" name="search" style="width:400px;">
		    	<button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span> Chercher</button>
		    </div>
    	</form>

		<table class="table table-hover">
			<caption><h3>{{ titre }}</h3></caption>
			<tr>
				<th>Titre</th>
				<th>Type</th>
				<th>Date</th>

					<th>Modifier</th>
					<th>Supprimer</th>
			</tr>
		{% for i in liste %}
				<tr>
					<td><a href="{{ router('Page_viewPage', i.url) }}" target="_blank">{{ i.titre }}</a></td>
					<td>
						{{ i.type }}
					</td>
					<td>{{ timeToDate(i.date) }}</td>

					<td><a href="{{ router('Page_viewUpdatePage', i.id) }}">MODIFIER</a></td>
					<td><a href="{{ router('Page_removePage', i.id) }}">SUPPRIMER</a></td>
				</tr>
		{% endfor %}
		</table>
	</div>
{% endblock %}
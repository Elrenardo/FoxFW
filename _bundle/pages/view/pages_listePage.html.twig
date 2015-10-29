{% extends getView('pattern_index') %}

{% block title %}Liste Page {{ parent() }}{% endblock %}

{% block container %}
	<div class="container page_model img-thumbnail col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 col-lg-offset-2">

		<ol class="breadcrumb fil_ariane img-thumbnail">
		  <li><a href="{{ router('index') }}">Accueil</a></li>
		  <li class="active">Liste Pages {{ titre }}</li>
		</ol>

		<form method="POST" class="fil_ariane" action="{{ router('Page_searchPagePost') }}">
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

				{% if User.isRole('PAGE') == true %}
					<th>Supprimer</th>
					<th>Modifier</th>
				{% endif %}
			</tr>
		{% for i in liste %}
				<tr>
					<td><a href="{{ router('Page_viewPage', i.url) }}">{{ i.titre }}</a></td>
					<td>
						{{ i.type }}
					</td>
					<td>{{ timeToDate(i.date) }}</td>

					{% if User.isRole('PAGE') == true %}
						<td><a href="{{ router('Page_viewUpdatePage', i.id) }}">MODIFIER</a></td>
						<td><a href="{{ router('Page_removePage', i.id) }}">SUPPRIMER</a></td>
					{% endif %}
				</tr>
		{% endfor %}
		</table>
	</div>
{% endblock %}
{% extends getView('pattern_index') %}

{% block title %}Liste Page {{ parent() }}{% endblock %}

{% block container %}
	<div class="container page_model img-thumbnail col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 col-lg-offset-2">

		<ol class="breadcrumb fil_ariane img-thumbnail">
		  <li><a href="{{ router('index') }}">Accueil</a></li>
		  <li class="active">Liste Utilisateur</li>
		</ol>

		<form method="POST" class="fil_ariane img-thumbnail" 
		action="{{ router('user_searchListeUsers') }}">
		{{ securityForm() }}
		    <div class="form-inline form-group">
		    	<input type="search" class="input-sm form-control" placeholder="Recherche par Email" name="search" style="width:400px;">
		    	<button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span> Chercher utilisateur</button>
		    </div>
    	</form>

		<table class="table table-hover">
			<tr>
				<th>Email</th>
				<th>Grade</th>
				{% if User.isRole('USERS_PERMISSION') == true %}
					<th>Modifier Roles</th>
				{% endif %}
			</tr>
			{% for i in users %}
				<tr>
					<td>{{ i.email }}</td>
					<td>
						<ul>
							{% for p in i.roles %}
								<li>{{ p }}</li>
							{% endfor %}
						</ul>
					</td>
					{% if User.isRole('USERS_PERMISSION') == true %}
					<td>
						<form method="POST" action="{{ router('user_updateRole') }}">
							{{ securityForm() }}
							<select name="role">
								{% for r in roles %}
									<option name="{{ r }}">{{ r }}</option>
								{% endfor %}
							</select>
							<input type="hidden" name="clef" value="{{ i.clef }}" />
							<input type="submit" name="add" value="Ajouter" />
							<input type="submit" name="del" value="Supprimer" />
						</form>
					</td>
					{% endif %}
				</tr>
			{% endfor %}
		</table>
	</div>
{% endblock %}
{% extends getView('pattern_admin') %}

{% block title %}Liste Page {{ parent() }}{% endblock %}

{% block container %}
	<div>

		<form method="POST" class="fil_ariane" action="{{ router('user_searchListeUsers') }}">
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
					<th>Supprimer</th>
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
					<td>
						<a href="{{ router( 'user_delete', i.id ) }}">[X]</a>
					</td>
					{% endif %}
				</tr>
			{% endfor %}
		</table>
	</div>
{% endblock %}
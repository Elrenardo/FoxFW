{% extends getView('pattern_admin') %}

{% block title %}Liste Page {{ parent() }}{% endblock %}

{% block container %}
	<div class="container">
		<p class="flow-text">Gestion des comptes utilisateurs</p>
	</div>

	<div class="section grey lighten-4">
		<form method="POST" class="container" action="{{ router('user_searchListeUsers') }}">
		{{ securityForm() }}
	    	<div class="row">
		        <div class="input-field col s12">
		          <i class="material-icons prefix">search</i>
		          <input id="d_search" name="search" type="text" class="validate">
		          <label for="d_search">Rechercher un compte utilisateur</label>
		        </div>
	    	</div>
    	</form>
    </div>
    <div class="divider"></div>

    <div class="container">

		<table class="highlight">
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
{% extends getView('pattern_admin') %}

{% block title %}Liste Page {{ parent() }}{% endblock %}

{% block container %}
	<div class="section">
		<div class="container">
			<a href="{{ router('contacts_add') }}" class="waves-effect waves-light btn amber darken-1 right">Ajouter un contact</a>
			<p class="flow-text">Gestion des contacts</p>
		</div>
	</div>
	<div class="divider"></div>

	<div class="section grey lighten-4">
		<div class="container">
			<form method="POST" class="fil_ariane" action="{{ router('contacts_search') }}">
				{{ securityForm() }}

				<div class="row">
			        <div class="input-field col m6 s12">
			          <i class="material-icons prefix">search</i>
			          <input id="d_search" name="search" type="text" class="validate">
			          <label for="d_search">Rechercher un contact</label>
			        </div>

					<div class="input-field col m5 s12">
						<select name="groupe">
							<option value="" disabled selected>Choisissez le groupe ?</option>
								{% for i in groupe %}
									<option value="{{ i }}" >{{ i }}</option>
								{% endfor %}
						</select>
						<label>Choisir une recherche par groupe</label>
					</div>

					<div class="input-field col m1 s12">
						<button class="btn waves-effect waves-light" type="submit">
						    <i class="material-icons right">search</i>
						</button>
					</div>

		    	</div>


	    	</form>

		    <div class="container center">
	          <h5>{{ titre }}</h5>
	        </div>

	    </div>
    </div>
    <div class="divider"></div>
    <div class="section">
    	<div class="container">
			<table class="bordered highlight">
				<thead>
					<tr>
						<th>Nom &amp; Prenom</th>
						<th>Structure</th>
						<th>Information</th>

						<th class="right">Modification</th>
					</tr>
				</thead>
				<tbody>
				{% for i in list %}
						<tr>
							<td>
								{{ i.nom }} {{ i.prenom }}<br/>
							</td>
							<td>
								{{ i.structure }}<br/>
								<blockquote>
									{{ i.intitule }}
								</blockquote>
							</td>
							<td>
								[<span>{{ i.groupe }}</span>]
								<blockquote>
									Email: {{ i.email }}<br/>
									Tel. Fixe: {{ i.telfixe }}<br/>
									Tel. Port: {{ i.telportable }}
								</blockquote>
								{{ i.commentaire }}
							</td>

							<td class="right">
								<a href="{{ router('contacts_edit', i.id) }}">
									<i class="small material-icons">settings</i>
								</a>
								<a href="{{ router('contacts_del', i.id) }}" style="color:red;margin-left:30px;">
									<i class="small material-icons">delete</i>
								</a>
							</td>
						</tr>
				{% endfor %}
				</tbody>
			</table>
		</div>
	</div>
{% endblock %}
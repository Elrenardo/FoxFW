{% extends getView('pattern_admin') %}

{% block title %}Liste Page {{ parent() }}{% endblock %}

{% block container %}
	<div class="section">
		<div class="container">
			<a href="{{ router('Page_addPage') }}" class="waves-effect waves-light btn amber darken-1 right">Ajouter une page </a>
			<p class="flow-text">Gestion des pages du site</p>
		</div>
	</div>
	<div class="divider"></div>

	<div class="section grey lighten-4">
		<div class="container">
			<form method="POST" class="fil_ariane" action="{{ router('Page_searchAdminPage') }}">
				{{ securityForm() }}

				<div class="row">
			        <div class="input-field col s12">
			          <i class="material-icons prefix">search</i>
			          <input id="d_search" name="search" type="text" class="validate">
			          <label for="d_search">Rechercher une page</label>
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
						<th>Titre</th>
						<th>Information</th>

						<th class="right">Modification</th>
					</tr>
				</thead>
				<tbody>
				{% for i in liste %}
						<tr>
							<td><a href="{{ router('Page_viewPage', i.url) }}" target="_blank">{{ i.titre }}</a></td>
							<td>
								{{ i.type }}<br/>
								{{ timeToDate(i.date) }}
							</td>

							<td class="right">
								<a href="{{ router('Page_viewUpdatePage', i.id) }}">
									<i class="small material-icons">settings</i>
								</a>
								<a href="{{ router('Page_removePage', i.id) }}" style="color:red;margin-left:30px;">
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
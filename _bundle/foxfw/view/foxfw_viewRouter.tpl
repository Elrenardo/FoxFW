{% extends getView('pattern_index') %}

{% block container %}
<div class="container">

	<ol class="breadcrumb fil_ariane">
	  <li><a href="{{ router('index') }}">Accueil</a></li>
	  <li class="active">Router</li>
	</ol>

	<table class="table table-hover table-striped">
		<caption style="margin-bottom:20px;">
			<h3>
				<span class="glyphicon glyphicon-random" aria-hidden="true"></span>
				  <b style="color:red;">Table de routage</b> 
				<span class="glyphicon glyphicon-random" aria-hidden="true"></span>
			</h3>
		</caption>
		<tr>
			<th>Nom Router</th>
			<th>Path</th>
			<th>Method</th>
			<th>Controller</th>
			<th>FireWall</th>
		</tr>
		{% for key,i in router %}
			<tr>
				<td><a href="{{ router( key ) }}" target="_blank"><b>{{ key }}</b></a></td>
				<td>{{ i.path }}</td>
				<td>{{ i.method }}</td>
				<td>{{ i.controller }}</td>
				<td>
					{% if i.firewall == 'ADMIN' %}
						<span style="color:red;">{{ i.firewall }}</span>
					{% elseif i.firewall == 'ANONYME' %}
						<span style="color:blue;">{{ i.firewall }}</span>
					{% else %}
						<span style="color:green;">{{ i.firewall }}</span>
					{% endif %}
				</td>
			</tr>
		{% endfor %}
	</table>
</div>
{% endblock %}
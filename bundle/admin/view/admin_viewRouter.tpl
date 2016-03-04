{% extends getView('pattern_admin') %}

{% block container %}
<div class="container">
	<p class="flow-text">Vue du Router</p>

	<table class="highlight">
		<caption style="margin-bottom:20px;">
			<h5>
				  <b style="color:red;">Table de routage</b> 
			</h5>
		</caption>
		<tr>
			<th>Nom Router</th>
			<th>FireWall</th>
			<th>Path</th>
			<th>Method</th>
		</tr>
		{% for key,i in router %}
			<tr>
				<td><a href="{{ router( key ) }}" target="_blank"><b>{{ key }}</b></a><br/>{{ i.controller }}</td>
				<td>
					{% if i.firewall == 'ADMIN' %}
						<span style="color:red;">{{ i.firewall }}</span>
					{% elseif i.firewall == 'ANONYME' %}
						<span style="color:blue;">{{ i.firewall }}</span>
					{% else %}
						<span style="color:green;">{{ i.firewall }}</span>
					{% endif %}
				</td>
				<td>{{ i.path }}</td>
				<td>{{ i.method }}</td>
			</tr>
		{% endfor %}
	</table>
</div>
{% endblock %}
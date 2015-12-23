{% extends getView('pattern_admin') %}

{% block container %}
<div>

	<table class="table table-hover table-striped">
		<caption style="margin-bottom:20px;">
			<h3>
				<span class="glyphicon glyphicon-book" aria-hidden="true"></span>
				  <b style="color:red;">Model</b> 
				<span class="glyphicon glyphicon-book" aria-hidden="true"></span>
			</h3>
		</caption>
		<tr>
			<th>Model</th>
			<th>Path</th>
		</tr>

		{% for key,i in model %}
			<tr>
				<td>{{ key }}</td>
				<td>{{ i }}</td>
			</tr>
		{% endfor %}
	</table>

	<hr/>
	<table class="table table-hover table-striped">
		<caption style="margin-bottom:20px;">
			<h3>
				<span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
				  <b style="color:red;">View</b> 
				<span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
			</h3>
		</caption>
		<tr>
			<th>View</th>
			<th>Path</th>
		</tr>

		{% for key,i in view %}
			<tr>
				<td>{{ key }}</td>
				<td>{{ i }}</td>
			</tr>
		{% endfor %}
	</table>

	<hr/>
	<table class="table table-hover table-striped">
		<caption style="margin-bottom:20px;">
			<h3>
				<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
				  <b style="color:red;">Controller</b> 
				<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
			</h3>
		</caption>
		<tr>
			<th>Controller</th>
			<th>Path</th>
		</tr>

		{% for key,i in controller %}
			<tr>
				<td>{{ key }}</td>
				<td>{{ i }}</td>
			</tr>
		{% endfor %}
	</table>

</div>
{% endblock %}
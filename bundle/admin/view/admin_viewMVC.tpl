{% extends getView('pattern_admin') %}

{% block container %}
<div class="container">
	<p class="flow-text">Vue architecture M.V.C.</p>

	<table class="highlight">
		<caption style="margin-bottom:20px;">
			<h5>
				  <b style="color:red;">Model</b> 
			</h5>
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
	<table class="highlight">
		<caption style="margin-bottom:20px;">
			<h5>
				  <b style="color:red;">View</b> 
			</h5>
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
	<table class="highlight">
		<caption style="margin-bottom:20px;">
			<h5>
				  <b style="color:red;">Controller</b> 
			</h5>
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
{% extends getView('pattern_index') %}

{% block container %}
<div class="container page_model img-thumbnail col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 col-lg-offset-2">

	<ol class="breadcrumb fil_ariane img-thumbnail">
	  <li><a href="{{ router('index') }}">Accueil</a></li>
	  <li class="active">Configuration</li>
	</ol>

	<h3 style="text-align:center;">
		<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
		  <b style="color:red;">Configuration ::FoxFWKernel::</b> 
		<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
	</h3>

	<div class="center" >
	{% for key,i in config %}
			<table width="600" cellpadding="3" style="margin-bottom:10px;margin-top:50px;">
				<tbody>
					<tr class="h"><td><h1 class="p">{{ key }}</td></tr>
				</tbody>
			</table>
			<table width="600" cellpadding="3">
			{% for keyy,ii in i %}
				<tr>
					<td class="e"><b>{{ keyy }}</b></td>
					<td class="v">{{ ii }}</td>
				</tr>
			{% endfor %}
			</table>
			<hr/>
	{% endfor %}
	</div>
	<div style="margin-top:100px;">
		{{ phphinfo|raw }}
	</div>
</div>
{% endblock %}
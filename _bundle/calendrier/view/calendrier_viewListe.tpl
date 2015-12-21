{% extends getView('pattern_index') %}

{% block title %}Calendrier {{ parent() }}{% endblock %}

{% block head_base %}
<link rel="stylesheet" href="{{ path('web/css/calendrier.css') }}"/>
{% endblock %}

{% block container %}
	<div class="container">
		<ol class="breadcrumb fil_ariane img-thumbnail">
		  <li><a href="{{ router('index') }}">Accueil</a></li>
		  <li class="active">Calendrier</li>
		</ol>

		{% set compte = 0 %}
		{% for i in event %}
			{% set compte = compte +1 %}
			<div class="img-thumbnail fil_ariane" style="width:100%;margin-bottom:20px;">
				<div class="media" style="margin-bottom:80px;">
				   <a href="{{ router('calendrier_listeTag', i.tag ) }}" class="pull-left calendrier_tag" style="background-color:{{ tagColor[ i.tag ] }};">
				      <b>{{ i.tag }}</b>
				   </a>
				   <div class="media-body">
				      <h1 class="media-heading" style="display:inline;">
				      	<a href="{{ router('calendrier_view',i.url) }}">{{ i.titre }}</a>
				      </h1>
				      <div style="float:right;margin-left:50px;margin-bottom:20px;">
					      <h4>
					      		Du: <b>{{ timeToDate(i.date) }}</b><br/>
					      		Au: <b>{{ timeToDate(i.date_end) }}</b><br/>
					      		A: <b>{{ i.lieu }}</b>
					      </h4>
				  	  </div>

				      {{ i.body|raw }}<br/>
				   </div>
				</div>
			</div>
		{% endfor %}
		{% if compte == 0 %}
			<h3 style="text-align:center;">Aucun Evénement futur trouvé !</h3>
		{% endif %}
	</div>
{% endblock %}
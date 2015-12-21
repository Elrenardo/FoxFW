{% extends getView('pattern_index') %}

{% block title %}{{ event.titre }} - {{ parent() }}{% endblock %}

{% block head_base %}
<link rel="stylesheet" href="{{ path('web/css/calendrier.css') }}"/>
{% endblock %}

{% block container %}
	<div class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 col-lg-offset-2">
		<ol class="breadcrumb fil_ariane img-thumbnail">
		  <li><a href="{{ router('index') }}">Accueil</a></li>
		  <li><a href="{{ router('calendrier_listeEvent') }}">Calendrier</a></li>
		  <li><a href="{{ router('calendrier_listeTag', event.tag) }}">{{ event.tag }}</a></li>
		  <li class="active">{{ event.titre }}</li>
		</ol>
	</div>

	<div class="container img-thumbnail page_model col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 col-lg-offset-2">

		<div class="event_{{ event.id }}" id="calendrier_data">
				
				<h3 style="float:left;"><b>{{ event.titre }}</b></h3>

				<div style="float:right;margin-left:50px;">
					<h3>
						Le: <b>{{ timeToDate(event.date) }}</b><br/>
						Au: <b>{{ timeToDate(event.date_end) }}</b><br/>
						A: <b>{{ event.lieu }}</b>
					</h3>
				</div>

				<hr style="clear:both;"/>

				<a href="{{ router('calendrier_listeTag', event.tag ) }}" class="calendrier_tag" style="background-color:{{ tagColor[ event.tag ] }};float:left;margin-right:10px;">
      				<b>{{ event.tag }}</b>
   				</a>

				<span>{{ event.body|raw }}</span><br/>
		</div>

	</div>
{% endblock %}
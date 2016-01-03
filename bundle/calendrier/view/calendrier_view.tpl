{% extends getView('pattern_index') %}

{% block title %}{{ event.titre }} - {{ parent() }}{% endblock %}

{% block css %}{{ parent() }}
<link rel="stylesheet" href="{{ path('web/css/calendrier.css') }}"/>
{% endblock %}

{% block container %}
<div class="event_{{ event.id }}" id="calendrier_data">
		
		<h5 style="float:left;"><b>{{ event.titre }}</b></h5>

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
{% endblock %}
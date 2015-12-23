{% extends getView('pattern_admin') %}

{% block title %}Evenement - {{ parent() }}{% endblock %}

{% block head_base %}
	<script src="//cdn.ckeditor.com/4.4.7/full/ckeditor.js"></script>
{% endblock %}

{% block container %}
	<div>
		<div class="info">
			{% if msg is not empty %}
				<div>{{ msg|upper }}</div>
			{% endif %}

			{% if data is not empty %}
				{% set titre_event = 'Modifier un Evénement !' %}
				{% set form_router = 'calendrier_confirmEditEvent' %}
			{% else %}
				{% set titre_event = 'Ajouter un Evénement !' %}
				{% set form_router = 'calendrier_confirmAddEvent' %}
			{% endif %}
			<h3 style="text-align:center;color:red;">{{ titre_event }}</h3>
		</div>


		<form method="POST" action="{{ router( form_router ) }}" enctype="multipart/form-data">
		
		<div class="form-group">
			<b>Titre:</b><br/>
			<input type="text" class="form-control" style="width:100%;" name="titre" value="{{ data.titre }}" placeholder="Titre de l'événement" required>
		</div>
		<hr/>

		<div class="form-group">
			<b>Evénement pour:</b><br/>
			<select class="form-control" name="tag">
				{% for key,i in type %}
					<option value="{{ key }}" {% if data.tag==key %}selected="selected"{% endif %}>{{ key }}</option>
				{% endfor %}
			</select>
		</div>
		<hr/>

		<div class="form-group">
			<b>Lieux:</b><br/>
			<input type="text" class="form-control" style="width:100%;" name="lieu" value="{{ data.lieu }}" placeholder="Lieux de l'événement" required>
		</div>
		<hr/>

		<p>Date de l'événement:</p>
		<div class="form-inline">
			<div class="form-group">
				<input class="form-control" name="date" type="date" placeholder="mois/jour/année" id="selectDate" value="{{ data.dateDay }}"/>
			</div>
			<div class="form-group">
				<select class="form-control" name="date_heur">
				{% for i in 0..23 %}
					<option value="{{ i }}" 
					{% if data.dateHour==i %}selected="selected"{% endif %}
					>{{ i|number_format(2) }} H</option>
				{% endfor %}
				</select>
			</div>
		</div>
		<p>Date de fin de l'événement:</p>
		<div class="form-inline">
			<div class="form-group">
				<input class="form-control" name="dateEnd" type="date" placeholder="mois/jour/année" id="selectDateEnd" value="{{ data.dateEndDay }}"/>
			</div>
			<div class="form-group">
				<select class="form-control" name="dateEnd_heur">
				{% for i in 0..23 %}
					<option value="{{ i }}" 
					{% if data.dateEndHour==i %}selected="selected"{% endif %}
					>{{ i|number_format(2) }} H</option>
				{% endfor %}
				</select>
			</div>
		</div>

		<script>
			$(function() {
			    $( "#selectDate" ).datepicker();
			    $( "#selectDateEnd" ).datepicker();
			});
		</script>

		<hr/>


		<div class="form-group">
			<b>Body:</b><br/>
			<textarea id="texte" name="body">{{ data.body }}</textarea>
			<script>
            	CKEDITOR.replace( 'texte' );
        	</script>
		</div>

		<!-- Champs caché qui ne change pas -->
		{{ securityForm() }}
		<input type="hidden" value="{{ data.id }}" name="id" />

		<input type="submit" value="{{ titre_event }}" class="btn btn-default" style="float:right;"/>
		<span style="clear:both;"></span>
		<br/><br/><br/><br/>
	</form>
	</div>
{% endblock %}
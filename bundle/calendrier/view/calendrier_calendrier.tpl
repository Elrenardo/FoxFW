<div id="calendrier" class="hide-on-small-only">

<link rel="stylesheet" property='stylesheet' href="{{ bundlePath('calendrier#calendrier.css') }}"/>

	<div class="period">
		<!-- INFO SUR L'ANNE -->
		<div class="year ">
			<div>
				<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Calendrier: 
				<a href="{{ router('calendrier_year','-1') }}">&lt;&lt;</a> 
				<span>{{ years }}</span> 
				<a href="{{ router('calendrier_year','1') }}">&gt;&gt;</a>
				<a style="float:right;font-size:0.7em;" href="{{ router('calendrier_listeEvent') }} ">Liste des Evénements </a>
			</div>
		</div>

		<!-- Tableau de mois de l'année -->
		<div class="months">
			<ul>
				{% for key,month in months %}
					<li>
						<a href="#" id="linkMonth{{ key+1 }}">
							{{ month|slice(0,3) }}
						</a>
					</li>
				{% endfor %}
			</ul>
		</div>
		<div class="clear" style="margin-bottom:20px;"></div>
			<div class="calendrier_view col s12">
				{% for key,days in dates %}
					<div class="month" id="month{{ key }}">
						<table>
							<thead>
								<tr>
									{% for d in jours %}
										<th>{{ d|slice(0,3) }}</th>
									{% endfor %}
								</tr>
							</thead>
							<tbody>
								<tr>
								{% set day_semaine = 0 %}
{% for key,w in days%}

	{% if (key==1) and ((w-1)!=0) %}<td colspan="{{ w-1 }}" class="padding"></td>{% endif %}

	{% set text_color = '#A3A3A3' %}{% set color='#FFF' %}
	{% for test in liste_event %}
		{% if test.date < years_time+(60*60*24) %}
		{% if test.date_end > years_time %}
			{% set color= '#1A1A59' %}
			{% set text_color = '#FFF' %}
		{% endif %}
		{% endif %}

	{% endfor %}
	<td style="background-color:{{ color }};"
	onclick="document.location.href='{{ router('calendrier_listeDate',years_time) }}'" >
		<div class="relative">
			<div class="day">
				<a 
				href="{{ router('calendrier_listeDate',years_time) }}" 
				style="color:{{ text_color }};">{{ key }}</a>
			</div>
		</div>
	</td>
	{% set day_semaine = day_semaine+1 %}
	{% set years_time = years_time + (60*60*24) %}
	
	{% if (w==7) %}
		</tr><tr>
		{% set day_semaine = 0 %}
	{% endif %}

{% endfor %}

{% if (7-day_semaine>0) %}
	<td colspan="{{ 7-day_semaine }}" class="padding"></td>
{% else %}
	<td></td>
{% endif %}

								</tr>
							</tbody>
						</table>
					</div>
				{% endfor %}
			</div>
		</div>


<script type="text/javascript">
jQuery( function($)
{
	$('.month').hide();
	//$('.month:first').show();
	//$('.months a:first').addClass('active');
	//var current = 1;

	$('#month{{ moisActuel }}').show();
	$('#linkMonth{{ moisActuel }}').addClass('active');
	var current = {{ moisActuel }};

	$('.months a').click(function()
	{
		var month = $(this).attr('id').replace('linkMonth','');
		if( month != current )
		{
			$( '#month'+current ).slideUp();
			$( '#month'+month ).slideDown();

			$('.months a').removeClass('active');
			$('.months a#linkMonth'+month ).addClass('active');
			current = month;
		}
		return false;
	});
});
</script>
</div>
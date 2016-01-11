{% extends getView('pattern_index') %}

{% block title %}{{ parent() }}{% endblock %}

{% block container %}
<div class="container">
	<div class="section">
		<div class="row">
		{{ controller("Controller_carousel#view") }}
		</div>
	</div>
</div>

<div class="divider"></div>
<div class="blue-grey lighten-5 hide-on-small-only">
	<div class="container">
		<div class="section">
			<div class="row">
				{{ controller("Controller_calendrier#viewCalendrier") }}
			</div>
		</div>
	</div>
</div>

<div class="divider"></div>
<div class="container">
	<div class="section">
		<div class="row">
			{{ controller("Controller_page#viewListePage") }}
		</div>
	</div>

</div>
{% endblock %}
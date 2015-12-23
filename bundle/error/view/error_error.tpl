{% extends getView('pattern_index') %}

{% block title %}Erreur 404 - {{ parent() }}{% endblock %}

{% block container %}
		<div class="text-center">
			<h1>Erreur {{error}} !</h1>
			<p>{{ message|raw }}</p>
		</div>
{% endblock %}
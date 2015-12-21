{% extends getView('pattern_index') %}

{% block title %}Liste Page {{ parent() }}{% endblock %}

{% block container %}
	<div id="article" class="container">
		{% if titre is not empty %}
			<ol class="breadcrumb fil_ariane img-thumbnail">
			  <li><a href="{{ router('index') }}">Accueil</a></li>
			  <li class="active">{{ titre|capitalize }}</li>
			</ol>

		{% endif %}
		{% include getView('pages_article_graph') %}
	</div>
{% endblock %}
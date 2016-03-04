{% block secret %}{% endblock %}
<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>{% block title %}{% endblock %}</title>
	  <meta name="description" content="{% block metaDesc %}FoxFW CMS{% endblock %}" />
	  <meta name="keywords" content="{% block metaKey %}{% endblock %}" />
	  <meta name="author" content="StudioGoupil" />
	  <meta name="robots" content="all" />
	  <link rel="icon" type="image/png" href="{% block favicon %}{% endblock %}"/>
	  <meta http-equiv="X-Frame-Options" content="deny">

      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

	  {% block css %}{% endblock %}
	</head>
	<body>
		{% block body %}{% endblock %}
		<header>
			{% if User.isLogin %}
				<div id="panelMembre">
					<div class="section grey darken-4">
						<div class="row container">
							{% include getView('pattern_panelUser') %}
						</div>
					</div>
				</div>
			{% endif %}
			{% block header %}{% endblock %}
		</header>
		
		<nav class="amber darken-1">
			{% block menu %}{% endblock %}
		</nav>
		
		<div>
			{% block container %}{% endblock %}
		</div>

		<footer class="page-footer amber darken-1">
			{% block footer %}{% endblock %}
		</footer>
	</body>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
	{% block js %}{% endblock %}

</html>
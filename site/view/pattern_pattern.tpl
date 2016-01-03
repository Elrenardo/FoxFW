{% block secret %}{% endblock %}
<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>{% block title %}{% endblock %}</title>
	  <meta name="description" content="{% block metaDesc %}FoxFW{% endblock %}" />
	  <meta name="keywords" content="{% block metaKey %}{% endblock %}" />
	  <meta name="author" content="StudioGoupil" />
	  <meta name="robots" content="all" />
	  <link rel="icon" type="image/png" href="{% block favicon %}{% endblock %}"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css" media="screen,projection">

      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>

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
		
		<nav class="teal lighten-2">
			{% block menu %}{% endblock %}
		</nav>
		
		<div>
			{% block container %}{% endblock %}
		</div>

		<footer class="page-footer teal lighten-2">
			{% block footer %}{% endblock %}
		</footer>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	   	{% block js %}{% endblock %}
	</body>
</html>
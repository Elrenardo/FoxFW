{% block secret %}{% endblock %}
<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>{% block title %}{% endblock %}</title>
	  <meta name="description" content="{% block metaDesc %}FoxFW{% endblock %}" />
	  <meta name="keywords" content="{% block metaKey %}{% endblock %}" />
	  <meta name="author" content="Teysseire Guillaume" />
	  <meta name="robots" content="all" />
	  <link rel="icon" type="image/png" href="{% block favicon %}{% endblock %}"/>
	  <meta name="viewport" content="width=device-width, initial-scale=1"/>

	  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
	  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

	  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->

	  {% block head %}{% endblock %}
	</head>
	<body>
		{% block body %}{% endblock %}
		<header class="row container-fluid" >{% block header %}{% endblock %}</header>
		<nav    class="row" >{% block menu %}{% endblock %}</nav>
		
		<div    class="row container-fluid" style="min-height:550px">
			{% block container_body %}{% endblock %}
		</div>

		<footer class="row" >{% block footer %}{% endblock %}</footer>
	</body>
</html>
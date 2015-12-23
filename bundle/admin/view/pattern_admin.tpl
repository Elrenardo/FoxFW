<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>Administration</title>
	  <meta name="description" content="Admin FoxFW" />
	  <meta name="author" content="Teysseire Guillaume" />
	  <meta name="robots" content="all" />
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

      <link rel="stylesheet" href="{{ bundlePath('admin#admin.css') }}"/>

      {% block head_base %}{% endblock %}
	</head>
	<body>
		<header>
			<div id="header1"><b>Administration</b></div>
			<div id="header2">
				<a href="{{ router('index') }}" class="btn btn-primary" target="_blanck">Voir site</a>
				<a href="{{ router('user_deco') }}" class="btn btn-warning" >Deconnexion</a>
			</div>
		</header>
		<hr/>

		<nav class="col-xs-3 col-md-3" >
			{{ controller("Controller_PanelAdmin#viewMenu") }}
		</nav>

		<div class="col-xs-9 col-sm-9 col-md-9 col-xs-9" >
			<div class="panel panel-primary">
				 <div class="panel-heading">Configuration:</div>
				 <div class="panel-body">
				    {% block container %}{% endblock %}
				 </div>
			</div>
		</div>


	</body>
</html>
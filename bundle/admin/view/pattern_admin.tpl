<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>Administration</title>
	  <meta name="description" content="Admin FoxFW" />
	  <meta name="author" content="Teysseire Guillaume" />
	  <meta name="robots" content="all" />
	  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">

      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

      <link rel="stylesheet" href="{{ bundlePath('admin#admin.css') }}"/>

      {% block head_base %}{% endblock %}
	</head>
	<body>

		<ul id="nav-mobile" class="side-nav fixed" style="width:240px;">
				<li class="center red darken-1" style="color:#FFF;">
					Menu
				</li>
				{{ controller("Controller_PanelAdmin#viewMenu") }}
		</ul>

		<header>
		<nav class="top-nav red darken-3">
			<div>
				<div class="nav-wrapper">

					<a href="#" data-activates="nav-mobile" class="button-collapse top-nav full hide-on-large-only" style="margin-left:10px;">
						<i class="mdi-navigation-menu"></i>
					</a>

					<span class="hide-on-med-and-down" style="padding-left:10px;">
						Bienvenue: <b style="padding-left:5px;">{{ User.email }}</b>.
					</span>

					<ul class="right hide-on-med-and-down">
				        <li><a href="{{ router('index') }}">Voir le site</a></li>
				        <li><a href="{{ router('user_deco') }}">Déconnexion</a></li>
				      </ul>
				</div>
			</div>
		</nav>
		</header>

		<main ><br/>
			{% block container %}{% endblock %}
		</main>
	</body>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
	<script>	
	// Plugin initialization
    $('.carousel.carousel-slider').carousel({full_width: true});
    $('.carousel').carousel();
    $('.slider').slider({full_width: true});
    $('.parallax').parallax();
    $('.modal-trigger').leanModal();
    $('.scrollspy').scrollSpy();
    $('.button-collapse').sideNav({'edge': 'left'});
    $('.datepicker').pickadate({selectYears: 20});
    $('select').not('.disabled').material_select();
	</script>
	{% block js %}{% endblock%}
</html>
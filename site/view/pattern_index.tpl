{% extends getView('pattern_pattern') %}


{% block title %}FoxFW Titre{% endblock %}


{% block metaDesc %}
	Description du site
{% endblock %}


{% block metaKey %}tag site{% endblock %}


{% block favicon %}{{ path('web/img/design/favicon.png') }}{% endblock %}


{% block head %}
	<link rel="stylesheet" media="screen and (min-width: 1100px)" href="{{ bundlePath('MasterBundle#design.css') }}" />
	<link rel="stylesheet" media="screen and (min-width: 1100px)" href="{{ bundlePath('MasterBundle#panel.css') }}" />
	<script type="text/javascript" src="{{ bundlePath('MasterBundle#js.js') }}"></script>

	<link rel="stylesheet" media="screen and (max-width: 1099px)" href="{{ bundlePath('MasterBundle#mobile_default.css') }}" />
	<link rel="stylesheet" media="screen and (max-width: 1099px)" href="{{ bundlePath('MasterBundle#mobile.css') }}" />
	
	<link rel="stylesheet" href="{{ bundlePath('MasterBundle#body.css') }}"/>

	<!--
	//Facebook 
	<meta property="og:image" content="">
	<meta property="og:image:type" content="image/png">
	<meta property="og:image:width" content="447">
	<meta property="og:image:height" content="200">-->

	<!-- Header supplémentaire -->
	{% block head_base %}{% endblock %}
{% endblock %}


{% block header %}
	{% include getView('pattern_header') %}
{% endblock %}


{% block menu %}
	{% include getView('pattern_menu') %}
	{% include getView('pattern_menu_mobile') %}
{% endblock %}



{% block container_body %}
	<div id="body" class="container-fluid" >		
		{% block container %}
		{% endblock %}
	</div>
{% endblock %}



{% block footer %}
		{% include getView('pattern_footer') %}
{% endblock %}
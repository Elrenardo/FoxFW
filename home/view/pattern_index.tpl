{% extends getView('pattern_pattern') %}


{% block title %}FoxFW Titre{% endblock %}


{% block metaDesc %}
	Description du site
{% endblock %}


{% block metaKey %}tag site{% endblock %}


{% block favicon %}{{ path('web/img/design/favicon.png') }}{% endblock %}


{% block css %}
	<link rel="stylesheet" href="{{ bundlePath('MasterBundle#design.css') }}"/>

	<!--
	//Facebook 
	<meta property="og:image" content="">
	<meta property="og:image:type" content="image/png">
	<meta property="og:image:width" content="447">
	<meta property="og:image:height" content="200">-->
{% endblock %}

{% block js %}
	<script type="text/javascript" src="{{ bundlePath('MasterBundle#js.js') }}"></script>
{% endblock %}


{% block header %}
	{% include getView('pattern_header') %}
{% endblock %}


{% block menu %}
	{% include getView('pattern_menu') %}
{% endblock %}


{% block footer %}
		{% include getView('pattern_footer') %}
{% endblock %}
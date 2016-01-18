{% extends getView('pattern_index') %}

{% block title %}{{page.titre}} - {{ parent() }}{% endblock %}

{% block metaKey %}{{page.tag}}{{ parent() }}{% endblock %}


{% block container %}

<div class="parallax-container hide-on-small-only">
	<div class="section no-pad-bot">
      <div class="parallax">
      	<img src="{{ path('home/web/img/fete_a_theme_3.jpg') }}" alt="image parallax">
      </div>
    </div>
</div>

<div class="container">
<div class="section">
<div class="row" id="page_index">
	
	<img src="{{ path('home/web/img/design/bouteille_fete.png') }}" alt="bouteille fête" id="logo_bouteille_fete" class="hide-on-small-only hide-on-med-and-down"/>
	
	<img src="{{ path('home/web/img/design/tache.png') }}" alt="tache fête" id="tache_bouteille_fete" class="hide-on-small-only hide-on-med-and-down"/>
	
	<div>
		{{page.body|raw}}
	</div>

</div>
</div>
</div>

{% endblock %}

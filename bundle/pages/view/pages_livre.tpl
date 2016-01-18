{% extends getView('pattern_index') %}

{% block title %}{{page.titre}} - {{ parent() }}{% endblock %}

{% block metaKey %}{{page.tag}}{{ parent() }}{% endblock %}


{% block container %}
<div class="container">
<div class="section">
<div class="row">

	{% if page.img is not empty %}
	<div class="row">
        	<img src="{{ path( page.img ) }}" alt="{{page.tag}}" class="responsive-img materialboxed" />
    </div>
    <br/>
	{% endif %}

	<div>{{page.body|raw}}</div>
	<br/>

</div>
</div>
</div>

<div class="divider"></div>

<div class="blue-grey lighten-5">
<div class="container">
<div class="section">
<div class="row">
	{% for i,key in files %}
		<div class="row col s12 m10 offset-m1">
			{% set ext = getExtension( key ) %}
			{% if ext=="jpg" or ext=="jpeg" or ext=="png" or ext=="gif" or ext=="bmp" %}	
				<img src="{{ path(key) }}" class="materialboxed responsive-img" alt="{{ path(key) }}"/>
			{% else %}
				<div class="card blue-grey darken-1">
					<div class="card-content white-text">
						<span class="card-title">
							<i class="tiny material-icons">perm_media</i> {{ getNameFile(key) }}
						</span>
					</div>
					<div class="card-action">
						<a href="{{ path(key) }}" target="_blank">Télécharger</a>
					</div>
				</div>
			{% endif %}
		</div>

	{% endfor %}
</div>
</div>
</div>
</div>

{% endblock %}

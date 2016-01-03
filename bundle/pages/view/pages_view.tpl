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

	<h4>{{ page.titre }}</h4>
	<div class="flow-text">{{page.body|raw}}</div>
	<br/>

	<div class="row">
		<div id="partage" style="float:right;">
			<div style="float:left;margin:10px;">
				<div id="fb-root"></div>
				<script type="text/javascript">(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&appId=567232026698455&version=v2.0";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>

				<div class="fb-like" data-href="{{ router('index') }}" data-layout="box_count" data-action="like" data-show-faces="true" data-share="true"></div>
			</div>

			<div style="float:left;margin:10px;">
				<script src="https://apis.google.com/js/plusone.js"></script>
			</div>

			<div style="float:left;margin:10px;">
				<script type="text/javascript" src="http://platform.linkedin.com/in.js"></script>
				<script type="in/share" data-counter="top"></script>
			</div>

			<div style="float:left;margin:10px;">
				<a href="https://twitter.com/share" class="twitter-share-button" data-lang="fr" data-hashtags="{{page.titre}}">Tweeter</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			</div>
		</div>

		<div style="float:left;">
			 <i class="tiny material-icons">query_builder</i> {{page.date|date("d/m/Y")}}
		</div>
	</div>

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

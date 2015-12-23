{% for i in liste %}
	<div class="article col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="img-thumbnail">
			<div>
				<h3 class="article_titre"><a href="{{ router('Page_viewPage', i.url) }}">{{ i.titre|capitalize }}</a></h3>
				<hr/>
				<div class="article_text" >{{ i.body|raw }}</div>
			</div>
		</div>
	</div>
{% endfor %}
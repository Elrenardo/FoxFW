{% extends getView('pattern_admin') %}

{% block title %}Edition Carousel - {{ parent() }}{% endblock %}

{% block container %}
	<div>
		<h3>Rajouter / enlever des images aux carousel</h3>
		<br/>
		<div>
			{{ controller("Upload_files#viewEdit", path ) }}
		</div>
		<hr/>
		<a class="btn btn-default" href="{{ router('carousel_add') }}" style="float:right;">Ajouter Images</a>
	</div>
{% endblock %}

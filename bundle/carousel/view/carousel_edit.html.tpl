{% extends getView('pattern_admin') %}

{% block title %}Edition Carousel - {{ parent() }}{% endblock %}

{% block container %}
<div class="section">
	<div class="container">
		<p class="flow-text">Rajouter / enlever des images aux carousel</p>
	</div>
</div>

<div class="section">
	<div>
		{{ controller("Upload_files#viewEdit", path ) }}
	</div>
	<div class="container" >
		<a class="btn btn-default right" href="{{ router('carousel_add') }}">Ajouter Images</a><br/>
		<br/>
	</div>
</div>
{% endblock %}

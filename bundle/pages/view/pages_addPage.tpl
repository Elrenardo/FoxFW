{% extends getView('pattern_admin') %}

{% block title %}Bienvenu sur {{ parent() }}{% endblock %}

{% block head_base %}
	<script src="//cdn.ckeditor.com/4.4.7/full/ckeditor.js"></script>
{% endblock %}

{% block container %}
	<script language="javascript">
		var change = false;

		$("body").keypress(function(e)
		{
        	change = true;
    	});

		//Avant la fermeture de la page on appelle notre fonction closeIt
		window.onbeforeunload = function(e)
		{
			if( change )
				return 'Attention mosdification non enregistre !';
		}
	</script>

	<div>

		{% if data is empty %}
			{% set page_router = "Page_confirmaddPage" %}
			{% set titre       = "Ajouter !" %}
			{% set submit      = "Créer la page" %}
		{% else %}
			{% set page_router = "Page_confirmUpdatePage" %}
			{% set titre       = "Modifier !" %}
			{% set submit      = "Modifier Page" %}
		{% endif %}

		<div class="info">
			{% if msg is not empty %}
				<div>{{ msg|upper }}</div>
			{% endif %}
			<h3 style="text-align:center;color:red;">{{ titre }}</h3>
		</div>

		<form method="POST" action="{{ router( page_router ) }}" enctype="multipart/form-data">

		<div class="form-group">
			<b>Id Page:</b><br/>
			<input type="text" class="form-control" name="id" class="form-control" value="{{ data.id }}" style="width:100%;">
		</div>

		<div class="form-group">
			<b>Cache Page:</b><br/>
			<input type="text" class="form-control" name="path" class="form-control" value="web/page/" style="width:100%;">
		</div>

		<div class="form-group">
			<b>Type de Page:</b><br/>
			<select type="text" class="form-control" name="type" class="form-control" value="{{ data.type }}{{ type }}" style="width:100%;">
				  <option value="Page">Page</option> 
				  <option value="Article">Article</option>
  			</select>
		</div>

		<div class="form-group">
			<b>Template de la page:</b><br/>
			<input type="text" class="form-control" name="twig" class="form-control" value="{{ getView('pages_page') }}" style="width:100%;">
		</div>

		{% if data is not empty %}
			<div class="form-group">
				<b>Path:</b><br/>
				<input type="text" 
				class="form-control" style="width:100%;" name="auteur" 
				value="{{ data.url }}" disabled="disabled">
			</div>
			<hr/>
		{% endif%}
		
		<div class="form-group">
			<b>Titre:</b><br/>
			<input type="text" class="form-control" style="width:100%;" name="titre" value="{{ data.titre }}" 
			placeholder="Titre de l'article" required>
		</div>
		<hr/>

		<div class="form-group">
			<b>Mot clef:</b><br/>
			( Description de l'article qu'avec des mots importants, nom menu/sous-menu / etc ... )<br/>
			<input type="text" class="form-control" style="width:100%;" name="tag" value="{{ data.tag }}" 
			placeholder="Mots clef de l'article séparé par un espace" required>
		</div>
		<hr/>

		{% if data is empty %}
			<div class="form-group" style="display:none;">
				<b>Auteur:</b><br/>
				<input type="text" class="form-control" style="width:100%;" name="auteur" value="{{ User.getEmail() }}">
			</div>
			<hr/>
		{% endif %}

		<div class="form-group">
			<b>Image:</b><br/>
			<input type="hidden" name="MAX_FILE_SIZE" value="999000" />
			<input type="file" style="width:100%;" name="img">
			{% if data.img is not empty %}
				<img src="{{ path(data.img) }}" alt="view image" width="300" class="img-thumbnail" />
			{% endif %}
		</div>
		<hr/>

		<div class="form-group">
			<b>Body:</b><br/>
			<textarea id="texte" name="body">{{ data.body }}</textarea>
			<script>
            	CKEDITOR.replace( 'texte' );
        	</script>
		</div>

		{{ securityForm() }}

		<input type="submit" value="{{ submit }}" class="btn btn-default" style="float:right;"/>
		<span style="clear:both;"></span>
		<br/><br/><br/>
	</form>
	
	<div class="form-group">
		<h3><b>Pièces Jointes:</b></h3>
		{% if data is empty %}
			{{ controller("Upload_files#view") }}
		{% else %}
			{{ controller("Upload_files#viewEdit", 'web/page/'~data.url~'/' ) }}
		{% endif %}
	</div>

	</div>
{% endblock %}
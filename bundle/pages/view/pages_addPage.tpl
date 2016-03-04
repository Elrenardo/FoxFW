{% extends getView('pattern_admin') %}

{% block title %}Bienvenu sur {{ parent() }}{% endblock %}

{% block head_base %}
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	<script>tinymce.init(
	{ 
		selector:'textarea',
		height: 500,
		plugins: [
	    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
	    'searchreplace wordcount visualblocks visualchars code fullscreen',
	    'insertdatetime media nonbreaking save table contextmenu directionality',
	    'emoticons template paste textcolor colorpicker textpattern imagetools'
	  ]
	}
	);</script>
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

		{% if data is empty %}
			{% set page_router = "Page_confirmaddPage" %}
		{% else %}
			{% set page_router = "Page_confirmUpdatePage" %}
		{% endif %}

	<form method="POST" action="{{ router( page_router ) }}" enctype="multipart/form-data">
		{{ securityForm() }}
		<div class="container">
			<input type="hidden" name="id" value="{{ data.id }}" class="validate">
			<input type="hidden" name="type" value="{% if data.twig is not empty %}{{ data.type }}{% else %}Page{% endif %}"/>
			<input type="hidden" name="auteur" value="{{ User.getEmail() }}">

			<p class="flow-text">Ajouter / Modifier une page</p>

			<div class="row">
				<div class="input-field col s12">
		          <i class="material-icons prefix">label</i>
		          <input id="titre" type="text" name="titre" value="{{ data.titre }}" class="validate">
		          <label for="titre">Titre de la page</label>
		        </div>
			</div>

			<div class="row">
				<div class="input-field col s12">
		          <i class="material-icons prefix">search</i>
		          <input id="tag" type="text" name="tag" value="{{ data.tag }}" class="validate">
		          <label for="tag">Mot clef séparé par un espace !</label>
		        </div>
			</div>

			<div class="row">
				<div class="input-field col s12">
		          <i class="material-icons prefix">dashboard</i>
		          <input id="twig" type="text" name="twig" 
		          value="{% if data.twig is not empty %}{{ data.twig }}{% else %}pages_view{% endif %}" class="validate">
		          <label for="twig">Model de page utilisé</label>
		        </div>
			</div>

			<div class="row">
				<textarea id="texte" name="body" rows="80">{{ data.body }}</textarea>
			</div>

			<div class="row right">
				 <button class="btn waves-effect waves-light amber darken-1" type="submit" name="action">Envoyer
    				<i class="material-icons right">send</i>
 				 </button>
			</div>
		</div>

	</form>
	<div style="clear:both;padding-top:30px;"></div>
	<div class="divider"></div>
	{% if data is empty %}
		{{ controller("Upload_files#view") }}
	{% else %}
		{{ controller("Upload_files#viewEdit", getDefine('_WEB')~'page/'~data.url~'/' ) }}
	{% endif %}

{% endblock %}
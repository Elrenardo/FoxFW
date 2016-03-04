{% extends getView('pattern_admin') %}

{% block title %}Document {{ parent() }}{% endblock %}

{% block head_base %}
	<link rel="stylesheet" href="{{ path('vendor/codemirror-5.5/lib/codemirror.css') }}">
	<script src="{{ path('vendor/codemirror-5.5/lib/codemirror.js') }}"></script>


	<link rel="stylesheet" href="{{ path('vendor/codemirror-5.5/theme/monokai.css') }}">
	<script src="{{ path('vendor/codemirror-5.5/keymap/sublime.js') }}"></script>

	<script src="{{ path('vendor/codemirror-5.5/mode/xml/xml.js') }}"></script>
	<script src="{{ path('vendor/codemirror-5.5/mode/css/css.js') }}"></script>
	<script src="{{ path('vendor/codemirror-5.5/mode/php/php.js') }}"></script>
	<script src="{{ path('vendor/codemirror-5.5/mode/javascript/javascript.js') }}"></script>
	<script src="{{ path('vendor/codemirror-5.5/mode/htmlmixed/htmlmixed.js') }}"></script>
	<script src="{{ path('vendor/codemirror-5.5/addon/edit/matchbrackets.js') }}"></script>

	<script src="{{ path('vendor/codemirror-5.5/addon/display/fullscreen.js') }}"></script>
	<link rel="stylesheet" href="{{ path('vendor/codemirror-5.5/addon/display/fullscreen.css') }}">

	<script src="{{ bundlePath('upload_files#dropzone.js') }}"></script>
	<link rel="stylesheet" href="{{ bundlePath('upload_files#dropzone.css') }}">
{% endblock %}

{% block container %}
<div class="container">
	<b style="color:red;" class="right">{{ path }}</b>
	<p class="flow-text">Gestion des documents</p>

<a class="btn btn-default amber" style="min-width:50px;" id="add_dir">Ajouter Dossier</a>
<a class="btn btn-default amber" style="min-width:50px;" id="remove_dir">Supprimer Dossier courant</a>
</hr>

<div class="row">
	<ul class="collection col s3">
		{% for i in dir %}
			<a href="{{ router('Document_view') }}?dir={{ i }}" class="collection-item">
			<li>{{ i }}</li>
			</a>
		{% endfor %}
	</ul>

	<script type="text/javascript">
		$('#add_dir').click(function()
		{
		var name_dir = prompt("Nom du nouveau dossier ?", "Nouveau_dossier");
		var url = "{{router('Document_addDir')}}" + "?name=" + name_dir;
		window.location.replace( url );
		});

		$('#remove_dir').click(function()
		{
		if (confirm("Supprimer le dossier courant ?"))
		    window.location.replace( "{{router('Document_removeDir')}}" );
		});
	</script>


	<div class="col s9" >
		<!-- View Document -->
		{% if rep == true %}
			<table>
				{% for i in file %}
					<tr>
						<td>
							<a href="{{ router('Document_view') }}?file={{ path~i }}">
								<img src="{{ path( path~i ) }}" style="float:left;" alt="" height="64"/>
							</a>
						</td>
						<td>
							<a href="{{ router('Document_view') }}?file={{ path~i }}">
								<span class="glyphicon glyphicon-file" aria-hidden="true"></span> {{ i }}
							</a>
							<div class="form-group">
							<b>Url du fichier:</b>
								<input type="text" style="width:100%;text-align:center;"  value="{{ path(path~i) }}"  onClick="this.select();"/>
							</div>
						</td>
					</tr>
				{% endfor %}
			</table>
		{% else %}

		<div>
			<b>Url du fichier:</b>
			<input type="text" style="width:100%;text-align:center;"  value="{{ document.url }}" onClick="this.select();"/>
		</div>
		{% set type_ok = false %}

		{% if (document.type =='png') or 
		(document.type =='jpg')  or 
		(document.type =='jpeg') or 
		(document.type =='bmp')  or 
		(document.type =='gif') %}
		{% set type_ok = true %}
			<img src="{{ document.url }}" alt="{{ document.fichier }}" class="responsive-img" />
		{% endif %}

		<!-- Editeur de fichier -->
		{% if (document.type =='txt') or 
		(document.type =='html')  or 
		(document.type =='css') or 
		(document.type =='js')  or 
		(document.type =='tpl') or 
		(document.type =='json') or 
		(document.type =='php') %}
		{% set type_ok = true %}
			{% include getView('Document_editFile') %}
		{% endif %}



		<!-- Si on a pas trouvé de lecteur pour le document -->
		{% if type_ok == false %}
		<hr/>
		<h3 style="text-align:center;">Auncun apercu disponible pour les fichiers: {{ document.type }}</h3>
		{% endif %}

		<!-- Action global sur le fichier en cours de lecture ( telecharger / supprimer ) -->
		<div style="float:right;margin-bottom:30px;margin-top:30px;">
			<a class="btn btn-default" target="_blank" href="{{ document.url }}">Télécharger</a>
			{% if document.edit == true %}
				<a class="btn btn-default" id="del_file" href="#" >Supprimer</a>
			{% endif %}
			<script type="text/javascript">
				$('#del_file').click(function()
				{
					if(confirm("Supprimer le fichier ?"))
					window.location.replace( "{{router('Document_removeFile')}}?name={{ document.fichier }}" );
				});
			</script>
		</div>
		{% endif %}
	
	</div>
	<!-- UPLOAD DANS LE DOSSIER -->
	{% if rep == true %}
	<div style="margin-top:30px;margin-bottom:30px;"><legend>Ajouter un document:</legend>
	<form action="{{ router('Document_upload') }}" class="dropzone"></form>

	</div>
	{% endif %}
</div>
</div>

<style type="text/css">
	#repertoire
	{
		margin-bottom: 30px;
	}
	#vue
	{
		height:100%;
	}
	#liste_rep input
	{
		display:block;
		width:100%;
		margin:5px;
	}
</style>
{% endblock %}
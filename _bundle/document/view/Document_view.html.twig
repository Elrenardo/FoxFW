{% extends getView('pattern_index') %}

{% block title %}Document {{ parent() }}{% endblock %}

{% block head_base %}
	<script src="{{ path('_vendor/codemirror-5.5/lib/codemirror.js') }}"></script>
	<script src="{{ path('_vendor/codemirror-5.5/mode/xml/xml.js') }}"></script>
	<script src="{{ path('_vendor/codemirror-5.5/mode/javascript/javascript.js') }}"></script>
	<script src="{{ path('_vendor/codemirror-5.5/mode/htmlmixed/htmlmixed.js') }}"></script>
	<script src="{{ path('_vendor/codemirror-5.5/addon/edit/matchbrackets.js') }}"></script>

	<link rel="stylesheet" href="{{ path('_vendor/codemirror-5.5/lib/codemirror.css') }}">

	<script src="{{ path('_vendor/dropZone/dropzone.js') }}"></script>
	<link rel="stylesheet" href="{{ path('_vendor/dropZone/dropzone.css') }}">
{% endblock %}

{% block container %}
	<div class="container">
		<ol class="breadcrumb fil_ariane img-thumbnail">
		  <li><a href="{{ router('index') }}">Accueil</a></li>
		  <li><b style="color:red;">{{ path }}</b></li>
		  <li class="active">Explorateur Fichier</li>
		</ol>

		<div id="repertoire" class="col-md-2 col-lg-2">
			<h3 style="text-align:center;">Dossier</h3>
			<ul style="list-style-type: none;">
				{% for i in dir %}
					<li style="margin-bottom:5px;">
						<a href="{{ router('Document_view') }}?dir={{ i }}" class="btn btn-primary" style="width:100%">{{ i }}</a>
					</li>
				{% endfor %}
			</ul>
			<hr/>
			<a class="btn btn-default" style="width:100%" id="add_dir">Ajouter Dossier</a>
			<a class="btn btn-default" style="width:100%" id="remove_dir">Supprimer Dossier</a>

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
		</div>


		<div id="vue" class="col-md-10 col-lg-10">

			<!-- View Document -->
			{% if rep == true %}
				<h3 style="text-align:center;">Fichiers</h3>
				<table style="width:100%;" class="table table-striped">
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
									<input type="text" style="width:100%;text-align:center;"  value="{{ path(path~i) }}" class="form-control" onClick="this.select();"/>
								</div>
							</td>
						</tr>
					{% endfor %}
				</table>
			{% else %}

				<div class="form-group">
					<b>Url du fichier:</b>
					<input type="text" style="width:100%;text-align:center;"  value="{{ document.url }}" class="form-control" onClick="this.select();"/>
				</div>
				{% set type_ok = false %}

				{% if (document.type =='png') or 
				(document.type =='jpg')  or 
				(document.type =='jpeg') or 
				(document.type =='bmp')  or 
				(document.type =='gif') %}
					{% set type_ok = true %}
					<img src="{{ document.url }}" alt="{{ document.fichier }}" class="img-thumbnail" />
				{% endif %}

				<!-- Editeur de fichier -->
				{% if (document.type =='txt') or 
				(document.type =='html')  or 
				(document.type =='css') or 
				(document.type =='js')  or 
				(document.type =='twig') or 
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

			<!-- UPLOAD DANS LE DOSSIER -->
			{% if rep == true %}
				<fieldset style="margin-top:30px;margin-bottom:30px;"><legend>Ajouter un document:</legend>
					<!--<form method="POST" action="{{ router('Document_upload') }}" style="float:left;" >
						{{ securityForm() }}
						<div class="form-group">
							<b>Ajouter un document:</b><br/>
							<input type="hidden" name="MAX_FILE_SIZE" value="999000" />
							<input type="file" style="width:100%;" name="img">
							<br/>
							<input type="submit" value="Envoyer le fichier" class="btn btn-default"/>
						</div>
					</form>-->

					<form action="{{ router('Document_upload') }}" class="dropzone"></form>

				</fieldset>
			{% endif %}

		</div>
	</div>
	<style type="text/css">
		#repertoire
		{
			height:100%;
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
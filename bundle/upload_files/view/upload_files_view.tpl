<div id="upload_file" class="row">
	<script src="{{ bundlePath('upload_files#dropzone.js') }}"></script>
	<link rel="stylesheet" href="{{ bundlePath('upload_files#dropzone.css') }}">
	
	<div class="container">
	{% set compte = 0 %}
	{% if path_dir is not empty %}
		<table class="highlight striped bordered col s5">
			<caption><h5>Attacher</h5></caption>

			{% for i,key in path_dir %}
			<tr id="upload_files_liste{{ compte }}" style="height:120px;">
				<td>
					<img src="{{ path(key) }}" alt="prevu img" width="64" height="64" style="margin-right:30px;"/>
				</td>
				<td>
					<a href="{{ path(key) }}" target="_blank">{{ i[:20] }}</a>
					<input type="text" style="width:100%;text-align:center;"  value="{{ path(path~i) }}" class="form-control" onClick="this.select();"/>
				</td>
				<td>
					<div onClick="remove_elem_buffer( {{ compte }}, '{{ router('Upload_files_remove', key ) }}' )">
						<i class="small material-icons" style="color:red;margin-left:30px;cursor: pointer;">delete</i>
					</div>
				</td>
			</tr>
			{% set compte = compte +1 %}
			{% endfor %}
		</table>

		<table class="highlight striped bordered col s5" style="margin-left:20px;">
			<caption><h5> En attente ...</h5></caption>

			{% for i,key in upload_buffer %}
			<tr id="upload_files_liste{{ compte }}" style="height:120px;">
				<td>
					<img src="{{ path(key) }}" alt="prevu img" width="64" height="64" style="margin-right:30px;"/>
				</td>
				<td>
					<a href="{{ path(key) }}" target="_blank">{{ i[:20] }}</a>
				</td>
				<td>
					<div onClick="remove_elem_buffer( {{ compte }}, '{{ router('Upload_files_removeBuffer', i ) }}' )">
						<i class="small material-icons" aria-hidden="true" style="color:red;margin-left:30px;cursor: pointer;">delete</i>
					</div>
				</td>
			</tr>
			{% set compte = compte +1 %}
			{% endfor %}
		</table>
	{% endif %}
</div>
	
	<div class="row" style="clear:both;">
		<br/>
		<div class="section amber darken-1">
			<div class="container">
				<p>Taille maximum fichier: {{ max_upload_file }}</p>
				<form action="{{ router('Upload_files_upload') }}" class="dropzone"></form>
			</div>
		</div>
		<div class="divider"></div>
	</div>

	<script>
		function remove_elem_buffer( id, path )
		{
			$.ajax({
			  "url": path
			}).done(function(){
				$("#upload_files_liste"+id).remove();
			});
		}
	</script>
</div>
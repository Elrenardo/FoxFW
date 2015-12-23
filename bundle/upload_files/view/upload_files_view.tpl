<div id="upload_file">
	<script src="{{ bundlePath('upload_files#dropzone.js') }}"></script>
	<link rel="stylesheet" href="{{ bundlePath('upload_files#dropzone.css') }}">
	{% set compte = 0 %}
	{% if path_dir is not empty %}
		<table class="table table-striped">
			<caption><h3>Attacher</h3></caption>
			{% for i,key in path_dir %}
			<tr id="upload_files_liste{{ compte }}">
				<td><img src="{{ path(key) }}" alt="prevu img" width="64" height="64" style="margin-right:30px;"/></td>
				<td><a href="{{ path(key) }}" target="_blank">{{ i }}</a></td>
				<td>
					<div onClick="remove_elem_buffer( {{ compte }}, '{{ router('Upload_files_remove', key ) }}' )">
						<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;margin-left:30px;cursor: pointer;"></span>
					</div>
				</td>
			</tr>
			{% set compte = compte +1 %}
			{% endfor %}
		</table>
	{% endif %}

	<form action="{{ router('Upload_files_upload') }}" class="dropzone"></form>
	<div>
		<table class="table table-striped">
			<caption><h3> En attente ...</h3></caption>
			{% for i,key in upload_buffer %}
			<tr id="upload_files_liste{{ compte }}">
				<td><img src="{{ path(key) }}" alt="prevu img" width="64" height="64" style="margin-right:30px;"/></td>
				<td><a href="{{ path(key) }}" target="_blank">{{ i }}</a></td>
				<td>
					<div onClick="remove_elem_buffer( {{ compte }}, '{{ router('Upload_files_removeBuffer', i ) }}' )">
						<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;margin-left:30px;cursor: pointer;"></span>
					</div>
				</td>
			</tr>
			{% set compte = compte +1 %}
			{% endfor %}
		</table>
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
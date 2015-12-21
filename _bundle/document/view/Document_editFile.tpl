<div class="container" style="margin-bottom:50px;">

	<form method="POST" action="{{ router('Document_confirmEditFile') }}" >
		{{ securityForm() }}
		<div class="form-group">
			<b>Contenu du fichier:</b><br/>
			<textarea wrap="off" name="body" id="code">{{ document.body }}</textarea>
			<input type="hidden" name="file" value="{{ document.path }}" />
		</div>
		<hr/>
		<input type="submit" value="Modifier le fichier" class="btn btn-default"/>
	</form>
</div>

<script type="text/javascript">
    var textarea = document.getElementById('code');
    var editor = CodeMirror.fromTextArea( textarea, {
    lineNumbers: true
  	});
  	editor.setSize('85%', '100%');
</script>
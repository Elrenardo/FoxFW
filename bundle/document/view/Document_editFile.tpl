<form method="POST" action="{{ router('Document_confirmEditFile') }}" >
	{{ securityForm() }}
	<div>
		<b>Contenu du fichier ( F11 plein écran ):</b><br/>
		<textarea name="body" id="code">{{ document.body }}</textarea>
		<input type="hidden" name="file" value="{{ document.path }}" />
	</div><br/>
	<input type="submit" value="Modifier le fichier" class="btn btn-default"/>
</form>

<script type="text/javascript">
    var textarea = document.getElementById('code');
    var editor = CodeMirror.fromTextArea( textarea,
    {
	    lineNumbers: true,
	    mode: "javascript",
	    keyMap: "sublime",
	    autoCloseBrackets: true,
	    matchBrackets: true,
	    showCursorWhenSelecting: true,
	    theme: "monokai",
	    tabSize: 2,
	    extraKeys:
	    {
	        "F11": function(cm) {
	          cm.setOption("fullScreen", !cm.getOption("fullScreen"));
	        },
	        "Esc": function(cm) {
	          if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
	        }
      	}
  	});
  	editor.setSize('100%', '100%');
</script>
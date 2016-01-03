<li>
	<a href="{{ router('Page_viewListeAdminPage') }}">
		<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
		Liste Pages
	</a>
</li>

<li >
	<a href="{{ router('Page_addPage') }}" style="color:green;">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		Ajouter page
	</a>
</li>


<li class="updatePage" style="display:none;">
	<a href="{{ router('Page_removePage', '') }}" style="color:red;" id="delPageMenuAdmin">
		<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		Supprimer
	</a>
</li>


<li class="updatePage" style="display:none;">
	<a href="{{ router('Page_viewUpdatePage', '') }}" style="color:red;">
		<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
		Modifier
	</a>
</li>
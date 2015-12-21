<li>
	<a href="{{ router('Page_viewListePage','Article') }}">
		<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
		Liste Articles
	</a>
</li>

<li>
	<a href="{{ router('Page_viewListePage','Page') }}">
		<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
		Liste Pages
	</a>
</li>

<li>
	<a href="{{ router('Page_addArticle') }}" style="color:green;">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		Ajouter Article
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


<script type="text/javascript">
$('document').ready(function()
{
	//recupéré l'id de la page
	var value = $('#page_data').attr('class');
	if( value == undefined )
		return;
	if( value == '' )
		return;
	value = value.split(" ")[0];
	value = value.split("_")[1];

	if( value != undefined )
	{
		$('.updatePage').css('display','block');
		var lien;
		//update modifier / supprimer
		lien = $('.updatePage:eq(0) a').attr('href');
		$('.updatePage:eq(0) a').attr('href', lien+value );

		lien = $('.updatePage:eq(1) a').attr('href');
		$('.updatePage:eq(1) a').attr('href', lien+value );
	}
	else
		$('.updatePage').css('display','none');


	//bouton info avant de supprimer
	$('#delPageMenuAdmin').click(function()
	{
		if( confirm("Voulez-vous supprimer la page ?"))
			return true;
		return false;
	});
});
</script>
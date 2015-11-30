$(document).ready(function()
{
	//if (document.documentElement.clientWidth < 1100 )
		menu_mobile();
	//else
		menu_site();
});

/*---------------------------*/
/* --- MENU POUR LE SITE --- */
/*---------------------------*/
function menu_site()
{
	var menu_open = undefined;

	//ouvrire le menu
	$('.dm').hover(function(e)
	{
		if( menu_open != undefined )
		{
			$( menu_open ).css('display','none');
			menu_open = undefined;
		}

		//retoruvé l'ID du menu grade a la class ex: menu_0
		var i = $(this).attr('class');
		i = i.split(" ")[0];
		i = i.split("_")[1];

		//verifier si demande fenetre
		if( i == "-1")
		{
			$( menu_open ).css('display','none');
			return;
		}

		var menu = '#panel'+i;
		$( menu ).css('display','block');
		menu_open = menu;

		//fermer le menu
		$( menu ).hover(undefined,
		function(e)
		{
			$( menu ).css('display','none');
		});
	});

	//fermer le menu si ont pass sur le header
	$('header').hover(function(e)
	{
		if( menu_open != undefined )
		{
			$( menu_open ).css('display','none');
			menu_open = undefined;
		}
	});
}


/*---------------------------*/
/* -- MENU POUR LE MOBILE -- */
/*---------------------------*/
function menu_mobile()
{
	var menu_mobile = undefined;
	$('#menu_mobile h2').click(function(e)
	{
		if( menu_mobile != undefined )
			$( menu_mobile ).css('display','none');

		menu_mobile = $(this).parent().find('ul');
		menu_mobile.css('display','block');
	});
}

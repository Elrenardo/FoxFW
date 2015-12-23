<div>
	<div style="float:left;margin-right:10px;">Bienvenu: <b>{{ User.email }}</b></div>
	{% if User.isRole('ADMIN') %}
		<a style="float:left;" href="{{ router('PanelAdmin_view') }}">Administration</a>
	{% endif %}
	<a style="float:right;" href="{{ router('user_deco') }}"><b>Deconnexion</b></a>
</div>
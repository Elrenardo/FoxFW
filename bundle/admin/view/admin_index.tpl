{% extends getView('pattern_admin') %}

{% block container %}
<div class="container">
	<p class="flow-text">Paramétres du site</p>

	<a class="waves-effect waves-light btn amber darken-1" href="{{ router('user_viewListeUsers') }}">
		Comptes et Permissions
	</a><br><br>
	<a class="waves-effect waves-light btn amber darken-1" href="{{ router('PanelAdmin_viewRouter') }}">
		Router</a>
	<br><br>
	<a class="waves-effect waves-light btn amber darken-1" href="{{ router('PanelAdmin_viewMVC') }}">
		M.V.C.
	</a><br><br>
	<a class="waves-effect waves-light btn amber darken-1" href="{{ router('PanelAdmin_viewConfiguration') }}">
		::FoxFW:: et PHPInfo
	</a><br><br>
	<a class="waves-effect waves-light btn amber darken-1" href="{{ router('PanelAdmin_viderCache') }}">
		Vider Cache
	</a><br><br>
</div>
{% endblock %}
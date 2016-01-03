<div class="nav-wrapper container">
	
	<a href="{{ router('index') }}" class="brand-logo" id="titre_logo">::FoxFW::</a>
	<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
	
	<ul class="right hide-on-med-and-down">
		<li><a href="{{ router('') }}">Menu0</a></li>
		<li><a href="{{ router('') }}">Menu1</a></li>
		<li><a href="{{ router('') }}">Menu2</a></li>
		<li><a href="{{ router('user_login') }}">Se connecter</a></li>
	</ul>

	<ul class="side-nav" id="mobile-demo">
		<li><a href="{{ router('') }}">Menu0</a></li>
		<li><a href="{{ router('') }}">Menu1</a></li>
		<li><a href="{{ router('') }}">Menu2</a></li>
		<li><a href="{{ router('user_login') }}">Se connecter</a></li>
	</ul>
</div>
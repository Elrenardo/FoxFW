{% extends getView('pattern_index') %}

{% block title %}Connexion{% endblock %}

{% block container %}
	<div id="login" class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">

			<div class="info">
				<div>
					<h3>Connexion au site</h3>
					lorum ipsum ...<br/>
					{% if msg is not empty %}
						<p>{{ msg|upper }}</p>
					{% endif %}
				</div>
			</div>

		<form method="POST" action="{{ router('user_confirmlogin') }}">
			{{ securityForm() }}
		  <div class="form-group">
		    <label for="email">Adresse Email:</label>
		    <div class="input-group">
    			<span class="input-group-addon">@</span>
		    	<input type="email" class="form-control" id="email" name="email" placeholder="Entrer votre Email" required>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="password">Mot de passe:</label>
		    <div class="input-group">
    			<span class="input-group-addon">●</span>
		    	<input type="password" class="form-control" id="password" name="password" placeholder="Entrer votre mot de passe" required>
		    </div>
		  </div>
		  <div style="height:15px;"/></div>
		  <div class="form-group">
		  	<p style="float:right;"><input type="checkbox" name="reload" value="1"> Rester connecter !</p>
		  	<input style="float:left;" type="submit" class="btn btn-default" value="Connexion">
		  </div>
		  <div style="clear: both;"/></div>
		  <hr/>
		  <a href="{{ router('user_inscription')}}" style="float:left;">Inscription</a>
		  <a href="{{ router('user_passLost') }}" style="float:right;">Mot de passe perdu ?</a>
		  <div style="clear: both;"/></div>
		</form>
	</div>
{% endblock %}
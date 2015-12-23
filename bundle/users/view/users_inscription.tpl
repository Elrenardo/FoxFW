{% extends getView('pattern_index') %}

{% block title %}Inscription{% endblock %}

{% block container %}
	<div id="inscription" class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
		{% if msg is not empty %}
    		<p  style="margin:5px;padding:5px;text-align:center; background-color:#d9534f;color:#fff;border-radius:5px;">{{ msg|upper }}</p>
		{% endif %}
		
		<div class="info" >
			<div>
				<h4>Bienvenu !</h4>
				Inscription au site
			</div>
		</div>

		<form method="POST" action="{{ router('user_confirmInscription') }}">
		  {{ securityForm() }}
		  <div class="form-group">
		    <label for="email">Adresse email:</label>
		    <input type="email" class="form-control" id="email" name="email" placeholder="Entrer votre Email" required>
		  </div>

		   <div class="form-group">
		   		<label for="email">Password:</label>
		   		<input type="password" class="form-control" id="password" name="password" placeholder="Entrer votre mot de passe" required>
		   </div>

		   	<div class="form-group">
		   		<label for="email">Retaper le Password:</label>
		   		<input type="password" class="form-control" id="password2" name="password2" placeholder="Retaper votre mot de passe" required>
		   </div>

		    <div class="form-group blague">
				<label for="blague">
				Vous ne devez pas remplir ce champ *
				</label>
				<input type="text" name="blaque" id="blague" />
			</div>


		  <hr/>
		  <div class="form-group">
		  	<input style="width:200px;float:left;" type="submit" class="btn btn-primary" value="Inscription">
		  	<a href="{{ router('user_login')}}" style="float:right;">Vous avez déjà un compte ?</a>
		  </div>
		</form>
	</div>
{% endblock %}
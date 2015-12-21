{% extends getView('pattern_index') %}

{% block title %}Changer de mot de passe{% endblock %}

{% block container %}
	<div id="newpassword" class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
		{% if msg is not empty %}
    		<p  style="margin:5px;padding:5px;text-align:center; background-color:#d9534f;color:#fff;border-radius:5px;">{{ msg|upper }}</p>
		{% endif %}
		<form method="POST" action="{{ router('user_confirmChangePassword') }}">
			{{ securityForm() }}

		  <div class="form-group">
		    <label for="password">Nouveau mot de passe:</label>
		    <div class="input-group">
    			<span class="input-group-addon">●</span>
		    	<input type="password" class="form-control" id="password" name="password" placeholder="Entrer votre mot de passe" required>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="password">Retaper le nouveau mot de passe:</label>
		    <div class="input-group">
    			<span class="input-group-addon">●</span>
		    	<input type="password" class="form-control" id="passwordR" name="passwordR" placeholder="Entrer votre mot de passe" required>
		    </div>
		  </div>
		  <hr/>
		  <div style="height:15px;"/></div>
		  <div class="form-group">
		  	<input type="submit"  style="float:left;" class="btn btn-default" value="Changer le mot de passe" />
		  	<a href="{{ router('user') }}" style="float:right;">Retour</a>
		  </div>

		</form>
	</div>
{% endblock %}
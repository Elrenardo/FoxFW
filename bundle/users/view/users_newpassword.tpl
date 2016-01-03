{% extends getView('pattern_index') %}

{% block title %}Changer de mot de passe{% endblock %}

{% block container %}
<div class="container">
	<div class="section">
		<div class="row">

			<form method="POST" action="{{ router('user_confirmChangePassword') }}" class="col s10 offset-s1 m8 offset-m2">
				{{ securityForm() }}

				<div class="card blue-grey">
					<div class="card-content white-text">
						<h5 class="card-title">Choissisez un nouveau mot de passe !</h5>
					</div>
				</div>

				{% if msg is not empty %}
				<div class="card  red darken-1">
					<div class="card-content white-text">
						<h5 class="card-title">Erreur ?</h5>
						<p>
							{{ msg|upper }}
						</p>
					</div>
		        </div>
				{% endif %}
				<br/>

				<div class="row">
					<div class="input-field">
						<input id="password" type="password" class="validate" name="password" placeholder="Entrer votre mot de passe" required>
						<label for="email">Mot de passe</label>
					</div>
				</div>
				<br/>

				<div class="row">
					<div class="input-field">
						<input id="passwordR" type="password" class="validate" name="passwordR" placeholder="Entrer votre mot de passe" required>
						<label for="email">Retaper le mot de passe</label>
					</div>
				</div>
				<br/>

				<div class="row">
					<button class="btn waves-effect waves-light" type="submit" name="action">Changer le mot de passe
			    		<i class="material-icons right">send</i>
			  		</button>
				</div>>

			</form>
		</div>
	</div>
</div>
{% endblock %}
{% extends getView('pattern_index') %}

{% block title %}Inscription{% endblock %}

{% block container %}
<div class="container">
	<div class="section">
		<div class="row">
			
			<form method="POST" action="{{ router('user_confirmInscription') }}" class="col s10 offset-s1 m8 offset-m2">
			  {{ securityForm() }}

				<div class="card blue-grey">
					<div class="card-content white-text">
						<h5 class="card-title">Formulaire d'inscription</h5>
						<p>
							Utiliser le formulaire si dessous pour vous créer un compte.
						</p>
					</div>

					<div class="card-action">
						<a href="{{ router('user_login')}}">Vous avez déjà un compte ?</a>
					</div>
				</div>

				{% if msg is not empty %}
				<div class="card  red darken-1">
					<div class="card-content white-text">
						<h5 class="card-title">Erreur d'inscription ?</h5>
						<p>
							{{ msg|upper }}
						</p>
					</div>
		        </div>
				{% endif %}
				<br/>

				<div class="row">
					<div class="input-field">
						<input id="email" type="email" class="validate" id="email" name="email" placeholder="Saisissez votre Email" required>
						<label for="email" data-error="wrong" data-success="right">Adresse Email</label>
					</div>
				</div>
				<br/>

				<div class="row">
					<div class="input-field">
						<input id="password" type="password" class="validate" name="password" placeholder="Saisissez votre mot de passe" required>
						<label for="email">Mot de passe</label>
					</div>
				</div>
				<br/>

				<div class="row">
					<div class="input-field">
						<input id="password2" type="password" class="validate" name="password2" placeholder="Retaper votre mot de passe" required>
						<label for="email">Retaper votre Mot de passe</label>
					</div>
				</div>
				<br/>

			    <div class="blague">
					Vous ne devez pas remplir ce champ *
					<input type="text" name="blaque" id="blague" />
				</div>

			  <div class="row">
				  <button class="btn waves-effect waves-light" type="submit" name="action">Inscription
				    <i class="material-icons right">send</i>
				  </button>
			  </div>
			</form>
		</div>
	</div>
</div>
{% endblock %}
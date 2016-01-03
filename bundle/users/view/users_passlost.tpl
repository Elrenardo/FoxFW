{% extends getView('pattern_index') %}

{% block title %}Compte perdu ?{% endblock %}

{% block container %}
<div class="container">
	<div class="section">
		<div class="row">

			<form method="POST" action="{{ router('user_confirmPassLost') }}" class="col s10 offset-s1 m8 offset-m2">
				{{ securityForm() }}
				
				<div class="card blue-grey">
					<div class="card-content white-text">
						<h5 class="card-title">Retrouver son compte !</h5>
						<p>
							Si vous avez perdu votre mot de passe, entrez votre addresse email dans le champs ci-dessous.<br/>
							Un mail sera envoyé a votre addresse email avec un lien qui vous permettra de changer votre mot de passe !<br/>
							<br/>
							<b>/!\ Il ce peux que votre message tombe dans les SPAMs. Pensez à les vérifier !</b><br/>
							<br/>
							Attention: la durée du lien de réinisialisation de mot de passe est limité dans le temps !
						</p>
					</div>
					<div class="card-action">
		              	<a href="{{ router('user_login')}}">Se connecter ?</a>
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
						<input id="email" type="email" class="validate" id="email" name="email" placeholder="Entrer votre Email" required>
						<label for="email" data-error="wrong" data-success="right">Adresse Email</label>
					</div>
				</div>
				<br/>

				<div class="row">
					<button class="btn waves-effect waves-light" type="submit" name="action">Réinitialisez le mot de passe par email
			    		<i class="material-icons right">send</i>
			  		</button>
				</div>

			</form>
		</div>
	</div>
</div>
{% endblock %}
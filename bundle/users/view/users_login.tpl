{% extends getView('pattern_index') %}

{% block title %}Connexion au site{% endblock %}

{% block container %}
<div class="container">
	<div class="section">
		<div class="row">

			<form method="POST" action="{{ router('user_confirmlogin') }}" class="col s10 offset-s1 m8 offset-m2">
			{{ securityForm() }}

				<div class="card blue-grey">
					<div class="card-content white-text">
						<h5 class="card-title">Connexion</h5>
						<p>
							Utiliser le formulaire si dessous pour vous connecter.
							{% if msg is not empty %}
								</br></br>{{ msg|upper }}
							{% endif %}
						</p>
					</div>
					<div class="card-action">
		              	<a href="{{ router('user_inscription')}}">Inscription</a>
						<a href="{{ router('user_passLost') }}">Mot de passe perdu ?</a>
		            </div>
				</div>
				
				{% if msg is not empty %}
				<div class="card  red darken-1">
					<div class="card-content white-text">
						<h5 class="card-title">Erreur de connexion ?</h5>
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
					<div class="input-field">
						<input id="password" type="password" class="validate" name="password" placeholder="Entrer votre mot de passe" required>
						<label for="email">Mot de passe</label>
					</div>
				</div>
				<br/>

				<div class="row">
					<p style="float:right;">
						 <input type="checkbox" class="filled-in" id="filled-in-box" name="reload" value="1" checked="checked" />
 						 <label for="filled-in-box">Rester connecter !</label>
					</p>

					<button class="btn waves-effect waves-light" type="submit" name="action">Connexion
			    		<i class="material-icons right">send</i>
			  		</button>
				</div>

				<div style="clear: both;"/></div>
			</form>
		</div>
	</div>
</div>
{% endblock %}
{% extends getView('pattern_admin') %}

{% block title %}Bienvenu sur {{ parent() }}{% endblock %}

{% block head_base %}
{% endblock %}

{% block container %}

		{% if data is empty %}
			{% set page_router = "contacts_confirmadd" %}
		{% else %}
			{% set page_router = "contacts_editConfirm" %}
		{% endif %}

	<form method="POST" action="{{ router( page_router ) }}" enctype="multipart/form-data">
		{{ securityForm() }}
		<div class="container">
			<input type="hidden" name="id" value="{{ data.id }}" class="validate">

			<p class="flow-text">Ajouter un nouveau contact</p>
			<div class="row">
				<div class="input-field col s6">
		          <i class="material-icons prefix">label</i>
		          <input id="nom" type="text" name="nom" value="{{ data.nom }}" class="validate">
		          <label for="nom">Nom</label>
		        </div>

				<div class="input-field col s6">
		          <i class="material-icons prefix">perm_identity</i>
		          <input id="prenom" type="text" name="prenom" value="{{ data.prenom }}" class="validate">
		          <label for="prenom">Prenom</label>
		        </div>
			</div>

			<div class="row">
				<div class="input-field col s12">
		          <i class="material-icons prefix">email</i>
		          <input id="email" type="text" name="email" value="{{ data.email }}" class="validate">
		          <label for="email">Email</label>
		        </div>
			</div>

			<div class="row">
				<div class="input-field col s6">
		          <i class="material-icons prefix">perm_phone_msg</i>
		          <input id="telfixe" type="text" name="telfixe" value="{{ data.telfixe }}" class="validate">
		          <label for="telfixe">Téléphone Fixe</label>
		        </div>

				<div class="input-field col s6">
		          <i class="material-icons prefix">perm_phone_msg</i>
		          <input id="telportable" type="text" name="telportable" value="{{ data.telportable }}" class="validate">
		          <label for="telportable">Téléphone Portable</label>
		        </div>
			</div>

			<div class="row">
				<div class="input-field col s12">
		          <i class="material-icons prefix">print</i>
		          <input id="fax" type="text" name="fax" value="{{ data.fax }}" class="validate">
		          <label for="fac">Fax</label>
		        </div>
			</div>
			
			<div class="row">
				<div class="input-field col s6">
		          <i class="material-icons prefix">business</i>
		          <input id="structure" type="text" name="structure" value="{{ data.structure }}" class="validate">
		          <label for="structure">Structure</label>
		        </div>

				<div class="input-field col s6">
		          <i class="material-icons prefix">class</i>
		          <input id="intitule" type="text" name="intitule" value="{{ data.intitule }}" class="validate">
		          <label for="intitule">Poste occupé</label>
		        </div>
			</div>

		</div>
		<!-- CHOIX DU GROUPE -->
		<div class="divider"></div>
		<div class="section grey lighten-4">
		<div class="container">

			<div class="input-field col m10">
				<select id="groupeList" >
					<option value="" disabled selected>Choisissez le groupe ?</option>
					{% for i in groupe %}
						<option value="{{ i }}" {% if data.groupe == i %}selected{% endif %}>{{ i }}</option>
					{% endfor %}
					<option value="_autre">Autre ...</option>
				</select>
				<label for="groupeList">Choisissez un groupe pour le contact</label>
			</div>
			<script>
				$(document).ready(function()
				{
					$('#groupeList').change(function()
					{
						var val = $('#groupeList').val();

						if( val == '_autre')
							$('#groupeAutre').css('display','block');
						else
						{
							$('#groupe').attr('value', val );
							$('#groupeAutre').css('display','none');
						}
					});
				});
			</script>

			<div class="row" id="groupeAutre" style="display:none;">
				<div class="input-field col s12">
		          <i class="material-icons prefix">library_books</i>
		          <input id="groupe" type="text" name="groupe" value="{{ data.groupe }}" class="validate">
		          <label for="groupe">Saisissez le nom du nouveau groupe</label>
		        </div>
			</div>

		</div>
		</div>
		<div class="divider"></div>
		<!-- FIN CHOIX DU GROUPE -->

		<div class="container">
			<div class="row">
				<div class="input-field col s12">
					<textarea id="commentaire" name="commentaire" class="materialize-textarea">{{ data.commentaire }}</textarea>
					<label for="commentaire">Commentaires</label>
				</div>
			</div>

			<div class="row right">
				 <button class="btn waves-effect waves-light amber darken-1" type="submit">Envoyer
    				<i class="material-icons right">send</i>
 				 </button>
			</div>
		</div>

	</form>
{% endblock %}
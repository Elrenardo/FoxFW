{% extends getView('pattern_index') %}

{% block title %}Erreur 404 - {{ parent() }}{% endblock %}

{% block container %}
<div class="container">
<div class="section">
<div class="row">

    <div class="col s12 m8 offset-m2">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <span class="card-title">Erreur {{error}} !</span>
          <p>{{ message|raw }}</p>
        </div>
        <div class="card-action">
          <a href="{{ router('index') }}">Accueil</a>
        </div>
      </div>
    </div>

</div>
</div>
</div>
{% endblock %}
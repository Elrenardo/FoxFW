{% for i in menu|reverse %}

<div class="panel panel-primary">
	 <div class="panel-heading">
	 <a href="{{ router( i.router ) }}" style="color:#FFF;">{{ i.titre }}</a>
	 </div>
	 {% if i.panel != '' %}
		 <div class="panel-body">
		    <ul>
				{{ i.panel|raw }}
			</ul>
		 </div>
	 {% endif %}
</div>
{% endfor %}
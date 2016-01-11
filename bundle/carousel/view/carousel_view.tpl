<div id="carousel" style="margin-top:30px;">
	<link rel="stylesheet" property='stylesheet' href="{{ bundlePath('carousel#owl.carousel.css') }}" />
	<link rel="stylesheet" property='stylesheet' href="http://www.owlcarousel.owlgraphic.com/assets/owlcarousel/assets/owl.theme.default.min.css" />

	<div class="owl-carousel owl-theme">
	  {% for i in img %}
		  {% if i != '.' %}
			  {% if i != '..' %}
			  	<div>
			  		<img class="responsive-img" src="{{ path( path~'/'~i) }}" alt="carousel"/>
			  	</div>
			  {% endif %}
		  {% endif %}
	  {% endfor %}
	</div>

	<script src="{{ bundlePath('carousel#owl.carousel.min.js') }}"></script>
	<script type="text/javascript">
	$(document).ready(function()
	{
		$('.owl-carousel').owlCarousel(
		{
		    loop:true,
		    margin:10,
		    nav:true,
		    autoplay:true,
    		autoplayTimeout:3000,
		    responsive:{
		        0:{
		            items:1
		        },
		        600:{
		            items:1
		        },
		        1000:{
		            items:2
		        }
		    }
		});
	});
	</script>
</div>
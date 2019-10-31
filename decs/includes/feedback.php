<?php $idioma = pll_current_language(); ?>
<?php 
if ($idioma == 'pt') { ?>
	<div id="feedback">
	<div id="feedbackBox">
		<div id="feedbackFechar"><i class="fas fa-times"></i></div>
		<h1>Queremos a sua opinião sobre o novo sitio web do DeCS/MeSH</h1>
		<h2>Convidamos-lhe a responder a uma pesquisa que não levará mais que 3 minutos</h2>
		<hr>
		<a href="https://forms.gle/MMnF4Qvu5VqPTuK58" class="btn btn-primary" target="_blank">Ir para pesquisa</a>
	</div>
	<div id="feedbackIcone">
		<img src="<?php bloginfo('template_directory');?>/img/iconFeedback-pt.svg" alt="">
	</div>
	<div class="clear"></div>
</div>
<?php  } ?>

<?php 
if ($idioma == 'es') { ?>
	<div id="feedback">
	<div id="feedbackBox">
		<div id="feedbackFechar"><i class="fas fa-times"></i></div>
		<h1>Queremos sus comentarios sobre el nuevo sitio web de DeCS / MeSH</h1>
		<h2>Lo invitamos a completar una encuesta que no tomará más de 3 minutos.</h2>
		<hr>
		<a href="https://forms.gle/BTGgm33p8gdD8X3W7" class="btn btn-primary" target="_blank">Ir a buscar</a>
	</div>
	<div id="feedbackIcone">
		<img src="<?php bloginfo('template_directory');?>/img/iconFeedback-es.svg" alt="">
	</div>
	<div class="clear"></div>
</div>
<?php  } ?>

<?php 
if ($idioma == 'en') { ?>
	<div id="feedback">
	<div id="feedbackBox">
		<div id="feedbackFechar"><i class="fas fa-times"></i></div>
		<h1>We want your feedback on the new DeCS / MeSH website</h1>
		<h2>We invite you to complete a survey that will take no more than 3 minutes.</h2>
		<hr>
		<a href="https://forms.gle/ETXwxZWX4RtnrT2G7" class="btn btn-primary" target="_blank">Go to search</a>
	</div>
	<div id="feedbackIcone">
		<img src="<?php bloginfo('template_directory');?>/img/iconFeedback-en.svg" alt="">
	</div>
	<div class="clear"></div>
</div>
<?php  } ?>
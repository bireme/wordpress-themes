jQuery(document).ready(function($) {

	console.log('Ready');

	//initialize tooltips bootstrap
	$('#pesquisa-bvs').find('[data-toggle="tooltip"]').tooltip({
      	animation: true,
      	delay: {show: 100, hide: 2000}
    });

	$('[data-toggle="tooltip"]').tooltip();

});
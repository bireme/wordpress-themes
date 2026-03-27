<?php /* Template Name: Biblioteca */ ?>
<?php get_header('interno'); ?>
<?php 
$thumb = get_the_post_thumbnail_url(get_the_ID(), 'full'); 
$bg = $thumb ? $thumb : get_template_directory_uri() . '/img/header-memorial.jpg';
?>
<header id="header-title" class="pt-5 pb-5" style="background: linear-gradient(45deg, rgba(0,0,0,0.6), rgba(0,0,0,0.2)), url('<?php echo $bg; ?>') center bottom no-repeat fixed; background-size: cover;">
	<div class="container">
		<h1 class="mb-3"><?php the_title(); ?></h1>
			<form id="buscaForm" class="row form-biblioteca" method="get" action="<?php echo esc_url(MEMORIAL_TAINACAN_BASE_URL . '/colecoes'); ?>">
			<div class="col-10">
				<input type="text" class="form-control" id="fieldSearch" name="s" placeholder="">
			</div>
			<div class="col-2">
				<button type="submit" class="btn btn-primary w-100">Pesquisar</button>
			</div>
			<div class="mt-2">
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="colecao">
					<label class="form-check-label" for="inlineRadio1">Coleções</label>
				</div>

				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="documento" checked>
					<label class="form-check-label" for="inlineRadio2">Publicações</label>
				</div>
			</div>
		</form>
	</div>
</header>
<main id="main_container" class="mb-5">
	<div class="container">
		<div class="breadcrumb mt-3">
			<?php if ( function_exists('bcn_display') ) { bcn_display(); } ?>
		</div>
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer(); ?>
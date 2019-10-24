<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="col-md-12 content-pearl">
		<header class="entry-header">
			<label class="area-tematica-sof"><?php echo get_the_term_list(get_the_ID(), 'categoria-da-evidencia', '', ', '); ?></label>
			<?php
				the_title( '<h1 class="entry-title">', '</h1>' );
			?>
			<label class="nucleo-date-id">
				<?php echo get_the_term_list(get_the_ID(), 'teleconsultor', '', ', '); ?> | 
				<?php echo get_the_date('d M Y', get_the_ID()); ?> | 
				ID: poems-<?php echo get_the_ID(); ?>
			</label>
		</header><!-- .entry-header -->
		
		<div class="entry-content">
		<div class="col-md12 item-pearl">
			<div class="area_tematica">
				<h3 class="title"><?php _e("Área Temática", 'bvsaps'); ?></h3>
				
				<?php if(taxonomy_exists('area-tematica')): ?>
					<div class="content"><?php the_terms(get_the_ID(), 'area-tematica'); ?></div>
				<?php endif; ?>

				<?php if(taxonomy_exists('categoria-da-evidencia')): ?>
					<div class="content"><?php the_terms(get_the_ID(), 'categoria-da-evidencia'); ?></div>
				<?php endif; ?>
			</div>

			<div class="questao_clinica">
				<h3 class="title"><?php _e("Questão Clínica", 'bvsaps'); ?></h3>
				<div class="content"><?php the_field('questao_clinica'); ?></div>
			</div>

			<div class="resposta_baseada_em_evidencia">
				<h3 class="title"><?php _e("Resposta Baseada em Evidência", 'bvsaps'); ?></h3>
				<div class="content"><?php the_field('resposta_baseada_em_evidencia'); ?></div>
			</div>

			<div class="alertas">
				<h3 class="title"><?php _e("Alertas", 'bvsaps'); ?></h3>
				<div class="content"><?php the_field('alertas'); ?></div>
			</div>

			<div class="contexto">
				<h3 class="title"><?php _e("Contexto", 'bvsaps'); ?></h3>
				<div class="content"><?php the_field('contexto'); ?></div>
			</div>

			<div class="comentarios">
				<h3 class="title"><?php _e("Comentários sobre a aplicabilidade do estudo para APS no contexto do SUS, sob o ponto de vista clínico, de gestão da saúde e para o público em geral", 'bvsaps'); ?></h3>
				<div class="content"><?php the_field('comentarios'); ?></div>
			</div>

			<div class="referencia">
				<h3 class="title"><?php _e("Referências bibliográficas", 'bvsaps'); ?></h3>
				<div class="content"><?php the_field('referencia'); ?></div>
			</div>
		</div>
		</div><!-- .entry-content -->		

		<footer class="entry-footer">
			<?php if( !empty($bibliografia_sof) ){ ?>
			<div class="bibliografia-sof">
				<h3 class="title-bibliografia"><?php _e('Bibliografia Selecionada', 'bvs_lang'); ?></h3>
				<div class="content-bibliografia">
					<?php echo $bibliografia_sof; ?>
				</div>
			</div>
			<?php } ?>

			<?php wp_bootstrap_starter_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->

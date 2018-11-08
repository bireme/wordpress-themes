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
	<div class="col-md-12 content-sof">
		<header class="entry-header">
			<label class="area-tematica-sof"><?php echo get_the_term_list(get_the_ID(), 'categoria-da-evidencia', '', ', '); ?></label>
			<?php
				the_title( '<h1 class="entry-title">', '</h1>' );
			?>
			<label class="nucleo-date-id">
				<?php echo get_the_term_list(get_the_ID(), 'teleconsultor', '', ', '); ?> | 
				<?php echo get_the_date('d M Y', get_the_ID()); ?> | 
				ID: sof-<?php echo get_the_ID(); ?>
			</label>
		</header><!-- .entry-header -->
		<div class="taxonomies-sof">
			<label class="solicitante-sof">
				<strong><?php _e('Solicitante', 'bvs_lang'); ?>:</strong> <?php echo get_the_term_list(get_the_ID(), 'tipo-de-profissional', '', ', '); ?>
			</label>
			<label class="ciap2-sof">
				<strong>CIAP2:</strong> <?php echo get_the_term_list(get_the_ID(), 'ciap2', '', ', '); ?>
			</label>
			<label class="decs-mesh-sof">
				<strong>DeCS/MeSH:</strong> <?php echo get_the_term_list(get_the_ID(), 'decs', '', ', '); ?>
			</label>
		</div>
		<div class="entry-content">
			<?php $bibliografia_sof = get_post_meta( get_the_ID(), 'bibliografia_selecionada', true ); 
			if( !empty($bibliografia_sof) ){ ?>
			<div class="bibliografia-sof-mobile">
				<div class="text-right">
					<button type="button" class="btn btn-link" data-toggle="modal" data-target="#modal-bibliografia-sof">
				  		<?php _e('Bibliografia Selecionada', 'bvs_lang'); ?>
					</button>
				</div>
				
				<!-- Modal Bibliografia -->
				<div class="modal fade" id="modal-bibliografia-sof" tabindex="-1" role="dialog" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title"><?php _e('Bibliografia Selecionada', 'bvs_lang'); ?></h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				      	<div class="content-bibliografia">
		        			<?php echo $bibliografia_sof; ?>
		        		</div>
				      </div>
				    </div>
				  </div>
				</div>
			</div>
			<?php
			}
				the_content();

				$obs_sof = get_post_meta( get_the_ID(), 'observacoes', true );
				if( !empty($obs_sof) ){
					echo $obs_sof;
				}
			?>
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

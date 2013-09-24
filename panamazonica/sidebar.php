<?php if ( is_active_sidebar('primary-widget-area') ) : ?>
	<div id="primary" class="widget-area cf">
		<?php if ( is_post_type_archive( 'documento' ) || is_singular( 'documento' ) ) : ?>
			<?php
			if ( $fields = Documentos::$custom_meta_fields ) : ?>	
				<form class="document-search" method="post" action="<?php echo site_url('documento'); ?>">
					<h3 class="area-title"><?php _e( 'Search Documents', 'panamazonica' ); ?></h3>
					<?php
	
					$output = '';
					
					foreach ( $fields as $field )
					{
	
						// Não há necessidade do meta de link
						if ( in_array( $field['id'], array( '_pan_link' ) ) )
				        			continue;
						
						// Cria a estrutura
				        $output .= '<div class="form-field-wrap"><label for="' . $field['id'] . '">' . $field['label'] . '</label> ';
				        
				        switch ( $field['type'] ) {	
				        	
				        	// Texto
				        	case 'text':
						        $output .= '<input type="text" id="' . $field['id'] . '" class="" name="' . $field['id'] . '" value="' . esc_attr( $_SESSION[$field['id']] ) . '" size="25" />';
						    break;
						    
						    // Dropdown
							case 'select':
								$output .= '<select name="' . $field['id'] . '" id="' . $field['id'] . '">';
								
								if ( $field['id'] ==  '_pan_idioma' )
									$output .= '<option value=""' . ( $_SESSION[$field['id']] == 'todos' ? ' selected="selected"' : '' ) . '>Todos</option>';
									
								foreach ( $field['options'] as $option ) {
									$output .= '<option value="' . $option['value'] . '"' . ( $_SESSION[$field['id']] == $option['value'] ? ' selected="selected"' : '' ) . '>' . $option['label'] . '</option>';
								}
								$output .= '</select>';
							break;
						};
						
						$output .= '</div><!-- /form-field-wrap -->';
							
					}
					
					// Para o site principal, o campo do Grupo de Trabalho também é necessário
					if ( get_current_blog_id() == 1 )
					{
					    
					
					    $output .= '<div class="form-field-wrap"><label for="_pan_grupo">' . __('Workgroup', 'panamazonica') . ': </label> ';
					    $output .= '<select name="_pan_grupo" id="_pan_grupo">';
					    
					    if ( $network_sites = wp_get_sites( array( 'sort_column' => 'blogname' ) ) )
					    {
					    	$output .= '<option value="1"' . ( $_SESSION['_pan_grupo'] == 1 ? ' selected="selected"' : '' ) . '>' . __('All', 'panamazonica') . '</option>';
					    	
					    	foreach ( $network_sites as $network_site )
					    	{
					    		if ( $network_site['blog_id'] == 1 )
					    			continue;
					    		
					    		$output .= '<option value="' . $network_site['blog_id'] . '"' . ( $_SESSION['_pan_grupo'] == $network_site['blog_id'] ? ' selected="selected"' : '' ) . '>' .get_blog_details( $network_site['blog_id'] )->blogname . '</option>';
					    	}
					    }
					    
					    $output .= '</select></div>';
					}
					
					echo $output; ?>
					<button type="submit" name="submit" value="submit" class="button"><?php _e( 'Search Documents', 'panamazonica' ); ?></button>
					<button type="submit" name="reset" value="reset" class="button  button--cancel"><?php _e( 'Clear fields', 'panamazonica' ); ?></button>
				</form>	
			<?php endif; ?>

		<?php else:?>
		
	    	<?php dynamic_sidebar( 'primary-widget-area' ); ?>

		<?php endif; ?>


	</div><!-- /primary -->
<?php endif; ?>

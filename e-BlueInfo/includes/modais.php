<!-- Modal Google Play -->
<div class="modal fade" id="googlePlay" tabindex="-1" role="dialog" aria-labelledby="googlePlayTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="googlePlayTitle">QR Code Google Play</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<p><?php pll_e('Scan QR Code with Mobile'); ?></p>
				<p><a href="https://play.google.com/store/apps/details?id=org.bvsalud.eblueinfo" target="_blank"><?php pll_e('Or if you prefer click here to access the store'); ?> Google Play.</a></p>
				<div class="text-center"><img src="<?php bloginfo( 'template_directory' ) ?>/img/qrCodeGooglePlay.svg" alt="Imagem QR Code Google Play"></div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Apple Store-->
<div class="modal fade" id="appleStore" tabindex="-1" role="dialog" aria-labelledby="appleStoreTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="googlePlayTitle">QR Code Apple Store</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<p><?php pll_e('Scan QR Code with Mobile'); ?>  </p>
				<p><a href="https://apps.apple.com/pt/app/e-blueinfo/id1444287099" target="_blank"><?php pll_e('Or if you prefer click here to access the store'); ?> Apple Store.</a></p>
				<div class="text-center"><img src="<?php bloginfo( 'template_directory' ) ?>/img/qrCodeAppleStore.svg" alt="Imagem QR Code Apple Store"></div>
			</div>
		</div>
	</div>
</div>


<!-- Modal Apple Store-->
<div class="modal fade" id="countriesM" tabindex="-1" role="dialog" aria-labelledby="appleStoreTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="googlePlayTitle"><?php pll_e('Interested Countries'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<div class="table-responsive">
					<?php
					$countries = new WP_Query([
						'post_type' => 'Countries',
						'orderby' => 'title',
						'order' => 'ASC'
					]);
					?>
					<table class="table table-bordered table-striped" role="table" >
						<thead>
							<tr>
								<td role="columnheader"></td>
								<td role="columnheader">Países</td>
								<td role="columnheader">Status</td>
							</tr>
						</thead>
						<tbody>
							<?php while($countries->have_posts()):$countries->the_post(); 
								$name = get_field('name');
								$flag = get_field('flag');
								$status = get_field('status');
							?>
							<tr>
								<td role="cell"><img src="<?php echo $flag['url']; ?>" alt="<?php echo $name; ?>"></td>
								<td role="cell"><?php echo $name; ?></td>
								<td role="cell"><?php echo $status; ?></td>
							</tr>
							<?php endwhile;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
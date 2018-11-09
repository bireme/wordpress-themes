<div class="dropdown btn-share">
	<button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="fa fa-share-alt m-r-5"></span> <span><?php _e('Compartilhar', 'bvs_lang'); ?></span>
	</button>
	<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		<a class="dropdown-item" href="mailto:?body=<?php echo get_the_permalink(); ?>&subject=<?php echo get_the_title(); ?>">
			<span class="fas fa-envelope-square m-r-5"></span> Email
		</a>
		<a class="dropdown-item" target="_blank" href="https://www.facebook.com/share.php?u=<?php echo get_the_permalink(); ?>" >
			<span class="fab fa-facebook-square m-r-5"></span> Facebook
		</a>
		<a class="dropdown-item" target="_blank" href="http://twitter.com/share?text=<?php echo urlencode(get_the_title()); ?>&url=<?php echo get_the_permalink(); ?>">
			<span class="fab fa-twitter-square m-r-5"></span> Twitter
		</a>
		<a class="dropdown-item" target="_blank" href="https://web.whatsapp.com/send?text=<?php echo get_the_title() .' - '. get_the_permalink(); ?>">
			<span class="fab fa-whatsapp-square m-r-5"></span> WhatsApp
		</a>					
	</div>
</div>
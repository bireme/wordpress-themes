<?php while(have_posts()) : the_post();
	$banner 		= get_field('banner');
endwhile;
?>
<div id="carousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?php echo $banner['url']; ?>" alt="<?php echo $banner['alt']; ?>" class="d-block w-100">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
  <div id="arrow-down"><a href="#main_container"><i class="fa fa-chevron-down" aria-hidden="true"></i></a></div>
</div>
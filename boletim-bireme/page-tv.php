<?php
/*	Template Name: TV*/
?>
<meta http-equiv="refresh" content="4000">
<?php wp_head(); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<style>
	body{
		margin: 0;
		padding: 0;
	}
	#tvContainer{
		width: 1900;
		height: 1080px;
		margin: auto;
		overflow: hidden;
	}
	#tvMain{
		height:970px; 
		overflow:hidden;
		position: relative;
	}
	#tvTitle{
		height: 100px;
		margin-bottom: 10px;
	}
	#tvNews{
		height:967px; 
		position: relative;
		background: #075bba;
		color: #fff;
		padding: 0 10px;
	}
	#tvNewsNext{
		height: 820px;
		padding: 10px;
		overflow:hidden;
		box-sizing: border-box;
		margin-bottom: 80px;
	}
	#tvNewsNext h2{
		font-size: 3.5rem;
		padding-bottom: 7px; 
		border-bottom: 3px solid #fff;
		font-weight: bold;
		text-align: center;
	}
	.tvNewsLoop{
		width: 100%;
		margin: auto;
		padding: 12px 0;
		border-bottom: 1px solid #fff;
		font-size: 2.5rem;
		margin-bottom: 10px;
	}
	.tvNewsLoop:nth-last-child(1){
		border-bottom: none;
	}
	#tvNewsNext .active{
		color: #ff0;
	}
	.carousel-caption{
		width: 100%!important;
		left: 0;
		bottom: 0px;
		right: 0;
		background: linear-gradient(
			to bottom,
			rgba(0, 0, 0, 0) 0%,
			rgba(7, 91, 186, .6) 20%,
			rgba(7, 91, 186, 1) 100%
		);
		text-align: left;
	}
	.carousel-caption h5{
		font-size: 5rem;
		padding: 0 50px;
		text-shadow: 2px 2px 2px #000;
		font-weight: bold;
	}
	.carousel-caption p{
		font-size: 3rem;
		padding: 0 50px;
		text-shadow: 2px 2px 2px #000;
		margin-bottom: 100px;
	}
	#tvFooterHora{
		text-align: center;
		font-size: 3rem;
		background: #19bfff;
		font-weight: bold;
		border-radius:20px;
		margin-right: 5px;
		position: relative;
	}
	#qrcode{
		float: left;
		position: absolute;
		bottom: 22px;
		z-index: 10;
	}
	#qrcode img{
		width: 120px;
	}
</style>
<?php $lang = pll_current_language(); ?>
<div id="tvContainer">
	<div class="row" style="position: relative">
		<div id="tvTitle">
			<img src="<?php bloginfo('template_directory'); ?>/assets/images/header-tv-<?php echo $lang; ?>.jpg" alt="" class="img-fluid"> 
		</div>
		<div class="col-9" id="tvMain">

			<div id="tvCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="10000" data-touch="false" data-bs-pause="false">
				<div class="carousel-inner">
					<?php 
					$i = 0;
					$posts = new WP_Query([
						'post_type' => 'post',
						'posts_per_page' => '-1',
						'lang' => $lang
					]);
					while($posts->have_posts()) : $posts->the_post();
						$image_tv = get_field('image_tv'); 
						$subtitulo = get_field('subtitulo'); 
						$mostrar = get_field('mostrar'); 
						if ($mostrar == 2 ||  $mostrar == 4) { ?>
							<div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>">
								<img src="<?php echo esc_url($image_tv['sizes']['tv']); ?>" class="d-block w-100" alt="...">
								<div class="carousel-caption d-none d-md-block">
									<h5><?php the_title(); ?></h5>
									<p><?php echo $subtitulo; ?></p>
								</div>							
							</div>
							<?php $i++; 
						} 
					endwhile;
					?>
					<div id="degrade"></div>
				</div>
				
			</div>
		</div>
		<div class="col-3" id="tvNews">
			<div id="tvNewsNext">
				<h2><?php pll_e('Upcoming News'); ?></h2>
				<?php 
				$posts = new WP_Query([
					'post_type' => 'post',
					'posts_per_page' => '-1',
					'lang' => $lang
				]);
				$i = 0;
				while($posts->have_posts()) : $posts->the_post();
					$mostrar = get_field('mostrar'); 
					
					if ($mostrar == 2 ||  $mostrar == 4) { ?>
						<article class="tvNewsLoop <?php echo ($i == 0) ? 'active' : ''; ?>">
							<b><?php the_title(); ?></b> <br>
						</article>
						<?php $i++; 
					} 
				endwhile;
				?>
			</div>

			<div id="tvFooter">
				<div id="qrcode">
					<img src="<?php bloginfo('template_directory'); ?>/assets/images/qrcode.svg" alt="" class="img-fluid">
				</div>
				<div id="tvFooterHora"></div>
			</div>
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
<script>
	$ = jQuery;

	var $clock = $('#tvFooterHora');
	setInterval(function () {
		$clock.html((new Date()).toLocaleString('pt-BR',{hour12:false, timeZone: 'America/Sao_Paulo'}).substr(11, 9));
	}, 1000);


	/*** News TV ***/

	$(document).ready(function() {
	var interval = parseInt($("#tvCarousel").data("interval")) || 10000;
	var articlePlay = setInterval(articleNext, interval);

	function articleNext(){
		if($(".tvNewsLoop.active").next().length){
			$(".tvNewsLoop.active").hide(function(){
				var last_slide = $("#tvNewsNext").find(".tvNewsLoop:last");
				$(this).removeClass("active").next().addClass("active").show();
				$(this).detach().insertAfter(last_slide).show();
			});
		}
	}
});

// Troca URL em loop: /tv -> /pt/tv-pt -> /en/tv-en -> /tv...
const DELAY = 600000; // 10 min

setTimeout(() => {
  const { origin, pathname, search, hash } = location;

  // casa: [base][/pt|/en]/[slug]
  const m = pathname.match(/^(.*?)(?:\/(pt|en))?\/([^/]+)\/?$/);
  if (!m) return;

  const base = m[1].endsWith("/") ? m[1] : m[1] + "/";
  const lang = m[2] || null;         // null => es (/tv)
  const slug = m[3];

  // remove sufixos conhecidos (-pt, -en) para obter o "baseSlug"
  const baseSlug = slug.replace(/(?:-pt|-en)$/i, "");

  // ordem do ciclo: es (/tv) -> pt (/pt/tv-pt) -> en (/en/tv-en) -> es (/tv)
  const currentIdx = lang === "pt" ? 1 : lang === "en" ? 2 : 0;
  const nextIdx = (currentIdx + 1) % 3;

  let targetPath;
  if (nextIdx === 0) {
    // es: apenas /tv
    targetPath = `${base}${baseSlug}`;
  } else if (nextIdx === 1) {
    // pt: /pt/tv-pt
    targetPath = `${base}pt/${baseSlug}-pt`;
  } else {
    // en: /en/tv-en
    targetPath = `${base}en/${baseSlug}-en`;
  }

  location.href = origin + targetPath + search + hash;
}, DELAY);



 
</script>
<?php wp_footer(); ?>
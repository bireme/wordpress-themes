<?php $di = function_exists('bireme_get_lilacs_di_meta') ? bireme_get_lilacs_di_meta(get_the_ID()) : null; ?>
<?php if ($di && !empty($di['boxes'])): ?>
<section id="lilacs-di" aria-label="LILACS em dados e indicadores">
  <style>
  <?php echo <<<'CSS'
  #lilacs-di{padding:65px 20px 65px;background:#fff;border-top:4px solid #0b3f73}
  #lilacs-di .di-wrap{max-width:1280px;margin:0 auto}
  #lilacs-di .di-title{    font-family: 'Noto Sans';
    font-weight: 700;
    font-size: 36px;
    line-height: 100%;
    margin: 0 !important;
    color: #00205C;
    margin-bottom: 15px !important;}
  #lilacs-di .di-sub{font-family: 'Noto Sans';
    font-weight: 400;
    font-size: 18px;
    color: #00205C;
    margin-bottom: 25px;}

  #lilacs-di .di-grid{
    display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-top:10px;
  }
  @media (max-width:1100px){#lilacs-di .di-grid{grid-template-columns:repeat(2,1fr)}}
  @media (max-width:560px){#lilacs-di .di-grid{grid-template-columns:1fr}}

  /* Card com notch circular */
  #lilacs-di .di-card{
    position: relative;
    border-radius: 12px;
    padding: 18px 16px 22px;
    color: #fff;
    min-height: 199px;
    margin-top: 60px;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    text-align: center;
    box-shadow: 0 10px 24px rgba(3, 10, 24, .18);
    text-decoration: none;
  }
  #lilacs-di .di-card .di-notch{
    position: absolute;
    top: -59px;
    left: 50%;
    transform: translateX(-50%);
    width: 130px;
    height: 130px;
    border-radius: 999px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, .15);
  }
  #lilacs-di .di-card .di-notch img{width:40px;height:40px;object-fit:contain}
  #lilacs-di .di-card h4{    margin: 0;
    font-family: 'Noto Sans';
    font-size: 24px;
    font-weight: 400;
    line-height: 115.99%;
    padding: 31px;}

  /* 4 variações de cor */
  #lilacs-di .c1{background:#2B0993;}
  #lilacs-di .c2{background:#085695;}
  #lilacs-di .c3{background:#9453BD;}
  #lilacs-di .c4{background:#5D53BB;}

  /* CTA */
  #lilacs-di .di-cta{display:flex;justify-content:center;margin-top:18px}
  #lilacs-di .di-cta a{
  display: inline-block;
    background: #f96a1e;
    color: #fff;
    text-decoration: none;
    padding: 10px 22px;
    border-radius: 999px;
    box-shadow: 0 8px 18px rgba(249, 106, 30, .28);
    font-family: 'Noto Sans';
    width: 360px;
    text-align: center;
    margin-top: 35px;
    font-size: 20px;
  }
  #lilacs-di .di-cta a:hover{filter:brightness(1.05)}
  CSS; ?>
  </style>

  <div class="di-wrap">
    <h2 class="di-title"><?php echo esc_html($di['title'] ?: 'LILACS em dados e indicadores'); ?></h2>
    <?php if(!empty($di['subtitle'])): ?>
      <p class="di-sub"><?php echo esc_html($di['subtitle']); ?></p>
    <?php endif; ?>

    <div class="di-grid">
      <?php
      $colors = ['c1','c2','c3','c4'];
      $i = 0;
      foreach($di['boxes'] as $box){
        $title = trim($box['title'] ?? '');
        $url   = esc_url($box['url'] ?? '#');
        $icon  = esc_url($box['icon_url'] ?? '');
        if($title==='') continue;
        $class = $colors[$i % 4]; $i++;
      ?>
        <a class="di-card <?php echo $class; ?>" href="<?php echo $url; ?>">
          <span class="di-notch" aria-hidden="true">
            <?php if($icon): ?><img src="<?php echo $icon; ?>" alt=""><?php endif; ?>
          </span>
          <h4><?php echo esc_html($title); ?></h4>
        </a>
      <?php } ?>
    </div>

    <?php if(!empty($di['btn_txt']) && !empty($di['btn_url'])): ?>
      <div class="di-cta">
        <a href="<?php echo esc_url($di['btn_url']); ?>"><?php echo esc_html($di['btn_txt']); ?></a>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
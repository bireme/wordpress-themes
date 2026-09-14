<?php
$dp = function_exists('bireme_get_lilacs_dep_meta') ? bireme_get_lilacs_dep_meta(get_the_ID()) : null;
if ($dp && !empty($dp['items'])) :
?>
<section id="lilacs-dep" aria-label="Depoimentos">
  <style>
  <?php echo <<<'CSS'
  #lilacs-dep{    padding: 65px 20px 65px;
    background-image:url(https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/e1905627ed466017547247977287d50c66ab9a42-scaled.jpg);}
  #lilacs-dep .dep-wrap{max-width:1280px;margin:0 auto}
  #lilacs-dep .dep-title{font-family: 'Noto Sans';
    font-size: 36px;
    color: #00205C;
    line-height: 100%;}

  #lilacs-dep .dep-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
  @media (max-width:920px){#lilacs-dep .dep-grid{grid-template-columns:1fr}}

  #lilacs-dep .dep-card{
     position: relative;
    border-radius: 12px;
    padding: 18px 18px 16px;
    color: #fff;
    background: linear-gradient(135deg, #9453BD 0%, #085695 65%, #085695 100%);
    box-shadow: 0 10px 24px rgba(3, 10, 24, .18);
    min-height: 277px;
  }
  #lilacs-dep .dep-head{display:flex;align-items:center;gap:12px;margin-bottom:10px}
  #lilacs-dep .dep-avatar{
    width:75px;height:75px;border-radius:999px;overflow:hidden;background:rgba(255,255,255,.9)
  }
  #lilacs-dep .dep-avatar img{width:100%;height:100%;object-fit:cover;display:block}
  #lilacs-dep .dep-name{margin: 0;
    font-family: 'Noto Sans';
    font-size: 20px;
    font-weight: 700;}
  #lilacs-dep .dep-role{    margin: 0;
    font-family: 'Noto Sans';
    font-size: 18px;
    font-weight: 400;}
  #lilacs-dep .dep-text{margin: 6px 0 0;
    font-size: 18px;
    font-weight: 400;
    font-family: 'Noto Sans';
    line-height: 150%;
    padding-left: 10px;}
  CSS; ?>
  </style>

  <div class="dep-wrap">
    <h2 class="dep-title"><?php echo esc_html($dp['title'] ?: 'Depoimentos'); ?></h2>

    <div class="dep-grid">
      <?php foreach($dp['items'] as $it):
        $name = trim($it['name'] ?? ''); if($name==='') continue;
        $role = trim($it['role'] ?? '');
        $text = trim($it['text'] ?? '');
        $img  = esc_url($it['avatar_url'] ?? '');
      ?>
        <article class="dep-card">
          <div class="dep-head">
            <span class="dep-avatar"><?php if($img): ?><img src="<?php echo $img; ?>" alt=""><?php endif; ?></span>
            <div>
              <p class="dep-name"><?php echo esc_html($name); ?></p>
              <?php if($role!==''): ?><p class="dep-role"><?php echo esc_html($role); ?></p><?php endif; ?>
            </div>
          </div>
          <?php if($text!==''): ?><p class="dep-text"><?php echo esc_html($text); ?></p><?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

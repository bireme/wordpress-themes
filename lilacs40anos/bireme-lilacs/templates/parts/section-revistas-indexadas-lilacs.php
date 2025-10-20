<?php
$jr = function_exists('bireme_get_lilacs_journals_meta') ? bireme_get_lilacs_journals_meta(get_the_ID()) : null;
if ($jr && (!empty($jr['items']))) :
?>
<section id="lilacs-journals" aria-label="Revistas indexadas na LILACS">
  <style>
    #lilacs-journals{padding:135px 20px 135px;background:#fff}
    #lilacs-journals .jr-wrap{max-width:1280px;margin:0 auto}
    #lilacs-journals .jr-title{    font-family: 'Noto Sans';
    color: #00205C;
    margin: 0 0 6px;
    font-size: 36px;
    font-weight: 700;}
    #lilacs-journals .jr-sub{    font-family: 'Noto Sans';
    font-weight: 400;
    font-size: 18px;
    color: #00205C;    margin-bottom: 43px;    margin-top: 0 !important;}
    #lilacs-journals .jr-grid{
      display:grid;grid-template-columns:repeat(5,1fr);gap:14px
    }
    @media (max-width:1100px){#lilacs-journals .jr-grid{grid-template-columns:repeat(3,1fr)}}
    @media (max-width:720px){#lilacs-journals .jr-grid{grid-template-columns:repeat(2,1fr)}}
    @media (max-width:460px){#lilacs-journals .jr-grid{grid-template-columns:1fr}}

    #lilacs-journals .jr-pill{
      display:flex;flex-direction:column;justify-content:center;min-height:74px;
      background:#085695;
      color:#fff;border-radius:10px;padding:14px 16px;position:relative;
      box-shadow:0 8px 20px rgba(3,10,24,.16);text-decoration:none
    }
    #lilacs-journals .jr-pill:hover{filter:brightness(1.03)}
    #lilacs-journals .jr-pill h4{    margin: 0 0 2px;
    font-family: 'Noto Sans';
    font-weight: 700;
    font-size: 24px;
    line-height: 150%;}
    #lilacs-journals .jr-pill small{    opacity: .95;
    font-family: 'Noto Sans';
    font-size: 20px;
    font-weight: 400;
    line-height: 150%;}
    #lilacs-journals .jr-arrow{
      position:absolute;right:10px;top:50%;transform:translateY(-50%);
      width:26px;height:26px;border-radius:999px;background:rgba(255,255,255,.18);
      display:flex;align-items:center;justify-content:center
    }
    #lilacs-journals .jr-arrow svg{width:14px;height:14px;stroke:#fff}

    /* pílula laranja (destaque) */
    #lilacs-journals .jr-pill.is-accent{
      background:linear-gradient(180deg,#ff8a3a 0%, #e8650a 100%);
    }
  </style>

  <div class="jr-wrap">
    <?php if(!empty($jr['title'])): ?>
      <h2 class="jr-title"><?php echo esc_html($jr['title']); ?></h2>
    <?php endif; ?>
    <?php if(!empty($jr['subtitle'])): ?>
      <p class="jr-sub"><?php echo esc_html($jr['subtitle']); ?></p>
    <?php endif; ?>

    <div class="jr-grid">
      <?php foreach($jr['items'] as $it): 
        $label = trim($it['label'] ?? '');
        $total = trim($it['total'] ?? '');
        $url   = esc_url($it['url'] ?? '#');
        $accent= !empty($it['accent']);
        if($label==='') continue;
      ?>
        <a class="jr-pill <?php echo $accent?'is-accent':''; ?>" href="<?php echo $url; ?>">
          <h4><?php echo esc_html($label); ?></h4>
          <?php if($total!==''): ?><small>Total: <?php echo esc_html($total); ?></small><?php endif; ?>
          <span class="jr-arrow" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

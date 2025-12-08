<?php
$jr = function_exists('bireme_get_lilacs_journals_meta') ? bireme_get_lilacs_journals_meta(get_the_ID()) : null;
if ($jr && (!empty($jr['items']))) :
?>
<section id="lilacs-journals" aria-label="Revistas indexadas na LILACS">
  <style>
    #lilacs-journals{padding:135px 20px 135px;background:#fff}
    #lilacs-journals .jr-wrap{max-width:1280px;margin:0 auto}
    #lilacs-journals .jr-title{
      font-family:'Noto Sans';
      color:#00205C;
      margin:0 0 6px;
      font-size:36px;
      font-weight:700;
    }
    #lilacs-journals .jr-sub{
      font-family:'Noto Sans';
      font-weight:400;
      font-size:18px;
      color:#00205C;
      margin-bottom:43px;
      margin-top:0!important;
    }
    #lilacs-journals .jr-grid{
      display:grid;
      grid-template-columns:repeat(5,1fr);
      gap:14px;
    }
    @media (max-width:1100px){
      #lilacs-journals .jr-grid{grid-template-columns:repeat(3,1fr)}
    }
    @media (max-width:720px){
      #lilacs-journals .jr-grid{grid-template-columns:repeat(2,1fr)}
    }
    @media (max-width:460px){
      #lilacs-journals .jr-grid{grid-template-columns:1fr}
    }

    #lilacs-journals .jr-pill{
     position: relative;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    min-height: 90px;
    background: #ffffff;
    color: #085695;
    border-radius: 10px;
    padding: 26px 16px 14px;
    box-shadow: 0 8px 20px rgba(3, 10, 24, .16);
    text-decoration: none;
    overflow: hidden;
    }
    #lilacs-journals .jr-pill:hover{
      filter:brightness(1.03);
      transform:translateY(-1px);
      transition:all .15s ease-out;
    }

    /* linha principal: imagem + texto lado a lado */
    #lilacs-journals .jr-pill-main{
      display:flex;
      align-items:center;
      gap:12px;
    }

    #lilacs-journals .jr-pill h4{
      margin:0;
      font-family:'Noto Sans';
      font-weight:700;
      font-size:20px;
      line-height:135%;
    }

    #lilacs-journals .jr-pill .jr-pill-text{
      display:flex;
      flex-direction:column;
      gap:2px;
    }

    /* badge do total, acima de tudo */
    #lilacs-journals .jr-total-badge{
position: absolute;
    top: 8px;
    right: 7px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 2px 10px;
    border-radius: 999px;
    background: rgb(234 88 12);
    backdrop-filter: blur(4px);
    font-family: 'Noto Sans';
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .02em;
    text-transform: uppercase;
    white-space: nowrap;
    }

    #lilacs-journals .jr-total-badge strong{
      font-weight:700;
      color:#fff;
      margin-right:4px;
    }

    #lilacs-journals .jr-arrow{
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 26px;
    height: 26px;
    border-radius: 999px;
    background: #085695;
    display: flex;
    align-items: center;
    color: #fff;
    justify-content: center;
    }
    #lilacs-journals .jr-arrow svg{
      width:14px;
      height:14px;
      stroke:#fff;
    }

    /* pílula laranja (destaque) */
    #lilacs-journals .jr-pill.is-accent{
      background:linear-gradient(180deg,#ff8a3a 0%, #e8650a 100%);
    }

    /* IMAGEM DA REVISTA */
    #lilacs-journals .jr-pill-thumb{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      width:48px;
      height:48px;
      border-radius:8px;
      overflow:hidden;
      flex-shrink:0;
    }
    #lilacs-journals .jr-pill-thumb img{
      width:100%;
      height:100%;
      object-fit:cover;
      display:block;
    }

    @media (max-width:720px){
      #lilacs-journals .jr-pill{
        padding-right:44px;
      }
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
        $label    = trim($it['label'] ?? '');
        $total    = trim($it['total'] ?? '');
        $url      = esc_url($it['url'] ?? '#');
        $accent   = !empty($it['accent']);
        $img_url  = !empty($it['image_url']) ? esc_url($it['image_url']) : '';
        if($label==='') continue;
      ?>
        <a class="jr-pill <?php echo $accent ? 'is-accent' : ''; ?>" href="<?php echo $url; ?>">
          <?php if($total !== ''): ?>
            <span class="jr-total-badge">
              <strong><?php echo esc_html($total); ?></strong>
            </span>
          <?php endif; ?>

          <div class="jr-pill-main">
            <?php if($img_url): ?>
              <span class="jr-pill-thumb">
                <img src="<?php echo $img_url; ?>" alt="<?php echo esc_attr($label); ?>">
              </span>
            <?php endif; ?>
            <div class="jr-pill-text">
              <h4><?php echo esc_html($label); ?></h4>
            </div>
          </div>

          <span class="jr-arrow" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M9 18l6-6-6-6" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

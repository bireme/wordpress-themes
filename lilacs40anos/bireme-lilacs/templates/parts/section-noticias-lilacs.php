<?php
$rc = function_exists('bireme_get_lilacs_recent_meta') ? bireme_get_lilacs_recent_meta(get_the_ID()) : null;
if ($rc && !empty($rc['items'])) :
?>
<section id="lilacs-recent" aria-label="Publicações recentes em saúde">
  <style>
  <?php echo <<<'CSS'
  /* ===== Layout: esquerda alinhada ao container; direita full-bleed ===== */
  #lilacs-recent{
    --container: 1280px;
    --gutter: 20px;
    /* usa 100% em vez de 100vw para evitar overflow causado pela scrollbar */
    --pad-left: max(var(--gutter), calc((100% - var(--container)) / 2));
    background: #085695;
    padding: 28px 0;
    min-height: 420px;
    display: flex
    ;
        align-content: center;
        align-items: center;             /* sem padding à direita */
    overflow-x: hidden; /* impede overflow horizontal vindo desta seção */
  }

  /* wrapper em flex: colunas encostadas uma na outra */
  #lilacs-recent .rc-wrap{
    display:flex;
    align-items:flex-start;
    gap:18px;                                     /* espaço entre as colunas */
    padding-left: var(--pad-left);                /* alinha à seção anterior */
    overflow: hidden; /* protege contra conteúdo interno gerando overflow da página */
    min-width: 0;
  }

  /* coluna esquerda fixa, seguindo “linha de design” */
  #lilacs-recent .rc-left{
    width:584px;
    color:#fff;
  }
  #lilacs-recent .rc-title{font-size: 36px;
    font-family: 'Noto Sans';
    font-weight: 700;
    line-height: 100%;
    }
  #lilacs-recent .rc-sub{    font-family: 'Noto Sans';
    font-size: 18px;
    font-weight: 400;
    letter-spacing: 0;
    line-height: 150%;
  }

  /* Botões prev/next */
  #lilacs-recent .rc-nav{
    display: flex;
    gap: 8px;
    flex-direction: row;
    justify-content: flex-end;
    padding-right: 30px;}
  #lilacs-recent .rc-btn{
    width:28px;height:28px;border-radius:999px;border:none;
    display:flex;align-items:center;justify-content:center;cursor:pointer;
    background:#00205C;color:#fff;
  }
  #lilacs-recent .rc-btn:hover{filter:brightness(1.08)}
  #lilacs-recent .rc-btn[disabled]{opacity:.45;cursor:not-allowed}
  #lilacs-recent .rc-btn svg{width:14px;height:14px}

  /* coluna direita preenche tudo e encosta na borda direita do monitor */
  #lilacs-recent .rc-viewport{
    flex:1 1 auto;
    overflow-x:hidden;
    min-width: 0; /* permite que o flex container encolha corretamente */
    /* sem padding/margem à direita -> full-bleed */
  }

  /* slider */
  #lilacs-recent .rc-track{
    display:flex; gap:14px; will-change:transform; transition:transform .45s ease;
    /* garante que o track não force overflow do ancestor flex */
    min-width: 0;
  }
  #lilacs-recent .rc-card{
   flex: 0 0 clamp(240px, 30vw, 360px);
    background: #00205C;
    color: #fff;
    border-radius: 12px;
    padding: 16px;
    min-height: 253px;
    position: relative;
    box-shadow: 0 10px 24px rgba(3, 10, 24, .25);
    /* permite rotações suaves e evita flicker/backface issues */
    transform-origin: 50% 50%;
    backface-visibility: hidden;
    will-change: transform;
  }
  #lilacs-recent .rc-card a{color:inherit; text-decoration:none}
  #lilacs-recent .rc-card h4{margin: 0;
    font-family: 'Noto Sans';
    font-weight: 400;
    font-size: 20px;
    line-height: 150%;
    padding: 20px;}
  #lilacs-recent .rc-go{
    position:absolute; right:10px; bottom:10px; width:26px; height:26px; border-radius:999px;
    background:rgba(255,255,255,.18); display:flex; align-items:center; justify-content:center;
  }
  #lilacs-recent .rc-go svg{width:14px;height:14px; color:#fff}

  /* responsivo: empilha mantendo alinhamento à esquerda e full-bleed na direita */
  @media (max-width: 920px){
    #lilacs-recent .rc-wrap{flex-direction:column; gap:14px}
    #lilacs-recent .rc-left{width:auto; padding-right:var(--gutter)}
  }
  CSS; ?>
  </style>

  <div class="rc-wrap">
    <div class="rc-left">
      <h2 class="rc-title"><?php echo esc_html($rc['title'] ?: 'Publicações recentes em saúde'); ?></h2>
      <?php if(!empty($rc['subtitle'])): ?>
        <p class="rc-sub"><?php echo esc_html($rc['subtitle']); ?></p>
      <?php endif; ?>
      <div class="rc-nav">
        <button class="rc-btn" id="rc-prev" aria-label="Anterior">
          <svg viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <button class="rc-btn" id="rc-next" aria-label="Próximo">
          <svg viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>
    </div>

    <div class="rc-viewport">
      <div class="rc-track" id="rc-track">
        <?php foreach($rc['items'] as $item):
          $t = trim($item['title'] ?? '');
          $u = esc_url($item['url'] ?? '#');
          if($t==='') continue; ?>
          <article class="rc-card">
            <a href="<?php echo $u; ?>">
              <h4><?php echo esc_html($t); ?></h4>
              <span class="rc-go" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </span>
            </a>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <script>
  (function(){
    const track = document.getElementById('rc-track');
    const prev  = document.getElementById('rc-prev');
    const next  = document.getElementById('rc-next');
    if(!track) return;

    function cardWidth(){
      const card = track.querySelector('.rc-card');
      return card ? (card.getBoundingClientRect().width + 14) : 320;
    }
    function viewWidth(){ return track.parentElement.getBoundingClientRect().width; }

    let offset = 0;
    function clamp(v,min,max){ return Math.max(min, Math.min(max,v)); }
    function maxOffset(){
      const tw = Array.from(track.children).reduce((acc,el)=> acc + el.getBoundingClientRect().width, 0)
                + (track.children.length-1)*14;
      return Math.max(0, tw - viewWidth());
    }
    function apply(){ track.style.transform = 'translateX(' + (-offset) + 'px)'; updateBtns(); }
    function updateBtns(){
      prev.disabled = (offset <= 0);
      next.disabled = (offset >= maxOffset() - 1);
    }
    function slide(dir){
      const step = Math.floor(viewWidth() / cardWidth()) * cardWidth() || cardWidth();
      offset = clamp(offset + (dir * step), 0, maxOffset());
      apply();
    }
    prev.addEventListener('click', ()=> slide(-1));
    next.addEventListener('click', ()=> slide(1));
    window.addEventListener('resize', apply);
    apply();
  })();
  </script>
</section>
<?php endif; ?>

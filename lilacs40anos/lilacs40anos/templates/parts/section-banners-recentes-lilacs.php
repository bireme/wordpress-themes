
<?php $sl = function_exists('bireme_get_lilacs_slider_meta') ? bireme_get_lilacs_slider_meta(get_the_ID()) : null; ?>
<?php if ($sl && !empty($sl['items'])): ?>
<section id="lilacs-banner" aria-label="Destaques">
  <style>
    #lilacs-banner{position:relative;background:#0b2a4f}
    #lilacs-banner .bnr-inner{max-width:1920px;margin:0 auto}
    #lilacs-banner .slider{position:relative;width:100%;overflow:hidden;height:min(60vw,520px)}
    #lilacs-banner .slides{display:flex;width:100%;height:100%;transition:transform .6s ease-in-out;will-change:transform}
    #lilacs-banner .slide{flex:0 0 100%;height:100%;display:flex;align-items:center;justify-content:center;background:#000}
    #lilacs-banner .slide img{width:100%;height:100%;object-fit:cover;display:block}
    #lilacs-banner .dots{position:absolute;left:50%;bottom:12px;transform:translateX(-50%);z-index:3;display:flex;gap:8px}
    #lilacs-banner .dot{width:10px;height:10px;border-radius:999px;background:rgba(255,255,255,.45);border:none;cursor:pointer;transition:transform .15s, background .2s}
    #lilacs-banner .dot[aria-current="true"]{background:#fff;transform:scale(1.15)}
    @media (max-width:640px){#lilacs-banner .slider{height:min(70vw,420px)}}
  </style>

  <div class="bnr-inner">
    <div class="slider" data-autoplay="6000">
      <div class="slides" role="list" aria-live="polite">
        <?php foreach ($sl['items'] as $it): 
          if (empty($it['img_url'])) continue;
          $img = esc_url($it['img_url']);
          $alt = esc_attr($it['alt'] ?? '');
          $url = !empty($it['url']) ? esc_url($it['url']) : '';
        ?>
          <figure class="slide" role="listitem">
            <?php if ($url): ?><a href="<?php echo $url; ?>"><?php endif; ?>
              <img src="<?php echo $img; ?>" alt="<?php echo $alt; ?>">
            <?php if ($url): ?></a><?php endif; ?>
          </figure>
        <?php endforeach; ?>
      </div>
      <div class="dots" aria-label="Navegação de slides"></div>
    </div>
  </div>

  <script>
    (function(){
      const root = document.querySelector('#lilacs-banner .slider');
      if(!root) return;
      const track = root.querySelector('.slides');
      const slides = Array.from(track.children);
      const dotsWrap = root.querySelector('.dots');

      if(slides.length <= 1){
        // sem dots/autoplay quando só há 1 slide
        return;
      }

      // cria dots
      slides.forEach((_,i)=>{
        const b = document.createElement('button');
        b.className = 'dot';
        b.type = 'button';
        b.setAttribute('aria-label','Ir para o slide '+(i+1));
        if(i===0) b.setAttribute('aria-current','true');
        dotsWrap.appendChild(b);
      });

      const dots = Array.from(dotsWrap.children);
      let idx = 0, timer = null, delay = parseInt(root.dataset.autoplay || '6000', 10);

      function go(i){
        idx = (i+slides.length)%slides.length;
        track.style.transform = 'translateX('+(-100*idx)+'%)';
        dots.forEach((d,k)=> d.toggleAttribute('aria-current', k===idx));
      }
      dots.forEach((d,i)=> d.addEventListener('click', ()=>{ go(i); restart(); }));

      function start(){ timer = setInterval(()=> go(idx+1), delay); }
      function stop(){ if(timer){ clearInterval(timer); timer=null; } }
      function restart(){ stop(); start(); }

      root.addEventListener('mouseenter', stop);
      root.addEventListener('mouseleave', start);

      start();
    })();
  </script>
</section>
<?php endif; ?>

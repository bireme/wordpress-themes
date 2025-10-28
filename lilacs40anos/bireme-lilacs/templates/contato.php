<?php
get_template_part('templates/parts/section', 'banner-como-pesquisar'); 
$__faq_cats = get_post_meta(get_the_ID(), '_lilacs_faq_sidebar_cats', true);
$__faq_cats = is_array($__faq_cats) ? array_map('intval', $__faq_cats) : [];
?>

<section id="faq-contato" class="faq-section">
  <style>
    :root{ --line:#e6ebf2; --text:#0b2144; --muted:#6b7a90; }
    #faq-contato{max-width:1100px;margin:28px auto;padding:0 16px;display:grid;grid-template-columns:320px 1fr;gap:28px;align-items:start;font-family:'Noto Sans',sans-serif;color:var(--text);position:relative;}

    .faq-toggle{position:absolute;right:-32px;top:-25px;width:32px;height:32px;background:#F1F1F1;border:1px solid var(--line);cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 2px rgba(10,20,40,.05);transition:background .2s;}
    .faq-toggle:hover{background:#f6f8fc}
    .faq-toggle img{width:18px;height:18px;transition:transform .18s ease;transform-origin:center;}
    #faq-contato.is-collapsed .faq-toggle img{transform:scaleX(-1)}

    .faq-side{background:#fff;border-radius:10px;padding:16px;position:relative;border-right:1px solid #00205c17;}
    .faq-side h2{font-size:28px;font-weight:800;margin:0 0 16px;color:#0A2C5C}

    .faq-search{position:relative;margin-bottom:18px;}
    .faq-search input{width:100%;height:40px;border:1px solid var(--line);background:#F1F1F1;border-radius:10px;padding:0 44px 0 14px;font-size:14px;outline:none;}
    .faq-search span{position:absolute;right:10px;top:50%;transform:translateY(-50%);width:20px;height:20px;color:#406296;}

    /* categorias */
    .faq-item{padding:16px 14px;border-top:1px solid #EFF2F6;display:flex;justify-content:space-between;align-items:center;cursor:pointer;}
    .faq-item:first-child{border-top:none;}
    .faq-item span{font-weight:700;color:#0A2C5C}

    /* perguntas (apenas títulos, sem chevron) */
    .faq-qa-list{padding:0 6px 8px 6px;display:none;}
    .qa-title{border-top:1px solid #EFF2F6;}
    .qa-title button{width:100%;text-align:left;background:none;border:none;padding:10px 0;cursor:pointer;color:#0A2C5C;font-size:14px;font-weight:400;}

    .faq-content{position:relative;padding-left:32px;}
    .faq-badge{position:absolute;left:-16px;top:-10px;width:30px;height:30px;background:#f3f6fb;border:1px solid var(--line);border-radius:6px;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 2px rgba(10,20,40,.05);font-weight:700;color:#163b72;}
    .faq-content h3{font-size:28px;margin:6px 0 18px;color:#0A2C5C;text-align:center;}
    .faq-content img{width:100%;max-width:520px;margin-bottom:16px;border-radius:8px;}
    .faq-content p{max-width:460px;font-size:14px;color:#264268;line-height:1.55;margin-bottom:10px;}
    .faq-buttons{display:flex;gap:14px;}
    .faq-buttons button{border:none;border-radius:999px;padding:12px 22px;font-weight:700;font-size:14px;color:#fff;cursor:pointer;box-shadow:0 1px 2px rgba(10,20,40,.05)}
    .faq-buttons .lilacs{background:#0E66C6;}
    .ewd-ufaq-post-margin-symbol.ewd-ufaq-{display:none !Important;}
    .faq-buttons .revistas{background:#0B5AAE;}

    #faq-contato.is-collapsed{grid-template-columns:44px 1fr;}
    #faq-contato.is-collapsed .faq-side{padding:8px 6px;}
    #faq-contato.is-collapsed .faq-side > *:not(.faq-toggle){display:none;}
    #faq-contato.is-collapsed .faq-toggle{right:6px;top:6px;}
    .img-faq{width: 60%;
    float: left;}
    .faq-content-text{
        width: 40%;
    float: left;
    }

    @media(max-width:980px){
      .faq-toggle{display:none!important;}
      #faq-contato{grid-template-columns:1fr;}
      .faq-content{padding-left:0;}
    }
  </style>

  <aside class="faq-side">
    <button id="faq-toggle" class="faq-toggle" aria-expanded="true" title="Encolher barra lateral">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/toogle.png' ); ?>" alt="Toggle"/>
    </button>

    <h2>Perguntas Frequentes</h2>

    <div class="faq-search">
      <input id="faq-search" type="search" placeholder="Pesquise na FAQ" aria-label="Pesquisar na FAQ"/>
      <span>
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20L16.5 16.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </span>
    </div>

    <div id="faq-cats"></div>
  </aside>

<?php
$faq_box_title = get_post_meta(get_the_ID(), '_lilacs_faq_box_title', true) ?: 'Contato';
$faq_box_desc  = get_post_meta(get_the_ID(), '_lilacs_faq_box_desc',  true) ?: 'Dúvida sobre como pesquisar...';
$faq_box_imgid = (int) get_post_meta(get_the_ID(), '_lilacs_faq_box_img_id', true);
$faq_box_img   = $faq_box_imgid ? wp_get_attachment_image_url($faq_box_imgid, 'large') : 'https://dummyimage.com/800x280/f5f8fd/93a7c3&text=Ilustra%C3%A7%C3%A3o+FAQ';
$btn1_text = get_post_meta(get_the_ID(), '_lilacs_faq_btn1_text', true) ?: 'LILACS';
$btn1_url  = get_post_meta(get_the_ID(), '_lilacs_faq_btn1_url',  true) ?: '#';
$btn2_text = get_post_meta(get_the_ID(), '_lilacs_faq_btn2_text', true) ?: 'Seleção de revistas';
$btn2_url  = get_post_meta(get_the_ID(), '_lilacs_faq_btn2_url',  true) ?: '#';

?>
<div class="faq-content" id="faq-detail">

  <h3><?php echo esc_html($faq_box_title); ?></h3>

  <div class="img-faq">
    <img src="<?php echo esc_url($faq_box_img); ?>" alt="">
   </div>

 <div class="faq-content-text">
  <div class="faq-body">
    <?php echo wpautop( wp_kses_post($faq_box_desc) ); ?>
  </div>
  <div class="faq-buttons">
    <button class="lilacs"><a target="_blank" style="color:#fff !Important; text-decoration:none !Important;" href="<?=$btn1_url?>"><?=$btn1_text?></a></button>
    <button class="revistas"><a target="_blank" style="color:#fff !Important; text-decoration:none !Important;" href="<?=$btn2_url?>"><?=$btn2_text?></a></button>
  </div>
</div>
</div>

  <script>
  (function(){
    const section=document.getElementById('faq-contato');
    const toggle=document.getElementById('faq-toggle');
    if(toggle && section){
      const saved=localStorage.getItem('faqCollapsed')==='1';
      if(saved){section.classList.add('is-collapsed');toggle.setAttribute('aria-expanded','false');}
      toggle.addEventListener('click',()=>{
        const collapsed=section.classList.toggle('is-collapsed');
        toggle.setAttribute('aria-expanded',String(!collapsed));
        localStorage.setItem('faqCollapsed',collapsed?'1':'0');
      });
    }

    const REST_BASE = '<?php echo esc_url_raw( get_rest_url() ); ?>'.replace(/\/+$/,'');
    const SELECTED  = <?php echo wp_json_encode($__faq_cats); ?>;
    const $catsWrap = document.getElementById('faq-cats');
    const $search   = document.getElementById('faq-search');
    const $detail   = document.getElementById('faq-detail');
    const chevron   = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 10l4 4 4-4" stroke="#0b2144" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

    function el(tag, cls, html){const n=document.createElement(tag);if(cls)n.className=cls;if(html!=null)n.innerHTML=html;return n;}

    function showPost(post){
      const title=(post?.title?.rendered)||'';
      const content=(post?.content?.rendered)||'<p>Sem conteúdo.</p>';
      $detail.innerHTML='<h3>'+title+'</h3><div class="faq-body">'+content+'</div>';
    }

    function renderQuestionTitle(post){
      const li=el('div','qa-title');
      const btn=el('button',null,'<span class="t">'+(post.title?.rendered||'')+'</span>');
      btn.type='button';
      btn.addEventListener('click',async()=>{
        if(post.content?.rendered){showPost(post);return;}
        try{
          const r=await fetch(REST_BASE+'/wp/v2/ufaq/'+post.id);
          const full=await r.json();showPost(full);
        }catch(e){console.error(e);}
      });
      li.appendChild(btn);
      return li;
    }

    function renderCategory(term){
      const hdr=el('div','faq-item','<span>'+term.name+'</span>'+chevron);
      hdr.setAttribute('data-term',term.id);
      hdr.setAttribute('aria-expanded','false');
      const body=el('div','faq-qa-list');
      hdr.addEventListener('click',async()=>{
        const open=body.style.display!=='none';
        if(open){body.style.display='none';hdr.setAttribute('aria-expanded','false');return;}
        body.style.display='block';hdr.setAttribute('aria-expanded','true');
        if(!body.dataset.loaded){
          body.dataset.loaded='1';body.innerHTML='<div style="color:#6b7a90;font-size:13px;padding:6px 2px 10px;">Carregando…</div>';
          try{
            const resp=await fetch(REST_BASE+'/wp/v2/ufaq?per_page=100&_fields=id,title,content&ufaq-category='+term.id);
            const posts=await resp.json();body.innerHTML='';
            if(Array.isArray(posts)&&posts.length){posts.forEach(p=>body.appendChild(renderQuestionTitle(p)));}
            else body.innerHTML='<div style="color:#6b7a90;font-size:13px;padding:6px 2px 10px;">Sem perguntas nesta categoria.</div>';
          }catch(e){console.error(e);body.innerHTML='<div style="color:#b00020;font-size:13px;">Erro ao carregar.</div>';}
        }
      });
      return {hdr,body};
    }

    async function loadCategories(){
      try{
        let url=REST_BASE+'/wp/v2/ufaq-category?per_page=100&hide_empty=false';
        if(Array.isArray(SELECTED)&&SELECTED.length)url+='&include='+SELECTED.join(',');
        const r=await fetch(url);let terms=await r.json();if(!Array.isArray(terms))terms=[];
        if(SELECTED.length)terms.sort((a,b)=>SELECTED.indexOf(a.id)-SELECTED.indexOf(b.id));
        $catsWrap.innerHTML='';if(!terms.length){$catsWrap.innerHTML='<div style="color:#6b7a90;font-size:13px;">Nenhuma categoria configurada.</div>';return;}
        terms.forEach(t=>{const{hdr,body}=renderCategory(t);$catsWrap.appendChild(hdr);$catsWrap.appendChild(body);});
      }catch(e){console.error(e);$catsWrap.innerHTML='<div style="color:#b00020;font-size:13px;">Falha ao carregar.</div>';}
    }

    function applyFilter(q){
      const term=(q||'').trim().toLowerCase();
      const items=$catsWrap.querySelectorAll('.faq-item');
      items.forEach(hdr=>{
        const title=hdr.querySelector('span')?.textContent?.toLowerCase()||'';
        const body=hdr.nextElementSibling?.classList.contains('faq-qa-list')?hdr.nextElementSibling:null;
        let match=title.includes(term);
        if(body&&body.dataset.loaded){
          let any=false;
          body.querySelectorAll('.qa-title').forEach(li=>{
            const t=li.querySelector('.t')?.textContent?.toLowerCase()||'';
            const ok=t.includes(term);
            li.style.display=ok?'':'none';
            if(ok)any=true;
          });
          if(!match)match=any;
          if(term&&body.style.display==='none'&&any){body.style.display='block';hdr.setAttribute('aria-expanded','true');}
        }else if(term&&!body?.dataset.loaded){hdr.click();}
        hdr.style.display=match?'none'===''?'' : '':'none'; // mantem visível se combinar
        if(!match)hdr.style.display='none';
      });
    }

    $search&&$search.addEventListener('input',e=>applyFilter(e.target.value));
    loadCategories();
  })();
  </script>
</section>

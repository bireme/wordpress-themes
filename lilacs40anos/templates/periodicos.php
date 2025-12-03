<?php
  get_template_part('templates/parts/section', 'banner-como-pesquisar');

?>

<section id="bvs-page" aria-label="Periódicos – BVS">
  <style>
    :root{
      --bg:#fff; --panel:#fff; --text:#0b2144; --muted:#6b7a90; --line:#e6ebf2;
      --accent:#163b72; --accent-2:#0a6ad8; --chip:#eef3fb;
    }

    #bvs-page{background:#fff; padding:18px 12px 32px;}
    #bvs-page *{box-sizing:border-box; font-family: 'Noto Sans';}

    /* Topbar */
    .bvs-top{max-width:1360px; margin:0 auto 12px; display:flex; justify-content:flex-end;}
    .bvs-search{position:relative; flex:1; max-width:420px;}
    .bvs-search input{
      width:100%; border:1px solid var(--line); background:#F1F1F1; border-radius:12px; padding:14px 44px 14px 16px;
      font-size:15px; outline:none; transition:.2s border-color;
    }
    .bvs-search input:focus{border-color:var(--accent-2)}
    .bvs-search .icon{position:absolute; right:12px; top:50%; transform:translateY(-50%); width:18px; height:18px; display:block;}
    .bvs-search .icon img{width:100%; height:100%; display:block; object-fit:contain;}
    .bvs-updated{color:var(--muted); font-size:14px}


    /* botão de colapsar */
    .bvs-toggle{
      position: absolute; right: -32px; top: -25px;
      width: 32px; height: 32px; border-radius: 0px;
      background:#F1F1F1;
      border: 1px solid var(--line); cursor:pointer;
      display:flex; align-items:center; justify-content:center;
      box-shadow:0 1px 2px rgba(10,20,40,.05); color:var(--muted); font-size:16px;
    }
    .bvs-toggle:hover{background:#f6f8fc}

    /* Força remoção de pseudoelementos (seguro caso existam regras anteriores) */
    .bvs-toggle::after{ content: none !important; }

    /* Ajuste para a imagem dentro do botão (tamanho/alinhamento) + animação */
    .bvs-toggle img{
      width:18px; height:18px; display:block; object-fit:contain;
      transition: transform .18s ease;
      transform-origin: center;
    }

    /* Quando o painel estiver colapsado, espelha horizontalmente a imagem */
    #bvs-page.is-collapsed .bvs-toggle img{
      transform: scaleX(-1);
    }

    /* sidebar identificável para o botão */
    .bvs-side{
      position:relative;
      border-right: 1px solid #00205c17;
      border-radius: 0;
    }

    /* estado colapsado */
    #bvs-page.is-collapsed .bvs-wrap{grid-template-columns:44px 1fr;}
    #bvs-page.is-collapsed .bvs-side{padding:8px 6px}
    #bvs-page.is-collapsed .bvs-side > *:not(.bvs-toggle){display:none}
    #bvs-page.is-collapsed .bvs-toggle{right:6px; top:6px}

    /* ícone vira “abrir” quando colapsado */
    #bvs-page.is-collapsed .bvs-toggle[data-dir="left"]::after{content:"›";}
    .bvs-toggle::after{content:"‹";}        /* aberto = “recolher” */
    #bvs-page.is-collapsed .bvs-toggle{color:var(--text)}

    /* ---- new: hide toggle on small screens to avoid horizontal scroll ---- */
    @media (max-width: 980px){
      .bvs-toggle{
        display: none !important;
      }

      .bvs-main{
        max-width:400px;
      }

      /* ensure sidebar never exceeds viewport width on mobile */
      .bvs-side{
        width: 100%;
        max-width: calc(100vw - 24px); /* account for #bvs-page horizontal padding (12px each side) */
        box-sizing: border-box;
        margin: 0 auto;
        padding: 12px; /* slightly reduce padding on very small screens */
        border-radius: 10px;
        overflow-x: hidden; /* defensive: prevent accidental horizontal overflow */
      }

      /* make the inner wrap respect viewport and padding */
      .bvs-wrap{
        padding: 0; /* avoid extra horizontal space inside the centered container */
        grid-template-columns: 1fr;
        max-width: 1360px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 22px;
        justify-content: center;
        align-items: start;
      }
    }

    /* Layout grid */
    .bvs-wrap{max-width:1360px; margin:0 auto; display:grid; grid-template-columns: 300px 1fr; gap:22px;}
    @media (max-width: 980px){ .bvs-wrap{grid-template-columns:1fr;} }

    /* Sidebar (País) */
    .bvs-side{background:var(--panel); border-radius:14px; padding:16px; box-shadow:0 1px 2px rgba(10,20,40,.05)}
    .bvs-side h3{margin:4px 0 12px; color:var(--text); font-size:22px; font-weight:800}
    .bvs-chip{
      display:flex; align-items:center; justify-content:space-between;
      background:#F1F1F1; border-radius:12px; padding:10px 12px; margin-bottom:8px; cursor:pointer; user-select:none;
      font-weight:700; color:#1a2b4a;
    }
    .bvs-chip.is-active{background:#F1F1F1}
    .bvs-countries{margin-top:10px; max-height:66vh; overflow:auto; padding-right:4px;}
    .bvs-countries .row{
      display:flex; align-items:center; justify-content:space-between; padding:10px 8px; border-radius:10px;
      color:var(--text); cursor:pointer; transition:.15s background;
    }
    .bvs-countries .row:hover{background:#f1f5fb}
    .bvs-countries .row.is-active{background:#eaf1ff}
    .bvs-countries .name,
    .bvs-group .body .name{
      font-weight: 500 !important;
      font-family: 'Noto Sans' !important;
      color: #00205C !important;
    }
    .bvs-countries .count{color:var(--muted); font-weight:700}

    /* make "Assunto" rows look and behave like País rows */
    .bvs-group .body .row{
      display:flex; align-items:center; justify-content:space-between; padding:10px 8px; border-radius:10px;
      color:var(--text); cursor:pointer; transition:.15s background;
    }
    .bvs-group .body .row:hover{background:#f1f5fb}
    .bvs-group .body .row.is-active{background:#eaf1ff}
    .bvs-group .body .name{font-weight:600}
    .bvs-group .body .count{color:var(--muted); font-weight:700}

    /* Main (Tabela) */
    .bvs-main{
      background: var(--panel);
      border-radius: 14px;
      padding: 8px;
      box-shadow: 0 1px 2px rgba(10, 20, 40, .05);
      overflow-x: scroll;
      background:var(--panel);
      border-radius:14px;
      padding:8px;
      box-shadow:0 1px 2px rgba(10,20,40,.05)
    }
    .bvs-table{width:100%; border-collapse:separate; border-spacing:0; font-size:15px}
    .bvs-thead{position:sticky; top:0; background:linear-gradient(#fff,#fff); z-index:2}
    .bvs-thead th{
      text-align:left; padding:14px 12px; color:var(--muted); font-size:12px; letter-spacing:.08em; text-transform:uppercase;
      border-bottom:1px solid var(--line);
    }
    .bvs-tbody td{padding:13px 12px; border-bottom:1px solid var(--line); color:var(--text)}
    /* linhas ímpares = branco; pares = #E2E2E280 (com fallback rgba) */
    .bvs-tbody tr:nth-child(odd){ background: #fff; }
    .bvs-tbody tr:nth-child(even){
      background: rgba(226,226,226,0.5); /* fallback */
      background: #E2E2E280 !important;
    }
    .bvs-col-idx{width:56px; color:var(--muted)}
    .bvs-col-title a{
      color: var(--accent);
      text-decoration: none;
      font-family: 'Noto Sans' !important;
      font-weight: 400;
    }
    .bvs-col-title a:hover{text-decoration:underline}
    .bvs-col-issn{width:140px; color:#243b66; font-weight:700}
    .bvs-col-code{width:150px; color:#243b66; font-weight:400}
    td.bvs-col-issn{font-weight:400;}

    /* Pagination */
    .bvs-pager{display:flex; align-items:center; justify-content:center; gap:6px; padding:12px}
    .bvs-pager button{
      border:1px solid var(--line); background:#fff; border-radius:10px; padding:8px 10px; min-width:36px;
      cursor:pointer; color:var(--text)
    }
    .bvs-pager button[disabled]{opacity:.5; cursor:default}
    .bvs-pager .current{background:#edf3ff; border-color:#d7e4ff; font-weight:800}

    /* Tiny helpers */
    .badge{
      display:inline-block; padding:2px 8px; border-radius:999px;
      background:var(--chip); color:#194a91; font-size:12px; font-weight:700
    }

    /* grupos na sidebar (País / Assunto / etc.) */
    .bvs-group{margin-top:16px;}
    .bvs-group .hdr{
      display:flex; align-items:center; justify-content:space-between;
      font-weight:800; color:var(--text); font-size:16px; cursor:pointer; user-select:none;
      padding:8px 2px;
    }
    .bvs-group .hdr .caret{transition:.15s transform; font-size:14px; color:var(--muted)}

    /* new: style the chevron image and rotate when collapsed */
    .bvs-group .hdr .caret img{
      width:14px;
      height:14px;
      display:block;
      object-fit:contain;
      transition: transform .15s ease;
      transform-origin: center;
    }
    .bvs-group.is-collapsed .hdr .caret img{
      transform: rotate(90deg);
    }

    .bvs-group .body{max-height:60vh; overflow:auto; padding-right:4px;}
    .bvs-sep{height:1px; background:var(--line); margin:12px 0;}

  </style>

  <div class="bvs-top">
    <div class="bvs-updated">Última atualização: <span id="bvs-updated">DD/MM/AAAA</span></div>
  </div>

  <div class="bvs-wrap">
    <!-- Sidebar -->
    <aside class="bvs-side" id="bvs-filters">
      <button id="bvs-toggle" class="bvs-toggle" aria-expanded="true" aria-controls="bvs-filters" title="Encolher filtros">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/toogle.png' ); ?>" alt="Toggle">
      </button>

      <!-- BUSCA agora só na coluna esquerda -->
      <div class="bvs-search" style="margin:10px 0 12px;">
        <input id="bvs-q" type="search" placeholder="Pesquise por título, ISSN ou códigos" aria-label="Pesquisar">
        <span class="icon">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/Vector.png' ); ?>" alt="">
        </span>
      </div>

      <h3>País</h3>

      <div id="bvs-total" class="bvs-chip" role="button" tabindex="0" aria-pressed="true">
        <span>Total Geral</span><span class="badge" id="bvs-total-count">0</span>
      </div>

      <div id="bvs-countries" class="bvs-countries" role="list"></div>

      <div class="bvs-sep"></div>

      <!-- Assunto -->
      <div id="bvs-assunto" class="bvs-group">
        <div class="hdr" id="bvs-assunto-toggle" aria-expanded="true">
          <span>Área</span>
          <span class="caret">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/chevron.png' ); ?>" alt="">
          </span>
        </div>
        <div class="body" id="bvs-thematics" role="list"></div>
      </div>

    </aside>

    <!-- Main table -->
    <main class="bvs-main">
      <table class="bvs-table" aria-describedby="bvs-summary">
        <thead class="bvs-thead">
          <tr>
            <th class="bvs-col-idx">#</th>
            <th class="bvs-col-title">Título completo</th>
            <th class="bvs-col-issn">ISSN</th>
            <th class="bvs-col-code">Código do Editor</th>
            <th class="bvs-col-code">Código do CC</th>
          </tr>
        </thead>
        <tbody id="bvs-tbody" class="bvs-tbody"></tbody>
      </table>
      <div id="bvs-pager" class="bvs-pager" aria-label="Paginação"></div>
    </main>
  </div>

  <script>
  (function(){
    // ===== Endpoints e constantes (dinâmicos) =====
    const API_URL = <?php echo json_encode( untrailingslashit( get_rest_url(null, 'test/v1/bvs') ) ); ?>;
    const JOURNAL_BASE = <?php echo json_encode( untrailingslashit( get_rest_url(null, 'test/v1/bvs/journal') ) ); ?>;
    const JOURNAL_URL = (id) => `${JOURNAL_BASE}/${id}`;
    const SEARCH_BASE = <?php echo json_encode( untrailingslashit( get_rest_url(null, 'test/v1/bvs/journals/search') ) ); ?>;
    const SEARCH_URL  = (ta, start=0, rows=1000) => `${SEARCH_BASE}?thematic_area=${encodeURIComponent(ta)}&start=${start}&rows=${rows}`;
    const FETCH_ROWS  = 1000; // paginação da API de busca por Assunto
    const LANG = "pt-br";
    const PER_PAGE = 50;

    // ===== Estado =====
    const S = {
      docs: [],
      countriesFacet: [],
      search: "",
      countryRaw: null,
      page: 1,
      thematicFacet: [],
      thematicSel: null,
      assuntoOpen: true,
      masterCount: null,        // total de "Todos" (dataset sem filtro de Assunto)
      initialCountryLabel: null,// label vinda pela URL
      hasInitialCountryParam: false // indica se veio parâmetro de país na URL
    };

    // ===== Captura de país inicial via URL (?p=Brasil ou ?pais=Brasil) =====
    (function(){
      try{
        const params = new URLSearchParams(window.location.search);
        const fromP    = params.get('p');
        const fromPais = params.get('pais');
        const val = (fromP || fromPais || "").trim();
        if(val){
          S.initialCountryLabel = val;
          S.hasInitialCountryParam = true; // usado depois para scroll
        }
      } catch(e){
        // silencioso; não quebra nada se URLSearchParams não estiver disponível
      }
    })();

    // ===== Refs DOM =====
    const $tbody       = document.getElementById("bvs-tbody");
    const $pager       = document.getElementById("bvs-pager");
    const $countries   = document.getElementById("bvs-countries");
    const $totalChip   = document.getElementById("bvs-total");
    const $totalCount  = document.getElementById("bvs-total-count");
    const $updated     = document.getElementById("bvs-updated");
    const $q           = document.getElementById("bvs-q");

    // ===== Helpers =====
    function labelFromMulti(str, lang=LANG){
      if(typeof str!=="string") return "";
      const parts=str.split("|"), map={};
      for(const p of parts){
        const i=p.indexOf("^");
        if(i>-1) map[p.slice(0,i)] = p.slice(i+1);
      }
      return map[lang] || map["pt-br"] || map["en"] || parts[0].split("^").pop() || str;
    }
    const fmtDate = (yyyymmdd)=> yyyymmdd && String(yyyymmdd).length===8
      ? `${yyyymmdd.slice(6,8)}/${yyyymmdd.slice(4,6)}/${yyyymmdd.slice(0,4)}` : "—";
    const getFirstISSN = a => Array.isArray(a)&&a.length ? a[0] : "—";
    const byTitle = (a,b)=> a.title.localeCompare(b.title,'pt',{sensitivity:'base'});

    // ====== DETALHES (2ª API) ======
    const detailCache = new Map();
    const inflight = new Map();

    function getDetailIdFromDoc(doc){ return doc.django_id; }

    async function fetchDetailOnce(detailId){
      if(detailCache.has(detailId)) return detailCache.get(detailId);
      if(inflight.has(detailId))    return inflight.get(detailId);

      const p = fetch(JOURNAL_URL(detailId))
        .then(r => r.json())
        .then(j => {
          const d = j?.data || {};
          const editor = d?.descriptors?.editor_cc_code ?? d?.editor_cc_code ?? "";
          const cc     = d?.indexer_cc_code ?? d?.cooperative_center_code ?? "";
          const out = { editor_code: editor || "—", cc_code: cc || "—" };
          detailCache.set(detailId, out);
          inflight.delete(detailId);
          return out;
        })
        .catch(() => { inflight.delete(detailId); return { editor_code:"—", cc_code:"—" }; });

      inflight.set(detailId, p);
      return p;
    }

    async function hydrateVisibleCodes(pageDocs){
      const limit = 8;
      const tasks = [];
      for(const d of pageDocs){
        const id = getDetailIdFromDoc(d);
        if(!id || detailCache.has(id)) continue;
        tasks.push(()=>fetchDetailOnce(id).then((codes)=>{
          d.editor_code = codes.editor_code;
          d.cc_code = codes.cc_code;
          const row = document.querySelector(`tr[data-row-id="${d.id}"]`);
          if(row){
            row.querySelector('[data-cell="editor"]').textContent = d.editor_code;
            row.querySelector('[data-cell="cc"]').textContent     = d.cc_code;
          }
        }));
      }
      let i=0;
      const run = async()=>{
        while(i<tasks.length){
          const batch = tasks.slice(i, i+=limit).map(fn=>fn());
          await Promise.all(batch);
        }
      };
      return run();
    }

    // ===== Sidebar: País =====
    function renderCountries(){
      $countries.innerHTML = "";
      const frag = document.createDocumentFragment();
      S.countriesFacet.forEach(item=>{
        const row = document.createElement("div");
        row.className="row"+(S.countryRaw===item.raw?" is-active":"");
        row.setAttribute("role","button"); row.setAttribute("tabindex","0");
        row.innerHTML = `<span class="name">${item.label}</span><span class="count">${item.count}</span>`;
        row.addEventListener("click", ()=>{
          S.countryRaw=item.raw;
          S.page=1;
          renderAll();
        });
        row.addEventListener("keydown", e=>{
          if(e.key==='Enter'||e.key===' '){
            e.preventDefault();
            row.click();
          }
        });
        frag.appendChild(row);
      });
      $countries.appendChild(frag);
    }

    // ===== Sidebar: Assunto =====
    function renderAssunto(){
      const $grp  = document.getElementById("bvs-assunto");
      const $list = document.getElementById("bvs-thematics");
      $grp.classList.toggle("is-collapsed", !S.assuntoOpen);
      document.getElementById("bvs-assunto-toggle")
        .setAttribute("aria-expanded", String(S.assuntoOpen));

      $list.innerHTML = "";
      if(!S.assuntoOpen) return;

      const frag = document.createDocumentFragment();

      // --- Linha "Todos"
      const rowAll = document.createElement("div");
      rowAll.className = "row" + (S.thematicSel==null ? " is-active" : "");
      rowAll.setAttribute("role","button"); rowAll.setAttribute("tabindex","0");
      const allCount = S.masterCount ?? S.docs.length;
      rowAll.innerHTML = `<span class="name">Todos</span><span class="count">${allCount}</span>`;
      rowAll.addEventListener("click", async ()=>{
        if(S.thematicSel!==null){
          S.thematicSel = null;
          await loadData(null); // volta para dataset completo
        }
      });
      rowAll.addEventListener("keydown", e=>{
        if(e.key==='Enter'||e.key===' '){
          e.preventDefault();
          rowAll.click();
        }
      });
      frag.appendChild(rowAll);

      // --- Demais assuntos
      S.thematicFacet.forEach(item=>{
        const row = document.createElement("div");
        row.className = "row" + (S.thematicSel===item.key ? " is-active" : "");
        row.setAttribute("role","button"); row.setAttribute("tabindex","0");
        row.innerHTML = `<span class="name">${item.label}</span><span class="count">${item.count}</span>`;
        row.addEventListener("click", async ()=>{
          S.thematicSel = (S.thematicSel===item.key ? null : item.key);
          await loadData(S.thematicSel);
        });
        row.addEventListener("keydown", e=>{
          if(e.key==='Enter'||e.key===' '){
            e.preventDefault();
            row.click();
          }
        });
        frag.appendChild(row);
      });

      $list.appendChild(frag);
    }
    document.getElementById("bvs-assunto-toggle").addEventListener("click", ()=>{
      S.assuntoOpen = !S.assuntoOpen;
      renderAssunto();
    });

    // ===== Filtragem local (país + busca, incluindo ISSN) =====
    function filteredDocs(){
      let list = S.docs;
      if (S.countryRaw)
        list = list.filter(d => d.country_raw === S.countryRaw);

      if (S.search) {
        const q = S.search.toLowerCase();
        list = list.filter(d => {
          const title  = d.title?.toLowerCase()  || "";
          const editor = d.editor_code?.toLowerCase() || "";
          const cc     = d.cc_code?.toLowerCase()     || "";
          const issnStr = Array.isArray(d.issn)
            ? d.issn.join(" ").toLowerCase()
            : "";
          return (
            title.includes(q) ||
            editor.includes(q) ||
            cc.includes(q) ||
            issnStr.includes(q) // <<< permite buscar por ISSN
          );
        });
      }
      return list;
    }

    // ===== Tabela + Paginação =====
    async function renderTable(){
      const list = filteredDocs();
      const total = list.length;
      const pages = Math.max(1, Math.ceil(total / PER_PAGE));
      if(S.page>pages) S.page = pages;
      const start = (S.page-1)*PER_PAGE;
      const pageDocs = list.slice(start, start+PER_PAGE);

      $tbody.innerHTML = "";
      const frag = document.createDocumentFragment();

      pageDocs.forEach((d, idx)=>{
        const detailId  = getDetailIdFromDoc(d);
        const cached    = detailId && detailCache.get(detailId);
        const editorCode= (d.editor_code || cached?.editor_code) ?? "…";
        const ccCode    = (d.cc_code     || cached?.cc_code)     ?? "…";
        const primaryLink = Array.isArray(d.link)&&d.link.length ? d.link[0] : null;

        const tr = document.createElement("tr");
        tr.setAttribute("data-row-id", d.id);
        tr.innerHTML = `
          <td class="bvs-col-idx">${start+idx+1}</td>
          <td class="bvs-col-title">${primaryLink ? `<a href="${primaryLink}" target="_blank" rel="noopener">${d.title}</a>` : d.title}</td>
          <td class="bvs-col-issn">${getFirstISSN(d.issn)}</td>
          <td class="bvs-col-code" data-cell="editor">${editorCode}</td>
          <td class="bvs-col-code" data-cell="cc">${ccCode}</td>
        `;
        frag.appendChild(tr);
      });

      $tbody.appendChild(frag);

      hydrateVisibleCodes(pageDocs);

      $pager.innerHTML = "";
      const makeBtn=(label, disabled, onClick, isCurrent=false)=>{
        const b=document.createElement("button");
        b.textContent=label; if(disabled) b.disabled=true; if(isCurrent) b.classList.add("current");
        if(onClick) b.addEventListener("click", onClick); return b;
      };
      $pager.appendChild(makeBtn("‹", S.page===1, ()=>{S.page--; renderTable();}));
      const addPage=p=> $pager.appendChild(makeBtn(String(p), false, ()=>{S.page=p; renderTable();}, S.page===p));
      const dots=()=>{const s=document.createElement("span"); s.textContent="…"; s.style.padding="0 6px"; $pager.appendChild(s);};

      if(pages<=7){
        for(let p=1;p<=pages;p++) addPage(p);
      } else {
        addPage(1); if(S.page>3) dots();
        const a=Math.max(2,S.page-1), b=Math.min(pages-1,S.page+1);
        for(let p=a;p<=b;p++) addPage(p);
        if(S.page<pages-2) dots();
        addPage(pages);
      }
      $pager.appendChild(makeBtn("›", S.page===pages, ()=>{S.page++; renderTable();}));

      document.getElementById("bvs-total-count").textContent = String(filteredDocs().length || S.docs.length);
    }

    function renderAll(){
      renderCountries();
      renderAssunto();
      $totalChip.classList.toggle("is-active", !S.countryRaw && !S.thematicSel);
      renderTable();
    }

    // ===== Loader: dataset geral OU por Assunto =====
    async function loadData(thematic = null){
      let core, allDocs = [], facetCountries = [];
      if(!thematic){
        const res  = await fetch(API_URL);
        const json = await res.json();
        core = json?.data?.diaServerResponse?.[0];
        facetCountries = core?.facet_counts?.facet_fields?.country || [];
        allDocs = core?.response?.docs || [];

        // guarda o total do dataset completo para exibir em "Todos"
        const statusTotal = core?.facet_counts?.facet_fields?.status?.[0]?.[1];
        S.masterCount = statusTotal || allDocs.length;
      } else {
        let start = 0, numFound = Infinity, got = 0, firstCore = null;
        while(got < numFound){
          const res  = await fetch(SEARCH_URL(thematic, start, FETCH_ROWS));
          const json = await res.json();
          const c = json?.data?.diaServerResponse?.[0];
          if(!firstCore){
            firstCore = c;
            facetCountries = c?.facet_counts?.facet_fields?.country || [];
          }
          const docs = c?.response?.docs || [];
          allDocs.push(...docs);
          numFound = Number(c?.response?.numFound ?? docs.length);
          got += docs.length;
          start += FETCH_ROWS;
          if(!docs.length) break;
        }
        core = firstCore;
      }

      // facets e docs
      S.countriesFacet = facetCountries
        .map(([raw,count])=>({ raw, count, label: labelFromMulti(raw) }))
        .sort((a,b)=> a.label.localeCompare(b.label,'pt',{sensitivity:'base'}));

      S.docs = allDocs.map(d=>({
        id: d.id,
        django_id: d.django_id,
        title: d.title || "—",
        issn: d.issn || [],
        link: d.link || [],
        country_raw: d.country || "",
        country: labelFromMulti(d.country || ""),
        updated_date: d.updated_date || d.created_date || "",
        thematic_area: Array.isArray(d.thematic_area) ? d.thematic_area : (d.thematic_area ? [d.thematic_area] : []),
        editor_code: undefined,
        cc_code: undefined
      })).sort(byTitle);

      // >>> APLICAÇÃO DO FILTRO INICIAL POR PAÍS (label) VINDO DA URL <<<
      if (S.initialCountryLabel && !S.countryRaw) {
        const target = S.initialCountryLabel.toLowerCase();
        const found = S.countriesFacet.find(item => item.label.toLowerCase() === target);
        if (found) {
          S.countryRaw = found.raw;
        }
        // garante que só tenta aplicar uma vez
        S.initialCountryLabel = null;
      }

      // facet de Assunto (para dataset atual)
      const m = new Map();
      S.docs.forEach(d => (d.thematic_area||[]).forEach(t => m.set(t, (m.get(t)||0)+1)));
      S.thematicFacet = Array.from(m.entries())
        .map(([key,count])=>({key, count, label:key}))
        .sort((a,b)=> a.label.localeCompare(b.label,'pt',{sensitivity:'base'}));

      const maxDate = S.docs.reduce((acc,d)=> Math.max(acc, Number(d.updated_date||0)), 0);
      $updated.textContent = maxDate ? fmtDate(String(maxDate)) : "—";

      const statusTotal = core?.facet_counts?.facet_fields?.status?.[0]?.[1];
      $totalCount.textContent = String(statusTotal || S.docs.length);

      S.page = 1;
      renderAll();
    }

    // ===== Scroll suave para tabela quando vier parâmetro na URL =====
    function scrollToTable(){
      const main = document.querySelector('.bvs-main');
      if(!main) return;
      const rect = main.getBoundingClientRect();
      const offset = window.pageYOffset + rect.top - 40; // margenzinha acima
      window.scrollTo({
        top: offset,
        behavior: 'smooth'
      });
    }

    // ===== Init =====
    async function init(){
      // eventos fixos
      $q.addEventListener("input", e=>{
        S.search = e.target.value.trim();
        S.page=1;
        renderTable();
      });
      $totalChip.addEventListener("click", ()=>{
        S.countryRaw=null;
        S.page=1;
        renderAll();
      });
      $totalChip.addEventListener("keydown", e=>{
        if(e.key==='Enter'||e.key===' '){
          e.preventDefault();
          $totalChip.click();
        }
      });

      // colapso da sidebar (se existir o controle)
      const $page = document.getElementById("bvs-page");
      const $toggle = document.getElementById("bvs-toggle");
      if($page && $toggle){
        const saved = localStorage.getItem("bvsCollapsed")==="1";
        if(saved){
          $page.classList.add("is-collapsed");
          $toggle.setAttribute("aria-expanded","false");
          $toggle.dataset.dir="left";
        }
        $toggle.addEventListener("click", ()=>{
          const collapsed = $page.classList.toggle("is-collapsed");
          $toggle.setAttribute("aria-expanded", String(!collapsed));
          $toggle.dataset.dir = "left";
          localStorage.setItem("bvsCollapsed", collapsed ? "1" : "0");
        });
        $toggle.addEventListener("keydown", (e)=>{
          if(e.key==="Enter"||e.key===" "){
            e.preventDefault();
            $toggle.click();
          }
        });
      }

      // dataset inicial (sem assunto)
      await loadData(null);

      // se veio parâmetro na URL (p ou pais), faz scroll até a tabela
      if (S.hasInitialCountryParam) {
        scrollToTable();
      }
    }

    init().catch(err=>{
      console.error(err);
      $tbody.innerHTML = `<tr><td colspan="5" style="padding:16px;color:#b00020;">Falha ao carregar dados da API.</td></tr>`;
    });
  })();
  </script>
</section>

function bvsPeriodicosInit(){
    // ===== Config injetada pelo PHP via <script type="application/json"> =====
    const cfgEl = document.getElementById('bvs-config');
    if (!cfgEl) return;
    const cfg = JSON.parse(cfgEl.textContent);

    // ===== Endpoints e constantes =====
    const API_URL     = cfg.api_url;
    const JOURNAL_BASE = cfg.journal_base;
    const JOURNAL_URL  = (id) => `${JOURNAL_BASE}/${id}`;
    const SEARCH_BASE  = cfg.search_base;
    const SEARCH_URL   = (ta, start=0, rows=1000) => `${SEARCH_BASE}?thematic_area=${encodeURIComponent(ta)}&start=${start}&rows=${rows}`;
    const FETCH_ROWS   = 1000;
    const LANG         = cfg.lang;
    const PER_PAGE     = 50;

    // ===== i18n (vem do PHP) =====
    const BVS_I18N           = cfg.i18n;
    const BVS_COUNTRY_LABELS  = cfg.country_labels;
    const BVS_THEMATIC_LABELS = cfg.thematic_labels;

    // idioma de interface (pt-br → pt, es → es, en → en)
    const UI_LANG =
      LANG.startsWith('pt') ? 'pt' :
      LANG.startsWith('es') ? 'es' :
      'en';

    const T = BVS_I18N[UI_LANG] || BVS_I18N['pt'];

    // aplica textos estáticos da UI assim que o DOM tiver esses elementos
    function applyStaticI18n(){
      const thCells = document.querySelectorAll('#bvs-page .bvs-thead th');
      if (thCells.length >= 5) {
        thCells[0].textContent = T.col_num;
        thCells[1].textContent = T.col_short_title;
        thCells[2].textContent = T.col_issn;
        thCells[3].textContent = T.col_editor_code;
        thCells[4].textContent = T.col_cc_code;
      }
      const switchLabel = document.querySelector('.bvs-switch-label');
      if (switchLabel) switchLabel.textContent = T.toggle_full;
      const sideH3 = document.querySelector('.bvs-side h3');
      if (sideH3) sideH3.textContent = T.cluster_country;
      const areaSpan = document.querySelector('#bvs-assunto-toggle > span:first-child');
      if (areaSpan) areaSpan.textContent = T.cluster_area;
    }

    function translateCountry(raw) {
      const map = BVS_COUNTRY_LABELS;
      for (const key of Object.keys(map)) {
        if (key.toLowerCase() === raw.toLowerCase()) return map[key][UI_LANG] || raw;
      }
      return raw;
    }

    function translateThematic(key) {
      const map = BVS_THEMATIC_LABELS;
      for (const k of Object.keys(map)) {
        if (k.toLowerCase() === key.toLowerCase()) return map[k][UI_LANG] || key;
      }
      return key;
    }

    // idioma da interface do Portal de Revistas (pt, es, en)
    const PORTAL_LANG = UI_LANG;

    // monta URL do Diretório BVS (estrutura multilíngue)
    const bvsDirectoryUrl = (code) => {
      return UI_LANG === 'pt'
        ? `https://bvsalud.org/centros/?lang=pt&q=${encodeURIComponent(code)}`
        : `https://bvsalud.org/${UI_LANG}/centros?lang=${UI_LANG}&q=${encodeURIComponent(code)}`;
    };

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
      masterCount: null,
      initialCountryLabel: null,
      hasInitialCountryParam: false,
      showFullTitle: false
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
          S.hasInitialCountryParam = true;
        }
      } catch(e){}
    })();

    // ===== Refs DOM =====
    const $tbody      = document.getElementById("bvs-tbody");
    const $pager      = document.getElementById("bvs-pager");
    const $countries  = document.getElementById("bvs-countries");
    const $totalChip  = document.getElementById("bvs-total");
    const $totalCount = document.getElementById("bvs-total-count");
    const $updated    = document.getElementById("bvs-updated");
    const $q          = document.getElementById("bvs-q");

    const $titleMode = document.getElementById("bvs-title-mode");
    if ($titleMode) {
      $titleMode.addEventListener("change", (e)=>{
        S.showFullTitle = e.target.checked;
        renderTable();
      });
    }

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

    const getSortTitle = (x) => (x.title_full || x.title || "");
    const byTitle = (a,b)=> getSortTitle(a).localeCompare(getSortTitle(b),'pt',{sensitivity:'base'});

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

      for (const d of pageDocs) {
        const id = getDetailIdFromDoc(d);
        if (!id || detailCache.has(id)) continue;

        tasks.push(() =>
          fetchDetailOnce(id).then((codes) => {
            d.editor_code = codes.editor_code;
            d.cc_code     = codes.cc_code;

            const row = document.querySelector(`tr[data-row-id="${d.id}"]`);
            if (!row) return;

            // editor: link para diretório BVS
            const editorCell = row.querySelector('[data-cell="editor"]');
            if (editorCell) {
              const ec = d.editor_code || "—";
              if (ec && ec !== "—") {
                editorCell.innerHTML = `<a href="${bvsDirectoryUrl(ec)}" target="_blank" rel="noopener" style="color: var(--accent); text-decoration: none;">${ec}</a>`;
              } else {
                editorCell.textContent = ec;
              }
            }

            // CC: mantém/reescreve o link
            const ccCell = row.querySelector('[data-cell="cc"]');
            if (ccCell) {
              const ccCode = d.cc_code || "—";
              if (ccCode && ccCode !== "—") {
                ccCell.innerHTML = `<a href="${bvsDirectoryUrl(ccCode)}" target="_blank" rel="noopener" style="color: var(--accent); text-decoration: none;">${ccCode}</a>`;
              } else {
                ccCell.textContent = "—";
              }
            }
          })
        );
      }

      let i = 0;
      const run = async () => {
        while (i < tasks.length) {
          const batch = tasks.slice(i, (i += limit)).map((fn) => fn());
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

      const rowAll = document.createElement("div");
      rowAll.className = "row" + (S.thematicSel==null ? " is-active" : "");
      rowAll.setAttribute("role","button"); rowAll.setAttribute("tabindex","0");
      const allCount = S.masterCount ?? S.docs.length;
      rowAll.innerHTML = `<span class="name">${translateThematic('Todos')}</span><span class="count">${allCount}</span>`;
      rowAll.addEventListener("click", async ()=>{
        if(S.thematicSel!==null){
          S.thematicSel = null;
          await loadData(null);
        }
      });
      rowAll.addEventListener("keydown", e=>{
        if(e.key==='Enter'||e.key===' '){
          e.preventDefault();
          rowAll.click();
        }
      });
      frag.appendChild(rowAll);

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
    const $assuntoToggle = document.getElementById("bvs-assunto-toggle");
    if ($assuntoToggle) {
      $assuntoToggle.addEventListener("click", ()=>{
        S.assuntoOpen = !S.assuntoOpen;
        renderAssunto();
      });
    }

    // ===== Filtragem local (país + busca, incluindo ISSN) =====
    function filteredDocs(){
      let list = S.docs;
      if (S.countryRaw)
        list = list.filter(d => d.country_raw === S.countryRaw);

      if (S.search) {
        const q = S.search.toLowerCase();
        list = list.filter(d => {
          const titleFull  = (d.title_full  || d.title || "").toLowerCase();
          const titleShort = (d.title_short || "").toLowerCase();
          const editor     = d.editor_code?.toLowerCase() || "";
          const cc         = d.cc_code?.toLowerCase()     || "";
          const issnStr = Array.isArray(d.issn)
            ? d.issn.join(" ").toLowerCase()
            : "";
          return (
            titleFull.includes(q)  ||
            titleShort.includes(q) ||
            editor.includes(q)     ||
            cc.includes(q)         ||
            issnStr.includes(q)
          );
        });
      }
      return list;
    }

    // ===== Tabela =====
    async function renderTable(){
      const list = filteredDocs();
      const pages = 1;
      if(S.page>pages) S.page = pages;
      const start = 0;
      const pageDocs = list;

      $tbody.innerHTML = "";
      const frag = document.createDocumentFragment();

      pageDocs.forEach((d, idx)=>{
        const detailId   = getDetailIdFromDoc(d);
        const cached     = detailId && detailCache.get(detailId);
        const editorCode = (d.editor_code || cached?.editor_code) ?? "…";
        const ccCode     = (d.cc_code     || cached?.cc_code)     ?? "…";

        const issnVal = getFirstISSN(d.issn);

        const displayTitle = S.showFullTitle ? d.title_full : d.title_short;

        const primaryLink = (issnVal && issnVal !== "—")
          ? `https://portal.revistas.bvs.br/${PORTAL_LANG}/journals/?lang=${PORTAL_LANG}&q=${encodeURIComponent(issnVal)}`
          : null;

        const tr = document.createElement("tr");
        tr.setAttribute("data-row-id", d.id);
        tr.innerHTML = `
  <td class="bvs-col-idx">${start+idx+1}</td>

  <td class="bvs-col-title">
    ${primaryLink
      ? `<a href="${primaryLink}" target="_blank" rel="noopener">${displayTitle}</a>`
      : displayTitle}
  </td>

  <td class="bvs-col-issn">
    ${d.django_id
      ? `<a href="https://portal.revistas.bvs.br/journals/detail/?id=${d.django_id}" target="_blank" rel="noopener" style="color: var(--accent); text-decoration: none;">${issnVal}</a>`
      : issnVal}
  </td>

  <td class="bvs-col-code" data-cell="editor">
    ${editorCode && editorCode !== '—' && editorCode !== '…'
      ? `<a href="${bvsDirectoryUrl(editorCode)}" target="_blank" rel="noopener" style="color: var(--accent); text-decoration: none;">${editorCode}</a>`
      : editorCode}
  </td>

  <td class="bvs-col-code" data-cell="cc">
    ${ccCode && ccCode !== "—"
      ? `<a href="${bvsDirectoryUrl(ccCode)}" target="_blank" rel="noopener" style="color: var(--accent); text-decoration: none;">${ccCode}</a>`
      : "—"}
  </td>`;

        frag.appendChild(tr);
      });

      $tbody.appendChild(frag);
      hydrateVisibleCodes(pageDocs);
      $pager.innerHTML = "";
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

      S.countriesFacet = facetCountries
        .map(([raw,count])=>({ raw, count, label: translateCountry(labelFromMulti(raw)) }))
        .sort((a,b)=> a.label.localeCompare(b.label,'pt',{sensitivity:'base'}));

      S.docs = allDocs.map(d=>{
        const fullTitle = d.title || "—";
        let shortTitle = "";

        if (Array.isArray(d.shortened_title) && d.shortened_title.length) {
          shortTitle = d.shortened_title[0];
        }
        if (!shortTitle) {
          shortTitle = fullTitle;
        }

        return {
          id: d.id,
          django_id: d.django_id,
          title_full: fullTitle,
          title_short: shortTitle,
          title: fullTitle,
          issn: d.issn || [],
          link: d.link || [],
          country_raw: d.country || "",
          country: labelFromMulti(d.country || ""),
          updated_date: d.updated_date || d.created_date || "",
          thematic_area: Array.isArray(d.thematic_area) ? d.thematic_area : (d.thematic_area ? [d.thematic_area] : []),
          editor_code: undefined,
          cc_code: undefined
        };
      }).sort(byTitle);

      if (S.initialCountryLabel && !S.countryRaw) {
        const target = S.initialCountryLabel.toLowerCase();
        const found = S.countriesFacet.find(item => item.label.toLowerCase() === target);
        if (found) {
          S.countryRaw = found.raw;
        }
        S.initialCountryLabel = null;
      }

      const m = new Map();
      S.docs.forEach(d => (d.thematic_area||[]).forEach(t => m.set(t, (m.get(t)||0)+1)));
      S.thematicFacet = Array.from(m.entries())
        .map(([key,count])=>({key, count, label: translateThematic(key)}))
        .sort((a,b)=> a.label.localeCompare(b.label,'pt',{sensitivity:'base'}));

      const maxDate = S.docs.reduce((acc,d)=> Math.max(acc, Number(d.updated_date||0)), 0);
      $updated.textContent = maxDate ? fmtDate(String(maxDate)) : "—";

      const statusTotal = core?.facet_counts?.facet_fields?.status?.[0]?.[1];
      $totalCount.textContent = String(statusTotal || S.docs.length);

      S.page = 1;
      renderAll();
    }

    function scrollToTable(){
      const main = document.querySelector('.bvs-main');
      if(!main) return;
      const rect = main.getBoundingClientRect();
      const offset = window.pageYOffset + rect.top - 40;
      window.scrollTo({ top: offset, behavior: 'smooth' });
    }

    // ===== Init =====
    async function init(){
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

      const $page   = document.getElementById("bvs-page");
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

      await loadData(null);
      applyStaticI18n();

      if (S.hasInitialCountryParam) {
        scrollToTable();
      }
    }

    init().catch(err=>{
      console.error(err);
      if ($tbody) $tbody.innerHTML = `<tr><td colspan="5" style="padding:16px;color:#b00020;">Falha ao carregar dados da API.</td></tr>`;
    });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', bvsPeriodicosInit);
} else {
  bvsPeriodicosInit();
}

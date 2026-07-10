<?php
  // ── lê textos i18n salvos no metabox ──────────────────────────────────────
  $per_pid = get_the_ID();
  $langs   = ['pt','es','en'];
  $i18n_keys = ['banner_title','banner_desc','cluster_country','cluster_area','cluster_editor','cluster_cc',
                'col_num','col_short_title','col_full_title','col_issn','col_editor_code','col_cc_code','toggle_full',
                'last_updated','search_placeholder','total_general'];
  $i18n_defaults = [
    'pt' => [
      'banner_title'      => 'Revistas indexadas na LILACS',
      'banner_desc'       => 'Conheça todos os títulos e pesquise por país, área, editora e Centro Cooperante.',
      'cluster_country'   => 'País',
      'cluster_area'      => 'Áreas do conhecimento',
      'cluster_editor'    => 'Editora',
      'cluster_cc'        => 'Centro Cooperante',
      'col_num'           => '#',
      'col_short_title'   => 'Título abreviado',
      'col_full_title'    => 'Título completo',
      'col_issn'          => 'ISSN',
      'col_editor_code'   => 'Código da Editora',
      'col_cc_code'       => 'Código do Centro Cooperante',
      'toggle_full'       => 'Mostrar título completo',
      'last_updated'      => 'Última atualização',
      'search_placeholder'=> 'Pesquise por título, ISSN ou código',
      'total_general'     => 'Total geral',
    ],
    'es' => [
      'banner_title'      => 'Revistas indexadas en LILACS',
      'banner_desc'       => 'Conozca todos los títulos y busque por país, área, editorial y Centro Cooperante.',
      'cluster_country'   => 'País',
      'cluster_area'      => 'Áreas del conocimiento',
      'cluster_editor'    => 'Editorial',
      'cluster_cc'        => 'Centro Cooperante',
      'col_num'           => '#',
      'col_short_title'   => 'Título abreviado',
      'col_full_title'    => 'Título completo',
      'col_issn'          => 'ISSN',
      'col_editor_code'   => 'Código del Editorial',
      'col_cc_code'       => 'Código del Centro Cooperante',
      'toggle_full'       => 'Mostrar título completo',
      'last_updated'      => 'Última actualización',
      'search_placeholder'=> 'Buscar por título, ISSN o código',
      'total_general'     => 'Total general',
    ],
    'en' => [
      'banner_title'      => 'Journals indexed in LILACS',
      'banner_desc'       => 'Discover all titles and search by country, subject area, publisher, and Cooperating Center.',
      'cluster_country'   => 'Country',
      'cluster_area'      => 'Subject Areas',
      'cluster_editor'    => 'Publisher',
      'cluster_cc'        => 'Cooperating Center',
      'col_num'           => '#',
      'col_short_title'   => 'Abbreviated title',
      'col_full_title'    => 'Full title',
      'col_issn'          => 'ISSN',
      'col_editor_code'   => 'Publisher Code',
      'col_cc_code'       => 'CC Code',
      'toggle_full'       => 'Show full title',
      'last_updated'      => 'Last updated',
      'search_placeholder'=> 'Search by title, ISSN, or code',
      'total_general'     => 'Grand total',
    ],
  ];
  $i18n = [];
  foreach ($langs as $lang) {
    $i18n[$lang] = [];
    foreach ($i18n_keys as $k) {
      $val = get_post_meta($per_pid, "_lilacs_per_i18n_{$lang}_{$k}", true);
      $i18n[$lang][$k] = ($val !== '') ? $val : $i18n_defaults[$lang][$k];
    }
  }

  // Passa o título/desc do banner no idioma correto para o partial do banner
  $current_lang_per = function_exists('pll_current_language') ? pll_current_language() : 'pt';
  $current_lang_per = in_array($current_lang_per, $langs) ? $current_lang_per : 'pt';
  $GLOBALS['_lilacs_per_banner_title'] = $i18n[$current_lang_per]['banner_title'];
  $GLOBALS['_lilacs_per_banner_desc']  = $i18n[$current_lang_per]['banner_desc'];

  get_template_part('templates/parts/section', 'banner-como-pesquisar');

  // países (mapeamento raw da API → labels por idioma)
  $country_labels = [
    'Argentina'                              => ['pt'=>'Argentina',           'es'=>'Argentina',          'en'=>'Argentina'],
    'Bolivia'                                => ['pt'=>'Bolívia',             'es'=>'Bolivia',            'en'=>'Bolivia'],
    'Brasil'                                 => ['pt'=>'Brasil',              'es'=>'Brasil',             'en'=>'Brazil'],
    'Chile'                                  => ['pt'=>'Chile',               'es'=>'Chile',              'en'=>'Chile'],
    'Colombia'                               => ['pt'=>'Colômbia',            'es'=>'Colombia',           'en'=>'Colombia'],
    'Costa Rica'                             => ['pt'=>'Costa Rica',          'es'=>'Costa Rica',         'en'=>'Costa Rica'],
    'Cuba'                                   => ['pt'=>'Cuba',                'es'=>'Cuba',               'en'=>'Cuba'],
    'Republica Dominicana'                   => ['pt'=>'República Dominicana','es'=>'República Dominicana','en'=>'Dominican Republic'],
    'El Salvador'                            => ['pt'=>'El Salvador',         'es'=>'El Salvador',        'en'=>'El Salvador'],
    'Ecuador'                                => ['pt'=>'Equador',             'es'=>'Ecuador',            'en'=>'Ecuador'],
    'Estados Unidos'                         => ['pt'=>'Estados Unidos',      'es'=>'Estados Unidos',     'en'=>'United States'],
    'United States'                          => ['pt'=>'Estados Unidos',      'es'=>'Estados Unidos',     'en'=>'United States'],
    'Guatemala'                              => ['pt'=>'Guatemala',           'es'=>'Guatemala',          'en'=>'Guatemala'],
    'Honduras'                               => ['pt'=>'Honduras',            'es'=>'Honduras',           'en'=>'Honduras'],
    'Jamaica'                                => ['pt'=>'Jamaica',             'es'=>'Jamaica',            'en'=>'Jamaica'],
    'Mexico'                                 => ['pt'=>'México',              'es'=>'México',             'en'=>'Mexico'],
    'Panama'                                 => ['pt'=>'Panamá',              'es'=>'Panamá',             'en'=>'Panama'],
    'Paraguay'                               => ['pt'=>'Paraguai',            'es'=>'Paraguay',           'en'=>'Paraguay'],
    'Peru'                                   => ['pt'=>'Peru',                'es'=>'Perú',               'en'=>'Peru'],
    'Puerto Rico'                            => ['pt'=>'Porto Rico',          'es'=>'Puerto Rico',        'en'=>'Puerto Rico'],
    'Uruguay'                                => ['pt'=>'Uruguai',             'es'=>'Uruguay',            'en'=>'Uruguay'],
    'Venezuela'                              => ['pt'=>'Venezuela',           'es'=>'Venezuela',          'en'=>'Venezuela'],
  ];

  // áreas temáticas
  $thematic_labels = [
    'Ciências Agrárias'     => ['pt'=>'Ciências Agrárias',   'es'=>'Ciencias Agrarias',       'en'=>'Agricultural Sciences'],
    'Ciências Biológicas'   => ['pt'=>'Ciências Biológicas', 'es'=>'Ciencias Biológicas',     'en'=>'Biological Sciences'],
    'Ciências da Saúde'     => ['pt'=>'Ciências da Saúde',   'es'=>'Ciencias de la Salud',    'en'=>'Health Sciences'],
    'Ciências Humanas'      => ['pt'=>'Ciências Humanas',    'es'=>'Ciencias Humanas',        'en'=>'Humanities'],
    'Ciências Sociais'      => ['pt'=>'Ciências Sociais',    'es'=>'Ciencias Sociales',       'en'=>'Social Sciences'],
    'Enfermagem'            => ['pt'=>'Enfermagem',          'es'=>'Enfermería',              'en'=>'Nursing'],
    'Psicologia'            => ['pt'=>'Psicologia',          'es'=>'Psicología',              'en'=>'Psychology'],
    'Saúde Pública'         => ['pt'=>'Saúde Pública',       'es'=>'Salud Pública',           'en'=>'Public Health'],
    'TMGL'                  => ['pt'=>'TMGL',                'es'=>'TMGL',                    'en'=>'TMGL'],
    'Todos'                 => ['pt'=>'Todos',               'es'=>'Todos',                   'en'=>'All'],
  ];

  // Lookup normalizado: chave = valor exato que a API retorna (maiúsculo, sem acento)
  // Garante a tradução mesmo sem String.normalize() no browser
  $accent_map = [
    'á'=>'a','à'=>'a','â'=>'a','ã'=>'a','ä'=>'a',
    'é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
    'í'=>'i','ì'=>'i','î'=>'i','ï'=>'i',
    'ó'=>'o','ò'=>'o','ô'=>'o','õ'=>'o','ö'=>'o',
    'ú'=>'u','ù'=>'u','û'=>'u','ü'=>'u',
    'ç'=>'c','ñ'=>'n',
    'Á'=>'A','À'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A',
    'É'=>'E','È'=>'E','Ê'=>'E','Ë'=>'E',
    'Í'=>'I','Ì'=>'I','Î'=>'I','Ï'=>'I',
    'Ó'=>'O','Ò'=>'O','Ô'=>'O','Õ'=>'O','Ö'=>'O',
    'Ú'=>'U','Ù'=>'U','Û'=>'U','Ü'=>'U',
    'Ç'=>'C','Ñ'=>'N',
  ];
  $thematic_lookup = [];
  foreach ($thematic_labels as $label_key => $translations) {
    $normalized_key = strtoupper( strtr($label_key, $accent_map) );
    $thematic_lookup[ $normalized_key ] = $translations;
  }
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
margin: 0 auto;
    align-self: center;
    height: 25px;
    width: 25px !important;
    border-radius: 999px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 17px;
    color: #111827;
    transition: background 0.15s ease, border-color 0.15s ease, transform 0.2s ease;
    z-index: 999;
    align-content: center;
    margin-left: -13px;
        position: absolute;
    right: -13px;
    top: 0;
    display: flex;
    align-content: center;
    align-items: center;
    padding: 0 !important;
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
    #bvs-page.is-collapsed .bvs-toggle{right:-12px; top:6px}

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
    .bvs-side h3{margin:4px 0 12px; color:var(--text); font-size:16px; font-weight:800}
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

.bvs-title-toggle{
  display:flex;
  justify-content:flex-start;   /* alinhado à esquerda */
  align-items:center;
  padding:4px 8px 8px;
}

/* container do switch */
.bvs-switch{
  display:inline-flex;
  align-items:center;
  gap:8px;
  cursor:pointer;
  font-size:13px;
  color:var(--muted);
}

/* esconde o checkbox padrão */
.bvs-switch input{
  position:absolute;
  opacity:0;
  pointer-events:none;
}

/* trilho */
.bvs-slider{
  position:relative;
  width:40px;
  height:20px;
  background:#d4dbe8;
  border-radius:999px;
  transition:background .2s ease;
}

/* bolinha */
.bvs-slider::before{
  content:"";
  position:absolute;
  top:2px;
  left:2px;
  width:16px;
  height:16px;
  border-radius:50%;
  background:#fff;
  box-shadow:0 1px 3px rgba(0,0,0,.25);
  transition:transform .2s ease;
}

/* estado checked */
.bvs-switch input:checked + .bvs-slider{
  background:var(--accent-2);
}

.bvs-switch input:checked + .bvs-slider::before{
  transform:translateX(20px);
}

.bvs-switch-label{
  font-size:13px;
}

#bvs-total{
    background: #f96a1e;
    color: #fff;
}


  </style>

  <div class="bvs-top">
    <div class="bvs-updated"><span id="bvs-updated-label">Última atualização</span>: <span id="bvs-updated">DD/MM/AAAA</span></div>
  </div>

  <div class="bvs-wrap">
    <!-- Sidebar -->
    <aside class="bvs-side" id="bvs-filters">
     
            
      <!-- BUSCA agora só na coluna esquerda -->
      <div class="bvs-search" style="margin:10px 0 12px;">
        <input id="bvs-q" type="search" placeholder="Pesquise por título, ISSN ou códigos" aria-label="Pesquisar">
        <span class="icon">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/Vector.png' ); ?>" alt="">
        </span>
      </div>

      <h3>País</h3>

      <div id="bvs-total" class="bvs-chip" role="button" tabindex="0" aria-pressed="true">
        <span id="bvs-total-label">Total geral</span><span class="badge" id="bvs-total-count">0</span>
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
 <button id="bvs-toggle" class="bvs-toggle" aria-expanded="true" aria-controls="bvs-filters" title="Encolher filtros">
         ‹
      </button>

    </aside>
    

    <!-- Main table -->
    <main class="bvs-main">
        
        <main class="bvs-main">


<div class="bvs-title-toggle">
  <label class="bvs-switch">
    <input type="checkbox" id="bvs-title-mode">
    <span class="bvs-slider"></span>
    <span class="bvs-switch-label">Mostrar título completo</span>
  </label>
</div>


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



      <div id="bvs-pager" class="bvs-pager" aria-label="Paginação"></div>
    </main>
  </div>

  <script type="application/json" id="bvs-config">
  <?php echo json_encode([
    'api_url'        => untrailingslashit( get_rest_url(null, 'test/v1/bvs') ),
    'journal_base'   => untrailingslashit( get_rest_url(null, 'test/v1/bvs/journal') ),
    'search_base'    => untrailingslashit( get_rest_url(null, 'test/v1/bvs/journals/search') ),
    'lang'           => function_exists('pll_current_language') ? pll_current_language() : ( defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'pt' ),
    'i18n'            => $i18n,
    'country_labels'  => $country_labels,
    'thematic_labels' => $thematic_labels,
    'thematic_lookup' => $thematic_lookup,
  ], JSON_UNESCAPED_UNICODE); ?>
  </script>
</section>


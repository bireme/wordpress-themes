
    <style>
     
        body, h3, h4, p, a {
            margin: 0;
            padding: 0;
            font-family: 'Noto Sans', sans-serif; 
        }
        
        *, *::before, *::after {
            box-sizing: border-box;
        }

        /* Geral cards grandes (topo) */
        .lilacs-cards .container {
            width: 100%;
            max-width: 1360px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
            box-sizing: border-box;
        }
        .lilacs-cards .card {
          border-radius: 12px;
          padding: 22px;
          color: #fff;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
          min-height: 120px;
          box-shadow: 0 6px 20px rgba(4,9,20,0.06);
          transition: transform .18s ease, box-shadow .18s ease;
          overflow: hidden;
        }
        .lilacs-cards .card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(4,9,20,0.10); }

        .lilacs-cards .row {
            margin: 50px 0px;
            display: flex;
            width: 100%;
            justify-content: center;
            gap: 50px;
            font-family: 'Noto Sans';
            flex-wrap: wrap; /* AJUSTADO: Permite que os cards quebrem a linha */
        }

        .lilacs-cards .col-12 {
        
            flex-basis: 100%; 
        }

       
        @media (min-width: 768px) {
            .lilacs-cards .row .col-md-6 {
                flex-basis: calc(50% - 25px);
                width: calc(50% - 25px);
            }
        }


        /* Gradientes variados (você pode ajustar cores) */
        .lilacs-cards .card.gradient-1 { background: linear-gradient(90deg,#7741b6 0%,#0e6aa8 100%); }
        .lilacs-cards .card.gradient-2 { background: linear-gradient(90deg,#6f3fae 0%,#0b5fa8 100%); }
        .lilacs-cards .card .card-title { font-size:1.15rem; font-weight:700; margin:0 0 10px; }
        .lilacs-cards .card .card-desc { opacity:.95; margin:0 0 14px; }

        /* Pills / botões pequenos dentro do card */
        .card-pills { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
        .pill {
          background: #FFF;
          color: #00205C;
          padding:8px 14px;
          border-radius:999px;
          font-weight:600;
          font-size:0.92rem;
          text-decoration:none;
          display:inline-flex;
          align-items:center;
          gap:8px;
        }

        .lilacs-videos-grid {
          display:grid;
          grid-template-columns: 1fr;
          gap:18px;
        }

        .lilacs-videos-wrap {

            width: 100%;
            max-width: 1360px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
            box-sizing: border-box;
        }

        .lilacs-consulta .container {
     
            width: 100%;
            max-width: 1360px;
            margin: 50px auto 50px auto;
            padding-left: 20px;
            padding-right: 20px;
            box-sizing: border-box;
        }
        section.py-4 {
            padding-top: 1.5rem; 
            padding-bottom: 1.5rem; 
        }
        
        .container {
             width: 100%;
             margin-right: auto;
             margin-left: auto;
        }

        @media(min-width:992px){
          .lilacs-videos-grid { grid-template-columns: 1fr 1fr; align-items:start; }
        }
        .lilacs-videos-grid .col-left, .lilacs-videos-grid .col-right { background:transparent; }
        .videos-header { display:flex; gap:12px; align-items:center; margin-bottom:8px; }
        .videos-header h3 { margin:0; color:#0b4b78; font-weight:800; font-size:1.25rem; }

        .responsive-iframe { position:relative; width:100%; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:6px; }
        .responsive-iframe iframe, .responsive-iframe video { position:absolute; top:0; left:0; width:100%; height:100%; border:0; }

    
        .course-thumb { border-radius:6px; overflow:hidden; box-shadow:0 6px 18px rgba(4,9,20,.06); display:block; width:100%; }

        .lilacs-consulta { margin-top:28px; }
        .consulta-grid {
          display:grid;
          grid-template-columns: 1fr;
          gap:18px;
        }
        @media(min-width:768px){
          .consulta-grid { grid-template-columns: repeat(2,1fr); }
        }
        .consulta-card {
          display:flex;
          align-items:center;
          justify-content:space-between;
          gap:16px;
          padding:20px;
          border-radius:12px;
          background: linear-gradient(90deg,#072a57 0%,#123a6a 100%);
          color:#fff;
          text-decoration:none;
          box-shadow:0 8px 22px rgba(2,19,55,0.12);
          transition: transform .15s ease, box-shadow .15s ease;
        }
        .consulta-card:hover { transform:translateY(-6px); box-shadow:0 14px 36px rgba(2,19,55,0.14); }
        .consulta-card .meta { display:flex; gap:14px; align-items:center; }
        .consulta-card .icon {
          width:56px; height:56px; min-width:56px;
          border-radius:10px;
          background: rgba(255,255,255,0.08);
          display:flex; align-items:center; justify-content:center;
          font-weight:700;
          font-size:1.2rem;
        }
        .consulta-card .texts h4 { margin:0 0 4px; font-size:1rem; font-weight:700; }
        .consulta-card .texts p { margin:0; opacity:.9; font-size:0.9rem; }

        .consulta-card .chev {
          width:40px; height:40px; display:flex; align-items:center; justify-content:center;
          background: rgba(255,255,255,0.06); border-radius:8px; font-weight:700;
        }


        /* --- MOBILE --- */

     
        @media(max-width: 767px) {
            .lilacs-cards .row {
                flex-direction: column;
                gap: 25px;
                margin: 30px 0; 
            }

            .lilacs-cards .row .col-12 {
                width: 100%;
                flex-basis: 100%;
            }
        }


        @media(max-width:480px){
            .card-title { font-size:1rem; }
            .consulta-card { 
                padding:14px; 
            
                flex-direction: column;
                align-items: stretch;
            }
            .consulta-card .chev {
                margin-left: auto; 
            }
        }
        /* --- FIM AJUSTES MOBILE --- */
    </style>

<section class="lilacs-cards py-4">
  <div class="container">
    <div class="row g-4"> 
      <div class="col-12 col-md-6">
        <div class="card gradient-1 h-100">
          <div>
            <div class="card-title">Guia rápido de pesquisa na BVS</div>
          </div>
          <div class="card-pills">
            <a href="#" class="pill">Online</a>
            <a href="#" class="pill">PDF</a>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6">
        <div class="card gradient-2 h-100">
          <div>
            <div class="card-title">Tutorial de pesquisa na BVS</div>
          </div>
          <div class="card-pills">
            <a href="#" class="pill">Online</a>
            <a href="#" class="pill">PDF</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-4">
  <div class="container">
    <div class="lilacs-videos-wrap">
      <div class="lilacs-videos-grid">
        <div class="col-left">
          <div class="videos-header">
            <h3>Vídeos rápidos sobre pesquisa</h3>
          </div>
          <div class="responsive-iframe">
            <iframe src="https://www.youtube.com/embed/tqJ3Gjt6vqY" title="Vídeo de exemplo" allowfullscreen></iframe>
          </div>
        </div>

        <div class="col-right">
          <div class="videos-header">
            <h3>Curso online</h3>
          </div>
          <a href="#" class="course-thumb" aria-label="Abrir curso online">
            <img src="https://i.ytimg.com/vi/tqJ3Gjt6vqY/hqdefault.jpg" alt="Curso online" style="width:100%;height:auto;display:block;">
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="lilacs-consulta py-4">
  <div class="container">
    <div class="consulta-grid">
      <a class="consulta-card" href="#" title="Pesquisa por tipos metodológicos de estudos">
        <div class="meta">
          <div class="icon">📘</div>
          <div class="texts">
            <h4>Pesquisa por tipos metodológicos de estudos</h4>
            <p>Encontre ensaios clínicos, revisões e outros desenhos.</p>
          </div>
        </div>
        <div class="chev">›</div>
      </a>

      <a class="consulta-card" href="#" title="Repositório de estratégias de busca">
        <div class="meta">
          <div class="icon">🔎</div>
          <div class="texts">
            <h4>Repositório de estratégias de busca</h4>
            <p>Exemplos prontos para usar em diferentes bases.</p>
          </div>
        </div>
        <div class="chev">›</div>
      </a>

    </div>
  </div>
</section>


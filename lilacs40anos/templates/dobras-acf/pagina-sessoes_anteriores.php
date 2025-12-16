<?php
/**
 * Dobra: Sessões Anteriores (Capacitação) — NOVA (somente busca externa)
 * Slug: pagina-sessoes_anteriores
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$titulo  = get_sub_field( 'titulo' );
$prefill = isset($_GET['q']) ? sanitize_text_field( wp_unslash($_GET['q']) ) : '';
$action  = 'https://lilacs.teste.bvsalud.org/oer';
?>
<section id="cap-sessoes-anteriores" aria-label="<?php echo esc_attr__( 'Sessões anteriores', 'lilacs' ); ?>">
  <style>
    #cap-sessoes-anteriores{
      background:#fff;
      padding:44px 0 64px;
    }
    #cap-sessoes-anteriores *{
      box-sizing:border-box;
      font-family:"Noto Sans", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* 🔥 padding removido aqui */
    #cap-sessoes-anteriores .cap-inner{
      max-width:1180px;
      margin:0 auto;
    }

    #cap-sessoes-anteriores .cap-head{
      margin-bottom:18px;
    }
    #cap-sessoes-anteriores .cap-title{
      margin:0 0 8px;
      font-size:22px;
      line-height:1.2;
      font-weight:800;
      color:#163b72;
      letter-spacing:-0.01em;
    }
    #cap-sessoes-anteriores .cap-subtitle{
      margin:0;
      font-size:14px;
      line-height:1.45;
      color:#4f5b75;
      max-width:72ch;
    }

    #cap-sessoes-anteriores .cap-card{
      background:#f7f9fc;
      border:1px solid #d8e2f3;
      border-radius:16px;
      padding:18px;
      box-shadow:0 10px 24px rgba(12,49,116,.06);
    }

    #cap-sessoes-anteriores .cap-form{
      display:flex;
      gap:10px;
      align-items:stretch;
      flex-wrap:wrap;
    }
    #cap-sessoes-anteriores .cap-field{
      flex:1 1 420px;
      min-width:260px;
      display:flex;
      align-items:center;
      gap:10px;
      padding:12px 14px;
      border-radius:999px;
      border:1px solid #c5cee0;
      background:#fff;
      transition:border-color .15s ease, box-shadow .15s ease, transform .1s ease;
    }
    #cap-sessoes-anteriores .cap-field:focus-within{
      border-color:#3366cc;
      box-shadow:0 0 0 3px rgba(51,102,204,.18);
      transform:translateY(-1px);
    }
    #cap-sessoes-anteriores .cap-icon{
      width:18px;height:18px;
      color:#163b72;
      opacity:.9;
    }
    #cap-sessoes-anteriores .cap-input{
      width:100%;
      border:0;
      outline:none;
      font-size:14px;
      color:#163b72;
      background:transparent;
    }

    #cap-sessoes-anteriores .cap-actions{
      flex:0 0 auto;
      display:flex;
    }
    #cap-sessoes-anteriores .cap-btn{
      appearance:none;
      border:1px solid #3366cc;
      background:#3366cc;
      color:#fff;
      border-radius:999px;
      padding:12px 18px;
      font-size:14px;
      font-weight:700;
      cursor:pointer;
      display:inline-flex;
      align-items:center;
      gap:8px;
      transition:.15s;
      box-shadow:0 10px 18px rgba(51,102,204,.18);
    }
    #cap-sessoes-anteriores .cap-btn:hover{
      background:#2a57ad;
      border-color:#2a57ad;
      transform:translateY(-1px);
    }
    #cap-sessoes-anteriores .cap-btn:disabled{
      opacity:.6;
      cursor:not-allowed;
      box-shadow:none;
      transform:none;
    }

    #cap-sessoes-anteriores .cap-hint{
      margin:12px 4px 0;
      font-size:12.5px;
      color:#6b7a90;
    }

    @media (max-width:640px){
      #cap-sessoes-anteriores{ padding:30px 0 42px; }
      #cap-sessoes-anteriores .cap-title{ font-size:20px; }
      #cap-sessoes-anteriores .cap-card{ padding:14px; }
      #cap-sessoes-anteriores .cap-btn{ width:100%; justify-content:center; }
    }

    .sr-only{
      position:absolute!important;
      width:1px;height:1px;
      margin:-1px;
      overflow:hidden;
      clip:rect(0,0,0,0);
      white-space:nowrap;
      border:0;
    }
  </style>

  <div class="cap-inner">
    <div class="cap-head">
      <h2 class="cap-title">
        <?php echo esc_html( $titulo ?: __( 'Sessões anteriores', 'lilacs' ) ); ?>
      </h2>
      <p class="cap-subtitle">
        <?php echo esc_html__( 'Busque sessões anteriores e você será direcionado para a página de resultados.', 'lilacs' ); ?>
      </p>
    </div>

    <div class="cap-card">
<form class="cap-form" action="<?php echo esc_url($action); ?>" method="get">
  <label class="sr-only" for="cap-sessoes-q">
    <?php esc_html_e( 'Buscar sessões anteriores', 'lilacs' ); ?>
  </label>

  <div class="cap-field">
    <input
      id="cap-sessoes-q"
      class="cap-input"
      type="search"
      name="q"
      value="<?php echo esc_attr($prefill); ?>"
      placeholder="<?php esc_attr_e( 'Ex.: 2025, editoras, indexação…', 'lilacs' ); ?>"
      autocomplete="off"
    />
  </div>

  <div class="cap-actions">
    <button type="submit" class="cap-btn" id="cap-sessoes-submit">
      <?php esc_html_e( 'Pesquisar', 'lilacs' ); ?> →
    </button>
  </div>
</form>


      <p class="cap-hint">
        <?php esc_html_e( 'A busca será aberta em uma nova página de resultados.', 'lilacs' ); ?>
      </p>
    </div>
  </div>

  <script>
    (function(){
      var input = document.getElementById('cap-sessoes-q');
      var btn   = document.getElementById('cap-sessoes-submit');
      if(!input || !btn) return;

      function sync(){
        btn.disabled = input.value.trim().length === 0;
      }
      sync();
      input.addEventListener('input', sync);
    })();
  </script>
</section>

<?php
/**
 * Dobra: 40 Anos – AGENDA DE EVENTOS
 * Slug ACF: l40_agenda
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'l40_esc_text' ) ) { function l40_esc_text( $v ) { return esc_html( (string) $v ); } }
if ( ! function_exists( 'l40_esc_attr' ) ) { function l40_esc_attr( $v ) { return esc_attr( (string) $v ); } }
if ( ! function_exists( 'l40_esc_url'  ) ) { function l40_esc_url( $v )  { return esc_url( (string) $v );  } }

$accord_id    = 'l40-agenda-' . get_the_ID() . '-' . get_row_index();
$agenda_title = get_sub_field( 'l40_agenda_title' ) ?: 'Agenda de eventos';
$events       = get_sub_field( 'l40_events' );
if ( ! is_array( $events ) ) $events = [];
?>

<section id="agenda" class="l40-agenda-section">
  <div class="l40-container">
    <h2 class="l40-agenda-title"><?php echo l40_esc_text( $agenda_title ); ?></h2>

    <div class="l40-accordion" id="<?php echo esc_attr( $accord_id ); ?>">
      <?php if ( ! empty( $events ) ) :
        foreach ( $events as $i => $ev ) :
          $ev_img   = isset( $ev['image'] )     ? ( is_array( $ev['image'] ) ? $ev['image']['url'] : $ev['image'] ) : '';
          $ev_type  = isset( $ev['type'] )       ? $ev['type']       : 'presencial';
          $ev_title = isset( $ev['title'] )      ? $ev['title']      : '';
          $ev_date  = isset( $ev['date_text'] )  ? $ev['date_text']  : '';
          $ev_time  = isset( $ev['time_text'] )  ? $ev['time_text']  : '';
          $ev_place = isset( $ev['place_text'] ) ? $ev['place_text'] : '';
          $ev_desc  = isset( $ev['descricao'] )  ? $ev['descricao']  : '';
          $ev_btn_l = isset( $ev['btn_label'] )  ? $ev['btn_label']  : '';
          $ev_btn_u = isset( $ev['btn_url'] )    ? $ev['btn_url']    : '';

          if ( empty( $ev_title ) && empty( $ev_date ) ) continue;

          $type_label = ( $ev_type === 'virtual' ) ? 'Virtual' : 'Presencial';
          $item_id    = $accord_id . '-ev-' . (int) $i;
      ?>
          <div class="l40-acc-item">
            <button class="l40-acc-trigger" type="button"
                    aria-expanded="<?php echo ( $i === 0 ) ? 'true' : 'false'; ?>"
                    aria-controls="<?php echo l40_esc_attr( $item_id ); ?>">
              <span class="l40-acc-title"><?php echo l40_esc_text( $ev_title ?: 'Evento' ); ?></span>
              <span class="l40-acc-meta">
                <span class="l40-event-type l40-event-type--<?php echo l40_esc_attr( $ev_type ); ?>">
                  <?php echo l40_esc_text( $type_label ); ?>
                </span>
                <?php if ( ! empty( $ev_date ) ) : ?>
                  <span class="l40-acc-date"><?php echo l40_esc_text( $ev_date ); ?></span>
                <?php endif; ?>
              </span>
              <span class="l40-acc-icon" aria-hidden="true"></span>
            </button>

            <div id="<?php echo l40_esc_attr( $item_id ); ?>"
                 class="l40-acc-panel"
                 <?php echo ( $i === 0 ) ? '' : 'hidden'; ?>>
              <div class="l40-acc-body">
                <?php if ( ! empty( $ev_img ) ) : ?>
                  <div class="l40-acc-media">
                    <img src="<?php echo l40_esc_url( $ev_img ); ?>" alt="" loading="lazy">
                  </div>
                <?php endif; ?>

                <div class="l40-acc-content">
                  <?php if ( ! empty( $ev_desc ) ) echo wp_kses_post( $ev_desc ); ?>
                  <ul class="l40-event-info">
                    <?php if ( ! empty( $ev_date ) ) : ?>
                      <li><strong>Data:</strong> <?php echo l40_esc_text( $ev_date ); ?></li>
                    <?php endif; ?>
                    <?php if ( ! empty( $ev_time ) ) : ?>
                      <li><strong>Horário:</strong> <?php echo l40_esc_text( $ev_time ); ?></li>
                    <?php endif; ?>
                    <?php if ( ! empty( $ev_place ) ) : ?>
                      <li><strong><?php echo ( $ev_type === 'virtual' ) ? 'Formato:' : 'Local:'; ?></strong> <?php echo l40_esc_text( $ev_place ); ?></li>
                    <?php endif; ?>
                  </ul>
                  <?php if ( ! empty( $ev_btn_u ) && ! empty( $ev_btn_l ) ) : ?>
                    <a href="<?php echo l40_esc_url( $ev_btn_u ); ?>" class="l40-btn-secondary">
                      <?php echo l40_esc_text( $ev_btn_l ); ?>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
      <?php endforeach;
      else : ?>
        <p style="color:#475569;font-family:'Noto Sans',system-ui,sans-serif;">Nenhum evento cadastrado.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<style>
.l40-container{max-width:1180px;margin:0 auto;padding:0 20px;box-sizing:border-box;}
.l40-agenda-section{padding:40px 0;}
.l40-agenda-title{font-family:"Noto Sans",system-ui,sans-serif;font-size:1.8rem;margin-bottom:18px;color:#0f172a;}
.l40-accordion{display:grid;gap:12px;}
.l40-acc-item{background:#fff;border:1px solid rgba(12,67,128,.10);box-shadow:0 12px 28px rgba(2,23,55,.06);border-radius:14px;overflow:hidden;}
.l40-acc-trigger{width:100%;text-align:left;background:transparent;border:0;padding:16px 18px;cursor:pointer;display:grid;grid-template-columns:1fr auto auto;gap:12px;align-items:center;font-family:"Noto Sans",system-ui,sans-serif;}
.l40-acc-title{font-weight:900;color:#0f172a;line-height:1.2;}
.l40-acc-meta{display:inline-flex;gap:10px;align-items:center;justify-content:flex-end;white-space:nowrap;}
.l40-acc-date{color:#475569;font-weight:700;font-size:.95rem;}
.l40-acc-icon{width:14px;height:14px;border-right:2px solid rgba(12,67,128,.7);border-bottom:2px solid rgba(12,67,128,.7);transform:rotate(45deg);transition:transform .18s ease;margin-left:6px;}
.l40-acc-trigger[aria-expanded="true"] .l40-acc-icon{transform:rotate(-135deg);}
.l40-acc-panel{border-top:1px solid rgba(12,67,128,.10);}
.l40-acc-body{display:grid;grid-template-columns:320px 1fr;gap:16px;padding:16px 18px 18px;align-items:start;}
.l40-acc-media{border-radius:12px;overflow:hidden;background:#e9eef5;height:200px;}
.l40-acc-media img{width:100%;height:100%;object-fit:cover;display:block;}
.l40-acc-content{font-family:"Noto Sans",system-ui,sans-serif;color:#475569;}
.l40-event-info{margin:8px 0 0;padding-left:18px;}
.l40-event-info li{margin-bottom:4px;}
.l40-event-info strong{color:#0f172a;}
.l40-event-type{padding:4px 10px;border-radius:999px;font-size:.8rem;font-weight:700;}
.l40-event-type--presencial{background:rgba(12,67,128,.10);color:#0C4380;}
.l40-event-type--virtual{background:rgba(226,88,44,.10);color:#E2582C;}
.l40-btn-secondary{display:inline-block;margin-top:14px;padding:10px 20px;border-radius:30px;text-decoration:none;font-weight:800;border:2px solid #0C4380;color:#0C4380;font-family:"Noto Sans",system-ui,sans-serif;}
.l40-btn-secondary:hover{background:#0C4380;color:#fff;}
@media(max-width:900px){
  .l40-acc-trigger{grid-template-columns:1fr;}
  .l40-acc-meta{justify-content:flex-start;white-space:normal;flex-wrap:wrap;}
  .l40-acc-body{grid-template-columns:1fr;}
  .l40-acc-media{height:220px;}
}
</style>

<script>
(function(){
  var accordId = '<?php echo esc_js( $accord_id ); ?>';
  var root = document.getElementById(accordId);
  if (!root) return;

  var items = Array.prototype.slice.call(root.querySelectorAll('.l40-acc-item'));
  if (!items.length) return;

  function closeAll(exceptBtn){
    items.forEach(function(it){
      var btn=it.querySelector('.l40-acc-trigger');
      var panel=it.querySelector('.l40-acc-panel');
      if (!btn||!panel||btn===exceptBtn) return;
      btn.setAttribute('aria-expanded','false');
      panel.hidden=true;
    });
  }

  items.forEach(function(it){
    var btn=it.querySelector('.l40-acc-trigger');
    var panel=it.querySelector('.l40-acc-panel');
    if (!btn||!panel) return;
    btn.addEventListener('click',function(){
      var expanded=btn.getAttribute('aria-expanded')==='true';
      if(expanded){ btn.setAttribute('aria-expanded','false');panel.hidden=true; }
      else{ closeAll(btn);btn.setAttribute('aria-expanded','true');panel.hidden=false; }
    });
  });

  /* Abre o primeiro por padrão */
  var anyOpen=items.some(function(it){ var b=it.querySelector('.l40-acc-trigger'); return b&&b.getAttribute('aria-expanded')==='true'; });
  if(!anyOpen){
    var fb=items[0].querySelector('.l40-acc-trigger');
    var fp=items[0].querySelector('.l40-acc-panel');
    if(fb&&fp){ fb.setAttribute('aria-expanded','true');fp.hidden=false; }
  }
})();
</script>

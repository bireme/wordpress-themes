<?php
/**
 * Dobra: pagina-linha_do_tempo.php
 * Renderiza a linha do tempo (ACF Repeater: marcos)
 *
 * Campos (repeater "marcos"):
 * - ano_destaque (text)
 * - data_do_card (date_picker, return_format d/m/Y)
 * - titulo_do_card (text)
 * - breve_descricao (wysiwyg)
 * - marco (text) -> pill
 * - link_saiba_mais_opcional (text) -> URL
 *
 * Observação: este arquivo é chamado por lilacs_bvs_dobra('pagina-linha_do_tempo')
 */

if ( ! defined('ABSPATH') ) exit;

/**
 * Helpers
 */
if ( ! function_exists('lilacs_esc_text') ) {
  function lilacs_esc_text($v){ return esc_html((string)$v); }
}
if ( ! function_exists('lilacs_esc_url') ) {
  function lilacs_esc_url($v){ return esc_url((string)$v); }
}

/**
 * Converte "d/m/Y" -> "Y-m-d" para datetime do <time>.
 * Se falhar, retorna string vazia.
 */
function lilacs_date_dmy_to_ymd($dmy){
  $dmy = trim((string)$dmy);
  if ($dmy === '') return '';
  $dt = DateTime::createFromFormat('d/m/Y', $dmy);
  if (!$dt) return '';
  return $dt->format('Y-m-d');
}

/**
 * Detecta e retorna embed seguro para YouTube/Vimeo (quando for link).
 * Se não for vídeo, retorna ''.
 */
function lilacs_timeline_get_video_iframe_src($url){
  $url = trim((string)$url);
  if ($url === '') return '';

  // YouTube
  if (preg_match('~(youtube\.com/watch\?v=|youtu\.be/)([A-Za-z0-9_-]{6,})~', $url, $m)) {
    $id = $m[2];
    return 'https://www.youtube.com/embed/' . rawurlencode($id);
  }

  // Vimeo
  if (preg_match('~vimeo\.com/(\d+)~', $url, $m)) {
    $id = $m[1];
    return 'https://player.vimeo.com/video/' . rawurlencode($id);
  }

  // Caso já seja embed do YouTube/Vimeo (bem comum)
  if (strpos($url, 'youtube.com/embed/') !== false || strpos($url, 'player.vimeo.com/video/') !== false) {
    return $url;
  }

  return '';
}

/**
 * Pega um "media url" do card:
 * 1) se existir sub field "midia" (image/file/url) -> usa
 * 2) senão tenta sub field "midia_url"
 * 3) senão tenta "link_saiba_mais_opcional" (se for vídeo)
 *
 * Ajuste aqui caso você já tenha campos específicos para mídia no seu grupo ACF.
 */
function lilacs_timeline_get_media_candidate(){
  // tente campo mais comum (se existir)
  $candidate = '';

  if (function_exists('get_sub_field')) {
    // Se você criar no ACF um campo "midia" (image ou url), já funciona.
    $midia = get_sub_field('midia');
    if (is_array($midia) && !empty($midia['url'])) $candidate = $midia['url'];
    if (!$candidate && is_string($midia)) $candidate = $midia;

    if (!$candidate) {
      $midia_url = get_sub_field('midia_url');
      if (is_string($midia_url) && $midia_url !== '') $candidate = $midia_url;
    }
  }

  if (!$candidate) {
    // fallback: se o "saiba mais" for um vídeo do youtube/vimeo, renderiza como vídeo
    $maybe = function_exists('get_sub_field') ? get_sub_field('link_saiba_mais_opcional') : '';
    if (lilacs_timeline_get_video_iframe_src($maybe)) $candidate = $maybe;
  }

  return $candidate;
}

$marcos = function_exists('get_sub_field') ? get_sub_field('marcos') : [];
if (!is_array($marcos)) $marcos = [];
?>

<section class="ux-timeline" aria-label="Linha do tempo (com mídia)">
  <div class="ux-timeline__container">

    <header class="ux-timeline__header">
      <p class="ux-timeline__eyebrow">Histórico</p>
      <h2 class="ux-timeline__title">Linha do tempo</h2>
      <p class="ux-timeline__subtitle">
        Eventos com ano, data completa, título, descrição e mídia (imagem/vídeo) com limites para manter estética e legibilidade.
      </p>
    </header>

    <ol class="ux-timeline__list">
      <?php if ( empty($marcos) ) : ?>
        <li class="ux-timeline__item">
          <article class="ux-timeline__card">
            <h3 class="ux-timeline__cardTitle">Nenhum marco cadastrado</h3>
            <p class="ux-timeline__text">Adicione itens no repetidor <strong>Marcos</strong> dentro do ACF.</p>
          </article>
          <span class="ux-timeline__dot" aria-hidden="true"></span>
        </li>
      <?php else : ?>

        <?php foreach ($marcos as $i => $row) :
          $ano   = isset($row['ano_destaque']) ? $row['ano_destaque'] : '';
          $data  = isset($row['data_do_card']) ? $row['data_do_card'] : ''; // d/m/Y
          $titulo= isset($row['titulo_do_card']) ? $row['titulo_do_card'] : '';
          $desc  = isset($row['breve_descricao']) ? $row['breve_descricao'] : '';
          $pill  = isset($row['marco']) ? $row['marco'] : '';
          $link  = isset($row['link_saiba_mais_opcional']) ? $row['link_saiba_mais_opcional'] : '';

          $datetime = lilacs_date_dmy_to_ymd($data);
          $ariaDate = $data !== '' ? $data : ($ano !== '' ? $ano : ('Marco ' . ($i+1)));

          // Mídia (opcional): tenta pegar algo (ver função acima)
          // Como estamos em foreach com array bruto, não dá pra usar get_sub_field dentro da row atual.
          // Então: se você criar campos de mídia dentro do repeater, eles estarão dentro de $row. Ex:
          // $row['midia'] (image array) ou $row['midia_url'] (string).
          $media_candidate = '';
          if (!empty($row['midia']) && is_array($row['midia']) && !empty($row['midia']['url'])) $media_candidate = $row['midia']['url'];
          if (!$media_candidate && !empty($row['midia']) && is_string($row['midia'])) $media_candidate = $row['midia'];
          if (!$media_candidate && !empty($row['midia_url']) && is_string($row['midia_url'])) $media_candidate = $row['midia_url'];
          if (!$media_candidate && lilacs_timeline_get_video_iframe_src($link)) $media_candidate = $link;

          $video_src = lilacs_timeline_get_video_iframe_src($media_candidate);

          // imagem: se vier array de imagem em $row['midia'], prioriza alt
          $img_alt = '';
          if (!empty($row['midia']) && is_array($row['midia'])) {
            $img_alt = !empty($row['midia']['alt']) ? $row['midia']['alt'] : '';
          }

          $has_media = (bool) $media_candidate;
          $has_video = (bool) $video_src;

          // Link: garante URL válida
          $link_url = lilacs_esc_url($link);
          $has_link = ($link_url !== '');
        ?>
          <li class="ux-timeline__item">
            <article class="ux-timeline__card">
              <div class="ux-timeline__meta">
                <div class="ux-timeline__metaLeft">
                  <?php if ($ano !== '') : ?>
                    <span class="ux-timeline__year"><?php echo lilacs_esc_text($ano); ?></span>
                  <?php endif; ?>

                  <?php if ($data !== '') : ?>
                    <time class="ux-timeline__date" <?php echo $datetime ? 'datetime="'.esc_attr($datetime).'"' : ''; ?>>
                      <?php echo lilacs_esc_text($data); ?>
                    </time>
                  <?php endif; ?>
                </div>

                <?php if ($pill !== '') : ?>
                  <span class="ux-timeline__pill"><?php echo lilacs_esc_text($pill); ?></span>
                <?php endif; ?>
              </div>

              <?php if ($titulo !== '') : ?>
                <h3 class="ux-timeline__cardTitle"><?php echo lilacs_esc_text($titulo); ?></h3>
              <?php endif; ?>

              <?php if (!empty($desc)) : ?>
                <div class="ux-timeline__text">
                  <?php
                    // WYSIWYG: renderiza HTML permitido
                    echo wp_kses_post($desc);
                  ?>
                </div>
              <?php endif; ?>

              <?php if ($has_media) : ?>
                <?php if ($has_video) : ?>
                  <div class="ux-timeline__media ux-timeline__media--video" aria-label="<?php echo esc_attr('Vídeo do evento ' . $ariaDate); ?>">
                    <iframe
                      src="<?php echo esc_url($video_src); ?>"
                      title="<?php echo esc_attr('Vídeo do evento ' . $ariaDate); ?>"
                      loading="lazy"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowfullscreen
                      referrerpolicy="strict-origin-when-cross-origin"
                    ></iframe>

                    <?php if (!empty($row['midia_legenda'])) : ?>
                      <p class="ux-timeline__caption"><?php echo lilacs_esc_text($row['midia_legenda']); ?></p>
                    <?php endif; ?>
                  </div>
                <?php else : ?>
                  <figure class="ux-timeline__media" aria-label="<?php echo esc_attr('Mídia do evento ' . $ariaDate); ?>">
                    <img
                      src="<?php echo esc_url($media_candidate); ?>"
                      alt="<?php echo esc_attr($img_alt ?: 'Imagem do evento ' . $ariaDate); ?>"
                      loading="lazy"
                    />
                    <?php if (!empty($row['midia_legenda'])) : ?>
                      <figcaption class="ux-timeline__caption"><?php echo lilacs_esc_text($row['midia_legenda']); ?></figcaption>
                    <?php endif; ?>
                  </figure>
                <?php endif; ?>
              <?php endif; ?>

              <div class="ux-timeline__footer">
                <?php if (!empty($row['tag'])) : ?>
                  <span class="ux-timeline__tag"><?php echo lilacs_esc_text($row['tag']); ?></span>
                <?php else : ?>
                  <span class="ux-timeline__tag">LILACS</span>
                <?php endif; ?>

                <?php if ($has_link) : ?>
                  <a class="ux-timeline__link" href="<?php echo $link_url; ?>" aria-label="<?php echo esc_attr('Saiba mais sobre ' . $ariaDate); ?>">
                    Saiba mais <span aria-hidden="true">→</span>
                  </a>
                <?php endif; ?>
              </div>
            </article>

            <span class="ux-timeline__dot" aria-hidden="true"></span>
          </li>
        <?php endforeach; ?>

      <?php endif; ?>
    </ol>
  </div>
</section>

<style>
  /* =========================
     UX TIMELINE — Vertical (com mídia e limites)
     ========================= */

  :root{
    --ux-bg: #ffffff;
    --ux-surface: rgba(255,255,255,0.92);
    --ux-border: rgba(15, 23, 42, 0.12);
    --ux-text: #0f172a;
    --ux-muted: rgba(15, 23, 42, 0.72);

    --ux-accent: #2A377E;
    --ux-accent-2: #0EA5E9;

    --ux-line: rgba(42, 55, 126, 0.22);
    --ux-dot: var(--ux-accent);

    --ux-radius: 16px;
    --ux-shadow: 0 10px 30px rgba(15, 23, 42, 0.10);
    --ux-shadow-hover: 0 16px 40px rgba(15, 23, 42, 0.14);

    --ux-max: 1100px;

    /* Limites de mídia (para não “estourar” a página) */
    --ux-media-max-h-desktop: 320px; /* altura máxima da mídia em desktop */
    --ux-media-max-h-mobile: 240px;  /* altura máxima da mídia em mobile */
  }

  .ux-timeline{
    background: var(--ux-bg);
    color: var(--ux-text);
    padding: clamp(42px, 4.5vw, 80px) 20px;
  }

  .ux-timeline__container{
    max-width: var(--ux-max);
    margin: 0 auto;
  }

  .ux-timeline__header{
    max-width: 780px;
    margin: 0 auto clamp(22px, 3vw, 36px);
    text-align: center;
  }

  .ux-timeline__eyebrow{
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 10px;
    font-weight: 800;
    letter-spacing: .14em;
    text-transform: uppercase;
    font-size: 12px;
    color: var(--ux-accent);
  }
  .ux-timeline__eyebrow::before,
  .ux-timeline__eyebrow::after{
    content:"";
    width: 26px;
    height: 2px;
    border-radius: 99px;
    background: linear-gradient(90deg, rgba(42,55,126,0.0), rgba(42,55,126,0.8));
  }
  .ux-timeline__eyebrow::after{
    background: linear-gradient(90deg, rgba(42,55,126,0.8), rgba(42,55,126,0.0));
  }

  .ux-timeline__title{
    margin: 0 0 10px;
    font-size: clamp(26px, 3.2vw, 40px);
    line-height: 1.15;
    letter-spacing: -0.02em;
  }

  .ux-timeline__subtitle{
    margin: 0;
    font-size: 16px;
    line-height: 1.6;
    color: var(--ux-muted);
  }

  /* Lista + linha central */
  .ux-timeline__list{
    position: relative;
    list-style: none;
    margin: 0;
    padding: 10px 0 0;
  }

  .ux-timeline__list::before{
    content:"";
    position: absolute;
    top: 0;
    bottom: 0;
    left: 50%;
    width: 2px;
    transform: translateX(-50%);
    background: linear-gradient(
      to bottom,
      rgba(42,55,126,0.0),
      var(--ux-line) 10%,
      var(--ux-line) 90%,
      rgba(42,55,126,0.0)
    );
  }

  /* Item alternado */
  .ux-timeline__item{
    position: relative;
    display: grid;
    grid-template-columns: 1fr 1fr;
    column-gap: clamp(18px, 3vw, 46px);
    align-items: center;
    padding: clamp(14px, 2.4vw, 22px) 0;
  }

  .ux-timeline__item:nth-child(odd) .ux-timeline__card{
    grid-column: 1;
    justify-self: end;
  }
  .ux-timeline__item:nth-child(even) .ux-timeline__card{
    grid-column: 2;
    justify-self: start;
  }

  /* Card */
  .ux-timeline__card{
    width: min(100%, 560px);
    background: var(--ux-surface);
    border: 1px solid var(--ux-border);
    border-radius: var(--ux-radius);
    box-shadow: var(--ux-shadow);
    padding: clamp(16px, 2.2vw, 22px);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    transform: translateY(0);
    transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
    position: relative;
  }
  .ux-timeline__card:hover{
    transform: translateY(-2px);
    box-shadow: var(--ux-shadow-hover);
    border-color: rgba(42,55,126,0.22);
  }

  /* Conector card -> linha */
  .ux-timeline__item:nth-child(odd) .ux-timeline__card::after,
  .ux-timeline__item:nth-child(even) .ux-timeline__card::after{
    content:"";
    position:absolute;
    top: 46px;
    width: 18px;
    height: 2px;
    background: rgba(42,55,126,0.22);
  }
  .ux-timeline__item:nth-child(odd) .ux-timeline__card::after{ right: -18px; }
  .ux-timeline__item:nth-child(even) .ux-timeline__card::after{ left: -18px; }

  /* Meta com ano + data completa */
  .ux-timeline__meta{
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin: 0 0 10px;
  }

  .ux-timeline__metaLeft{
    display: grid;
    gap: 2px;
  }

  .ux-timeline__year{
    font-weight: 900;
    font-size: 14px;
    letter-spacing: .04em;
    color: var(--ux-accent);
    line-height: 1.1;
  }

  .ux-timeline__date{
    font-size: 13px;
    color: rgba(15, 23, 42, 0.62);
    line-height: 1.3;
  }

  .ux-timeline__pill{
    display: inline-flex;
    align-items: center;
    padding: 7px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 800;
    color: var(--ux-accent);
    background: rgba(42,55,126,0.10);
    border: 1px solid rgba(42,55,126,0.18);
    white-space: nowrap;
  }

  .ux-timeline__cardTitle{
    margin: 0 0 8px;
    font-size: 18px;
    line-height: 1.25;
    letter-spacing: -0.01em;
  }

  .ux-timeline__text{
    margin: 0 0 14px;
    color: var(--ux-muted);
    line-height: 1.65;
    font-size: 15px;
  }
  /* quando for WYSIWYG, garante listas e títulos agradáveis */
  .ux-timeline__text :where(p){ margin: 0 0 10px; }
  .ux-timeline__text :where(ul,ol){ margin: 0 0 10px 18px; }
  .ux-timeline__text :where(h1,h2,h3,h4){ margin: 12px 0 8px; line-height: 1.25; }

  /* =========================
     MÍDIA (imagem/vídeo) COM LIMITES
     ========================= */
  .ux-timeline__media{
    margin: 12px 0 0;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid rgba(15, 23, 42, 0.12);
    background: rgba(15, 23, 42, 0.04);
  }

  .ux-timeline__media img{
    display: block;
    width: 100%;
    max-height: var(--ux-media-max-h-desktop);
    height: auto;
    object-fit: cover;
  }

  .ux-timeline__media--video{
    padding: 0;
  }
  .ux-timeline__media--video iframe{
    display: block;
    width: 100%;
    height: min(320px, 56vw);
    max-height: var(--ux-media-max-h-desktop);
    border: 0;
    background: #000;
  }

  .ux-timeline__caption{
    margin: 0;
    padding: 10px 12px;
    font-size: 12px;
    color: rgba(15, 23, 42, 0.65);
    border-top: 1px solid rgba(15, 23, 42, 0.10);
    background: rgba(255,255,255,0.78);
  }

  /* Footer */
  .ux-timeline__footer{
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-top: 14px;
    padding-top: 12px;
    border-top: 1px dashed rgba(15, 23, 42, 0.16);
  }

  .ux-timeline__tag{
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 800;
    color: rgba(15, 23, 42, 0.70);
  }
  .ux-timeline__tag::before{
    content:"";
    width: 10px; height: 10px;
    border-radius: 999px;
    background: radial-gradient(circle at 30% 30%, var(--ux-accent-2), var(--ux-accent));
    box-shadow: 0 0 0 4px rgba(14,165,233,0.10);
  }

  .ux-timeline__link{
    font-weight: 900;
    font-size: 13px;
    text-decoration: none;
    color: var(--ux-accent);
    transition: transform .18s ease, opacity .18s ease;
    white-space: nowrap;
  }
  .ux-timeline__link:hover{
    opacity: .92;
    transform: translateX(2px);
  }

  /* Dot (marcador) */
  .ux-timeline__dot{
    position: absolute;
    left: 50%;
    top: 46px;
    transform: translate(-50%, -50%);
    width: 14px;
    height: 14px;
    border-radius: 999px;
    background: var(--ux-dot);
    box-shadow:
      0 0 0 6px rgba(42,55,126,0.14),
      0 12px 28px rgba(15, 23, 42, 0.18);
  }

  @media (prefers-reduced-motion: reduce){
    .ux-timeline__card,
    .ux-timeline__link{
      transition: none !important;
    }
  }

  /* Mobile */
  @media (max-width: 860px){
    :root{
      --ux-media-max-h-desktop: var(--ux-media-max-h-mobile);
    }

    .ux-timeline__list::before{
      left: 14px;
      transform: none;
    }

    .ux-timeline__item{
      grid-template-columns: 1fr;
      padding-left: 38px;
    }

    .ux-timeline__item:nth-child(odd) .ux-timeline__card,
    .ux-timeline__item:nth-child(even) .ux-timeline__card{
      grid-column: 1;
      justify-self: stretch;
      width: 100%;
    }

    .ux-timeline__dot{
      left: 14px;
      top: 46px;
      transform: translate(-50%, -50%);
    }

    .ux-timeline__item:nth-child(odd) .ux-timeline__card::after,
    .ux-timeline__item:nth-child(even) .ux-timeline__card::after{
      left: -22px;
      right: auto;
      top: 46px;
      width: 22px;
    }

    .ux-timeline__media--video iframe{
      height: min(240px, 62vw);
      max-height: var(--ux-media-max-h-mobile);
    }
  }
</style>

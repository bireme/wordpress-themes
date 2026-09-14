<?php
/**
 * Dobra: Revistas indexadas na LILACS
 * Arquivo sugerido: templates/dobras-acf/pagina_revistas_indexadas.php
 * ACF:
 * - imagem_de_fundo_
 * - titulo
 * - descricao_curta
 * - paises (repeater)
 *   - titulo
 *   - link
 *   - icone_do_pais
 *   - quantidade
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$imagem_de_fundo = get_sub_field( 'imagem_de_fundo_' ); // return_format = url
$titulo          = (string) get_sub_field( 'titulo' );
$descricao_curta = (string) get_sub_field( 'descricao_curta' );
$paises          = get_sub_field( 'paises' );

if ( ! is_array( $paises ) ) {
	$paises = [];
}

if ( empty( $titulo ) && empty( $descricao_curta ) && empty( $paises ) ) {
	return;
}

$uid = 'lilacs-journals-' . wp_unique_id();
?>

<section id="<?php echo esc_attr( $uid ); ?>" class="lilacs-journals" aria-label="Revistas indexadas na LILACS">
  <style>
    #<?php echo esc_attr( $uid ); ?>{
      padding:135px 20px 135px;
      background-color:#fff;
      <?php if ( ! empty( $imagem_de_fundo ) ) : ?>
        background-image:url('<?php echo esc_url( $imagem_de_fundo ); ?>');
        background-repeat:no-repeat;
        background-position:center center;
        background-size:cover;
      <?php endif; ?>
    }

    #<?php echo esc_attr( $uid ); ?> .jr-wrap{
      max-width:1280px;
      margin:0 auto;
    }

    #<?php echo esc_attr( $uid ); ?> .jr-title{
      font-family:'Noto Sans', sans-serif;
      color:#00205C;
      margin:0 0 6px;
      font-size:36px;
      font-weight:700;
      line-height:1.15;
    }

    #<?php echo esc_attr( $uid ); ?> .jr-sub{
      font-family:'Noto Sans', sans-serif;
      font-weight:400;
      font-size:18px;
      line-height:1.4;
      color:#00205C;
      margin:0 0 43px;
      max-width:980px;
    }

    #<?php echo esc_attr( $uid ); ?> .jr-grid{
      display:grid;
      grid-template-columns:repeat(5,1fr);
      gap:14px;
    }

    @media (max-width:1100px){
      #<?php echo esc_attr( $uid ); ?> .jr-grid{
        grid-template-columns:repeat(3,1fr);
      }
    }

    @media (max-width:720px){
      #<?php echo esc_attr( $uid ); ?> .jr-grid{
        grid-template-columns:repeat(2,1fr);
      }
    }

    @media (max-width:460px){
      #<?php echo esc_attr( $uid ); ?> .jr-grid{
        grid-template-columns:1fr;
      }
    }

    #<?php echo esc_attr( $uid ); ?> .jr-pill{
      position:relative;
      display:flex;
      flex-direction:column;
      justify-content:flex-start;
      min-height:75px;
      background:#ffffff;
      color:#085695;
      border-radius:10px;
      padding:26px 16px 14px;
      box-shadow:0 8px 20px rgba(3, 10, 24, .16);
      text-decoration:none;
      overflow:hidden;
      transition:all .15s ease-out;
    }

    #<?php echo esc_attr( $uid ); ?> .jr-pill:hover{
      filter:brightness(1.03);
      transform:translateY(-1px);
    }

    #<?php echo esc_attr( $uid ); ?> .jr-pill-main{
      display:flex;
      align-items:center;
      gap:12px;
      padding-right:24px;
    }

    #<?php echo esc_attr( $uid ); ?> .jr-pill h4{
      margin:0;
      font-family:'Noto Sans', sans-serif;
      font-weight:700;
      font-size:20px;
      line-height:1.35;
      color:#085695;
    }

    #<?php echo esc_attr( $uid ); ?> .jr-pill-text{
      display:flex;
      flex-direction:column;
      gap:2px;
      min-width:0;
      flex:1 1 auto;
    }

    #<?php echo esc_attr( $uid ); ?> .jr-total-badge{
      position:absolute;
      bottom:8px;
      right:7px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      padding:2px 10px;
      border-radius:999px;
      background:rgb(234 88 12);
      backdrop-filter:blur(4px);
      font-family:'Noto Sans', sans-serif;
      font-size:12px;
      font-weight:700;
      letter-spacing:.02em;
      text-transform:uppercase;
      white-space:nowrap;
      color:#fff;
      line-height:1.2;
    }

    #<?php echo esc_attr( $uid ); ?> .jr-arrow{
      position:absolute;
      right:10px;
      top:50%;
      transform:translateY(-50%);
      width:26px;
      height:26px;
      border-radius:999px;
      background:transparent;
      display:flex;
      align-items:center;
      color:#085695;
      justify-content:center;
    }

    #<?php echo esc_attr( $uid ); ?> .jr-arrow svg{
      width:14px;
      height:14px;
      stroke:#085695;
    }

    #<?php echo esc_attr( $uid ); ?> .jr-pill-thumb{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      width:48px;
      height:48px;
      border-radius:999px;
      overflow:hidden;
      flex-shrink:0;
      background:#fff;
    }

    #<?php echo esc_attr( $uid ); ?> .jr-pill-thumb img{
      width:100%;
      height:100%;
      object-fit:cover;
      display:block;
    }

    @media (max-width:720px){
      #<?php echo esc_attr( $uid ); ?>{
        padding:70px 16px;
      }

      #<?php echo esc_attr( $uid ); ?> .jr-pill{
        padding-right:44px;
      }

      #<?php echo esc_attr( $uid ); ?> .jr-title{
        font-size:30px;
      }

      #<?php echo esc_attr( $uid ); ?> .jr-sub{
        font-size:16px;
      }
    }
  </style>

  <div class="jr-wrap">
    <?php if ( ! empty( $titulo ) ) : ?>
      <h2 class="jr-title"><?php echo esc_html( $titulo ); ?></h2>
    <?php endif; ?>

    <?php if ( ! empty( $descricao_curta ) ) : ?>
      <p class="jr-sub"><?php echo esc_html( $descricao_curta ); ?></p>
    <?php endif; ?>

    <?php if ( ! empty( $paises ) ) : ?>
      <div class="jr-grid">
        <?php foreach ( $paises as $pais ) :
          $label    = trim( (string) ( $pais['titulo'] ?? '' ) );
          $url      = trim( (string) ( $pais['link'] ?? '' ) );
          $img_url  = trim( (string) ( $pais['icone_do_pais'] ?? '' ) );
          $total    = $pais['quantidade'] ?? '';

          if ( $label === '' ) continue;

          $tag_open  = $url ? '<a class="jr-pill" href="' . esc_url( $url ) . '">' : '<div class="jr-pill">';
          $tag_close = $url ? '</a>' : '</div>';
          echo $tag_open;
        ?>
            <div class="jr-pill-main">
              <?php if ( $img_url ) : ?>
                <span class="jr-pill-thumb">
                  <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $label ); ?>">
                </span>
              <?php endif; ?>

              <div class="jr-pill-text">
                <h4><?php echo esc_html( $label ); ?></h4>
              </div>
            </div>

            <?php if ( $total !== '' && $total !== null ) : ?>
              <span class="jr-total-badge"><?php echo esc_html( $total ); ?></span>
            <?php endif; ?>

            <span class="jr-arrow" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none">
                <path d="M9 18l6-6-6-6" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
        <?php
          echo $tag_close;
        endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php
/**
 * Bloco: Cursos em Destaques
 * Arquivo: pagina-cursos_em_destaques.php
 *
 * Usado dentro do Flexible Content "layout" (campo: cursos_em_destaques)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$titulo_sessao = get_sub_field( 'titulo_da_sessao' );
$cursos        = get_sub_field( 'cursos' );

if ( empty( $cursos ) ) {
    return;
}
?>

<section class="lilacs-cursos-destaques">
    <style>
        .lilacs-cursos-destaques{
            padding:56px 16px 72px;
        }
        .lilacs-cursos-destaques__inner{
            max-width:1180px;
            margin:0 auto;
        }
        .lilacs-cursos-destaques__title{
            font-family:'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-size:32px;
            font-weight:700;
            color:#00205c;
            margin:0 0 32px;
        }
        .lilacs-cursos-destaques__grid{
            display:grid;
            grid-template-columns:repeat(3, minmax(0,1fr));
            gap:24px;
        }
        .lilacs-cursos-destaques__card{
            background:#EDF2F7;
            border-radius:16px;
            padding:32px 28px 32px;
            box-shadow:0 8px 22px rgba(0,0,0,0.06);
            display:flex;
            flex-direction:column;
            height:100%;
        }
        .lilacs-cursos-destaques__icon{
            width:56px;
            height:56px;
            display:flex;
            align-items:center;
            justify-content:center;
            margin-bottom:20px;
            overflow:hidden;
        }
        .lilacs-cursos-destaques__icon img{
            max-width:100%;
            max-height:100%;
            object-fit:cover;
            display:block;
        }
        .lilacs-cursos-destaques__card-title{
            font-family:'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-size:16px;
            font-weight:700;
            color:#00205c;
            line-height:1.4;
            margin:0 0 14px;
        }
        .lilacs-cursos-destaques__card-title a{
            color:inherit;
            text-decoration:none;
        }
        .lilacs-cursos-destaques__card-title a:hover,
        .lilacs-cursos-destaques__card-title a:focus{
            text-decoration:underline;
        }
        .lilacs-cursos-destaques__desc{
            font-family:'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-size:14px;
            line-height:1.6;
            color:#11385c;
            margin:0 0 24px;
            flex:1 1 auto;
        }
        .lilacs-cursos-destaques__btn-wrap{
            margin-top:auto;
        }
        .lilacs-cursos-destaques__btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:10px 32px;
            border-radius:999px;
            border:none;
            background:#003f7d;
            color:#ffffff;
            font-family:'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-size:14px;
            font-weight:700;
            text-decoration:none;
            cursor:pointer;
            transition:background .2s ease, transform .1s ease, box-shadow .1s ease;
            box-shadow:0 4px 12px rgba(0,0,0,0.15);
        }
        .lilacs-cursos-destaques__btn:hover,
        .lilacs-cursos-destaques__btn:focus{
            background:#0054a3;
            transform:translateY(-1px);
            box-shadow:0 6px 16px rgba(0,0,0,0.18);
        }

        /* Responsivo */
        @media (max-width:1024px){
            .lilacs-cursos-destaques__grid{
                grid-template-columns:repeat(2, minmax(0,1fr));
            }
        }
        @media (max-width:768px){
            .lilacs-cursos-destaques{
                padding:40px 16px 56px;
            }
            .lilacs-cursos-destaques__title{
                font-size:26px;
                margin-bottom:24px;
            }
            .lilacs-cursos-destaques__grid{
                grid-template-columns:1fr;
            }
        }
    </style>

    <div class="lilacs-cursos-destaques__inner">
        <?php if ( $titulo_sessao ) : ?>
            <h2 class="lilacs-cursos-destaques__title">
                <?php echo esc_html( $titulo_sessao ); ?>
            </h2>
        <?php endif; ?>

        <div class="lilacs-cursos-destaques__grid">
            <?php foreach ( $cursos as $curso ) :
                $icone      = isset( $curso['icone_ou_imagem'] ) ? $curso['icone_ou_imagem'] : null;
                $titulo     = isset( $curso['titulo'] ) ? $curso['titulo'] : '';
                $descricao  = isset( $curso['descricao'] ) ? $curso['descricao'] : '';
                $texto_btn  = isset( $curso['texto_do_botao'] ) && $curso['texto_do_botao']
                                ? $curso['texto_do_botao']
                                : __( 'Ver mais', 'bireme' );
                $link       = isset( $curso['link'] ) ? $curso['link'] : '';
                ?>
                <article class="lilacs-cursos-destaques__card">
                    <div class="lilacs-cursos-destaques__icon">
                        <?php if ( $icone && ! empty( $icone['url'] ) ) : ?>
                            <img src="<?php echo esc_url( $icone['url'] ); ?>"
                                 alt="<?php echo esc_attr( $icone['alt'] ?? $titulo ); ?>">
                        <?php else : ?>
                            <!-- Ícone padrão (marcador) -->
                            <svg width="28" height="28" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill="#ffffff" d="M7 4c-1.1 0-2 .9-2 2v13l7-4 7 4V6c0-1.1-.9-2-2-2H7z"/>
                            </svg>
                        <?php endif; ?>
                    </div>

                    <?php if ( $titulo ) : ?>
                        <h3 class="lilacs-cursos-destaques__card-title">
                            <?php if ( $link ) : ?>
                                <a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener">
                                    <?php echo esc_html( $titulo ); ?>
                                </a>
                            <?php else : ?>
                                <?php echo esc_html( $titulo ); ?>
                            <?php endif; ?>
                        </h3>
                    <?php endif; ?>

                    <?php if ( $descricao ) : ?>
                        <div class="lilacs-cursos-destaques__desc">
                            <?php echo wp_kses_post( $descricao ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( $link ) : ?>
                        <div class="lilacs-cursos-destaques__btn-wrap">
                            <a class="lilacs-cursos-destaques__btn"
                               href="<?php echo esc_url( $link ); ?>"
                               target="_blank"
                               rel="noopener">
                                <?php echo esc_html( $texto_btn ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

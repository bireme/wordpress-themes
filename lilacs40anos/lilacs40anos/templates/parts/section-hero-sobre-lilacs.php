<?php
// pega o ID do post/página atual (admin ou frontend)
$post_id = get_queried_object_id() ?: ( isset($post->ID) ? $post->ID : 0 );

// valores padrão (mesmos textos usados originalmente)
$default_title = 'LILACS: 40 anos de ciência com identidade latino-americana';
$default_desc  = 'A LILACS conecta conhecimento, pessoas e políticas públicas para fortalecer a ciência em saúde na América Latina e Caribe';
$default_stats = [
	['number' => '+1.130 M', 'label' => 'Registros'],
	['number' => '+707 mil',  'label' => 'Textos completos'],
	['number' => '+2.600',    'label' => 'Revistas'],
	['number' => '30',        'label' => 'Países'],
	['number' => '9',         'label' => 'Idiomas'],
];

// carrega metas se estivermos em contexto de página/editar (se não houver, usa defaults)
$hero_title = $post_id ? get_post_meta( $post_id, '_lilacs_hero_title', true ) : '';
$hero_desc  = $post_id ? get_post_meta( $post_id, '_lilacs_hero_desc', true ) : '';
$hero_img_id = $post_id ? intval( get_post_meta( $post_id, '_lilacs_hero_bg_image_id', true ) ) : 0;
$hero_img_url = $hero_img_id ? wp_get_attachment_image_url( $hero_img_id, 'full' ) : '';

$stats = [];
for ( $i = 1; $i <= 5; $i++ ) {
	$num = $post_id ? get_post_meta( $post_id, "_lilacs_stat_{$i}_number", true ) : '';
	$lab = $post_id ? get_post_meta( $post_id, "_lilacs_stat_{$i}_label", true ) : '';
	if ( $num !== '' || $lab !== '' ) {
		$stats[] = [
			'number' => $num ?: $default_stats[$i-1]['number'],
			'label'  => $lab  ?: $default_stats[$i-1]['label'],
		];
	}
}
// se não houver estatísticas configuradas, utiliza defaults
if ( empty( $stats ) ) {
	$stats = $default_stats;
}

// fallback para títulos/descrição
if ( ! $hero_title ) $hero_title = $default_title;
if ( ! $hero_desc )  $hero_desc  = $default_desc;

// carrega metas de espaçamento (px)
$spacing_top    = $post_id ? intval( get_post_meta( $post_id, '_lilacs_section_spacing_top', true ) ) : 0;
$spacing_bottom = $post_id ? intval( get_post_meta( $post_id, '_lilacs_section_spacing_bottom', true ) ) : 0;

// --- NOVO: cor de fundo do hero ---
$bg_hero = $post_id ? get_post_meta( $post_id, '_lilacs_bg_hero', true ) : '';

$extra_style = '';
if ( $hero_img_url ) {
	$extra_style = "--hero-img: url('" . esc_url( $hero_img_url ) . "');";
}
if ( $spacing_top || $spacing_bottom ) {
	$extra_style .= ' margin-top:' . $spacing_top . 'px; margin-bottom:' . $spacing_bottom . 'px;';
}
if ( $bg_hero ) {
	$extra_style .= ' background-color:' . esc_attr( $bg_hero ) . ';';
}
?>

<style>
        #lilacs-hero {
            position: relative;
            background: linear-gradient(135deg, #0b2a4f 0%, #1a3a5c 25%, #2d1b4e 50%, #4a1a5c 75%, #2d1b4e 100%);
            overflow: hidden;
            padding: 60px 20px;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Poppins";
        }

        /* Efeito de fundo com padrão geométrico */
        #lilacs-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* imagem do hero (se definida) é aplicada primeiro, depois os gradientes decorativos */
            background-image: var(--hero-img), 
                radial-gradient(circle at 20% 50%, rgba(100, 200, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(150, 100, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 0%, rgba(100, 150, 255, 0.05) 0%, transparent 40%);
            background-size: cover;
            background-position: center right;
            background-repeat:no-repeat;
            pointer-events: none;
            z-index: 1;
        }

        .lilacs-container {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }

        .lilacs-content {
            display: flex;
            flex-direction: column;
            gap: 60px;
            align-items: left;
        }

        .lilacs-text h1 {
            width: 65%;
            font-size: clamp(28px, 5vw, 48px);
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .lilacs-text p {
            width: 65%;
            font-size: clamp(16px, 2vw, 24px);
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            margin-bottom: 0;
        }

        .lilacs-stats {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            margin-top: 50px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: clamp(24px, 4vw, 42px);
            font-weight: 700;
            color: #ffffff;
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: clamp(12px, 1.5vw, 14px);
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        /* Decoração geométrica no lado direito */
        .lilacs-decoration {
            position: absolute;
            right: -100px;
            top: 50%;
            transform: translateY(-50%);
            width: 400px;
            height: 400px;
            opacity: 0.15;
            z-index: 0;
        }

        .lilacs-decoration svg {
            width: 100%;
            height: 100%;
        }

        @media (max-width: 768px) {
            #lilacs-hero {
                padding: 40px 20px;
                min-height: auto;
            }

            .lilacs-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .lilacs-stats {
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
                margin-top: 40px;
            }

            .lilacs-decoration {
                display: none;
            }
        }

        @media (max-width: 480px) {
            #lilacs-hero {
                padding: 30px 15px;
            }

            .lilacs-text h1 {
                font-size: 24px;
            }

            .lilacs-text p {
                font-size: 14px;
            }

            .lilacs-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
                margin-top: 30px;
            }

            .stat-number {
                font-size: 28px;
            }

            .stat-label {
                font-size: 11px;
            }
        }
    </style>

    <section id="lilacs-hero" aria-label="LILACS: 40 anos de ciência com identidade latino-americana" <?php if ( $extra_style ) : ?> style="<?php echo esc_attr( $extra_style ); ?>"<?php endif; ?>>
        <div class="lilacs-decoration">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                <!-- Padrão geométrico decorativo -->
                <g stroke="rgba(255,255,255,0.3)" stroke-width="1" fill="none">
                    <polygon points="100,50 200,0 300,50 250,150 200,200 100,150"/>
                    <polygon points="200,100 280,130 300,210 220,240 140,210 160,130"/>
                    <circle cx="200" cy="150" r="80"/>
                    <line x1="50" y1="200" x2="350" y2="200"/>
                    <line x1="200" y1="50" x2="200" y2="350"/>
                    <polygon points="150,300 200,250 250,300 230,350 170,350"/>
                </g>
            </svg>
        </div>

        <div class="lilacs-container">
            <div class="lilacs-content">
                <div class="lilacs-text">
                    <h1><?php echo esc_html( $hero_title ); ?></h1>
                    <p><?php echo wp_kses_post( wpautop( wp_strip_all_tags( $hero_desc ) ) ); ?></p>
                </div>

                <div class="lilacs-stats">
                    <?php foreach ( $stats as $s ) : ?>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo esc_html( $s['number'] ); ?></div>
                            <div class="stat-label"><?php echo esc_html( $s['label'] ); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
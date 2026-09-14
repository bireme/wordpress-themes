<footer id="site-footer" class="lilacs-footer" role="contentinfo" aria-label="Rodapé do site">

  <?php
    // Idioma atual (Polylang)
    $lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'default';
    if (!$lang) $lang = 'default';

    // Opções do painel (por idioma)
    $logo_lilacs = lilacs_footer_opt('logo_lilacs_url', '', $lang);
    $logo_opas   = lilacs_footer_opt('logo_opas_bireme_url', '', $lang);
    $powered_img = lilacs_footer_opt('powered_by_image_url', '', $lang);

    $intro       = lilacs_footer_opt('intro_text', '', $lang);
    $copyright   = lilacs_footer_opt('copyright_text', '© Todos os direitos reservados', $lang);

    // Links (se quiser tornar configurável depois, dá pra adicionar no painel também)
    $logo_lilacs_link = home_url('/');
    $logo_opas_link   = '#';

    // Walker (pra submenus virarem lf-list--sub)
    $walker = new Lilacs_Footer_Menu_Walker();

    // Helper: renderiza um bloco (H3 + menu) com suas classes
    function lilacs_footer_render_block($block_key, $default_title, $lang, $walker) {
      $title = lilacs_footer_opt('block_title_' . $block_key, $default_title, $lang);
      $menu  = (int) lilacs_footer_opt('block_menu_' . $block_key, 0, $lang);

      if (!$title && !$menu) return;

      echo '<h3>' . esc_html($title) . '</h3>';

      if ($menu) {
        wp_nav_menu([
          'menu'        => $menu,
          'container'   => false,
          'fallback_cb' => false,
          'depth'       => 2,
          'walker'      => $walker,
          'items_wrap'  => '<ul class="lf-list">%3$s</ul>',
        ]);
      } else {
        // Mantém a estrutura pra não quebrar CSS/JS
        echo '<ul class="lf-list"></ul>';
      }
    }
  ?>

  <div class="lilacs-footer__top">
    <div class="container">

      <div class="lf-logos">
        <a class="lf-logo-lilacs" href="<?php echo esc_url($logo_lilacs_link); ?>" aria-label="LILACS">
          <?php if (!empty($logo_lilacs)): ?>
            <img src="<?php echo esc_url($logo_lilacs); ?>" alt="LILACS">
          <?php endif; ?>
        </a>

        <div class="lf-logos-row">
          <a class="lf-logo-opas logo-opas-bireme" href="<?php echo esc_url($logo_opas_link); ?>" aria-label="OPAS/OMS">
            <?php if (!empty($logo_opas)): ?>
              <img src="<?php echo esc_url($logo_opas); ?>" alt="OPAS / OMS">
            <?php endif; ?>
          </a>
        </div>
      </div>

      <span class="lf-divider" aria-hidden="true"></span>

      <div class="lf-content">

        <p class="lf-intro">
          <?php echo wp_kses_post($intro); ?>
        </p>

        <hr class="lf-hr">

        <div class="lf-grid">

          <!-- COLUNA 1: Home + Sobre (igual ao seu layout original) -->
          <nav class="lf-col">
            <?php
              lilacs_footer_render_block('home',  'Home',  $lang, $walker);
              lilacs_footer_render_block('sobre', 'Sobre', $lang, $walker);
            ?>
          </nav>

          <!-- COLUNA 2: Rede LILACS -->
          <nav class="lf-col">
            <?php lilacs_footer_render_block('rede', 'Rede LILACS', $lang, $walker); ?>
          </nav>

          <!-- COLUNA 3: Revistas + Indicadores + Contato -->
          <nav class="lf-col">
            <?php
              lilacs_footer_render_block('revistas',    'Revistas',    $lang, $walker);
              lilacs_footer_render_block('indicadores', 'Indicadores', $lang, $walker);
              lilacs_footer_render_block('contato',     'Contato',     $lang, $walker);
            ?>
          </nav>

        </div>
      </div>

    </div>
  </div>

  <div class="lilacs-footer__bottom">
    <div class="container">
      <div class="lf-powered">
        <span>Powered by</span>
        <?php if (!empty($powered_img)): ?>
          <img src="<?php echo esc_url($powered_img); ?>" alt="BIREME">
        <?php endif; ?>
      </div>

      <div class="lf-copy"><?php echo esc_html($copyright); ?></div>
    </div>
  </div>

</footer>

<?php // =================================================== ?>
<?php // INÍCIO DO SCRIPT DE ACCORDION DO RODAPÉ (ATUALIZADO) ?>
<?php // =================================================== ?>

<script>
/*
 * Script ATUALIZADO (v3) para o menu sanfona (accordion) do rodapé.
 *
 * Agora, ele verifica duas condições para criar um accordion:
 * 1. Se a coluna contém um submenu (como "Sobre" e "Rede LILACS")
 * 2. OU se o título da coluna é "Revistas"
 */
document.addEventListener('DOMContentLoaded', function() {

    // 1. Encontra todas as colunas de navegação
    const allColumns = document.querySelectorAll('.lf-grid .lf-col');

    // 2. Passa por cada coluna
    allColumns.forEach(col => {

        // 3. Verifica se esta coluna tem um submenu aninhado
        const hasSubList = col.querySelector('.lf-list--sub');
        const toggle = col.querySelector('h3');

        // Se não houver h3, pula para o próximo
        if (!toggle) {
            return;
        }

        // Pega o texto do H3 (ex: "Revistas", "Sobre", etc.)
        const h3Text = toggle.textContent.trim();

        // 4. CONDIÇÃO ATUALIZADA:
        //    É um accordion se (tem sub-lista) OU (o texto é "Revistas")
        if (hasSubList || h3Text === 'Revistas') {

            // 5. Adiciona a classe que o CSS usará para estilizar (seta, borda)
            toggle.classList.add('js-accordion-toggle');

            // 6. Adiciona o "ouvidor" de clique APENAS neste h3
            toggle.addEventListener('click', () => {

                // 7. Pega a lista (<ul>) que é irmã do <h3>
                const list = toggle.nextElementSibling;

                // 8. Adiciona/Remove a classe 'is-open' do H3 (para girar a seta)
                toggle.classList.toggle('is-open');

                // 9. Adiciona/Remove a classe 'is-open' da lista (para mostrar/esconder)
                if (list && list.classList.contains('lf-list')) {
                    list.classList.toggle('is-open');
                }
            });
        }
    });
});
</script>

<?php // =================================================== ?>
<?php // FIM DO SCRIPT DE ACCORDION DO RODAPÉ                ?>
<?php // =================================================== ?>

<?php wp_footer(); ?>

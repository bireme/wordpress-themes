<footer id="site-footer" class="lilacs-footer" role="contentinfo" aria-label="Rodapé do site">

  <div class="lilacs-footer__top">

    <div class="container">



      <div class="lf-logos">

        <a class="lf-logo-lilacs" href="#" aria-label="LILACS">

          <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/logo.png" alt="LILACS">

        </a>



        <div class="lf-logos-row">

          <a class="lf-logo-opas logo-opas-bireme" href="#" aria-label="OPAS/OMS">

            <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/opas__bireme.png" alt="OPAS / OMS">

          </a>

        </div>

      </div>



      <span class="lf-divider" aria-hidden="true"></span>



      <div class="lf-content">

        <p class="lf-intro">

          A BVS é um produto colaborativo, coordenado pela BIREME/OPAS/OMS. Como biblioteca, oferece acesso

          abrangente à informação científica e técnica em saúde. A BVS coleta, indexa e armazena citações de

          documentos publicados por diversas organizações. A inclusão de qualquer artigo, documento ou citação na

          coleção da BVS não implica endosso ou concordância da BIREME/OPAS/OMS com o seu conteúdo.

        </p>



        <hr class="lf-hr">



        <div class="lf-grid">

          <nav class="lf-col">

            <h3>Home</h3>

            <ul class="lf-list">

              <li><a href="#">Início</a></li>

            </ul>



            <h3>Sobre</h3>

            <ul class="lf-list">

              <li><a href="#">Sobre a LILACS</a></li>

              <li><a href="#">Metodologia LILACS (guias, manuais e normas técnicas)</a></li>

              <li><a href="#">Indicadores da LILACS</a></li>

              <li>

                <span class="lf-subgrp">Marcos históricos</span>

                <ul class="lf-list lf-list--sub">

                  <li><a href="#">40 anos da LILACS</a></li>

                  <li><a href="#">Site de comemoração de 35 anos</a></li>

                  <li><a href="#">Principais marcos históricos da LILACS</a></li>

                  <li><a href="#">Referências sobre a LILACS</a></li>

                </ul>

              </li>

            </ul>

          </nav>



          <nav class="lf-col">

            <h3>Rede LILACS</h3>

            <ul class="lf-list">

              <li><a href="#">Menu Rede</a></li>

              <li><a href="#">Coordenadores temáticos</a></li>

              <li><a href="#">Coordenadores nacionais</a></li>

              <li><a href="#">Áreas de atuação</a></li>

              <li><a href="#">Especialistas/Especialidades</a></li>

              <li><a href="#">Como ser membro da Rede</a></li>

              <li>

                <span class="lf-subgrp">Reuniões e capacitações:</span>

                <ul class="lf-list lf-list--sub">

                  <li><a href="#">Sessões Virtuais da LILACS (agenda e documentação)</a></li>

                </ul>

              </li>

            </ul>

          </nav>



          <nav class="lf-col">

            <h3>Revistas</h3>

            <ul class="lf-list">

              <li><a href="#">Critérios de seleção e permanência de periódicos LILACS</a></li>

              <li><a href="#">Como faço para minha revista ser indexada na LILACS</a></li>

              <li><a href="#">Lista de periódicos indexados na LILACS</a></li>

              <li><a href="#">Acompanhe a indexação da sua revista</a></li>

              <li><a href="#">Perfil de periódicos da LILACS</a></li>

            </ul>



            <h3>Indicadores</h3>

            <ul class="lf-list">

              <li><a href="#">Consultas e painéis</a></li>

            </ul>



            <h3>Contato</h3>

            <ul class="lf-list">

              <li><a href="#">Fale conosco</a></li>

            </ul>

          </nav>

        </div>

      </div>



    </div>

  </div>



  <div class="lilacs-footer__bottom">

    <div class="container">

      <div class="lf-powered">

        <span>Powered by</span>

        <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/powered_by.png" alt="BIREME">

      </div>

      <div class="lf-copy">© Todos os direitos reservados</div>

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

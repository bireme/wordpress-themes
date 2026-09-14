<?php
/**
 * Template Name: Lilacs Indicadores
 *
 * Lê o meta 'lilacs_indicator_groups' (categorias → tópicos) criado no admin
 * e renderiza o layout com navegação lateral + conteúdo à direita.
 */

get_header();
get_template_part('templates/parts/section', 'banner-como-pesquisar');
get_template_part('templates/parts/section', 'indicadores-lilacs');


get_footer();

<?php

class footer_Walker extends Walker_Nav_Menu {
    // Inicia o nível de profundidade (ex: cria a <ul>)
    function start_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '<ul class="list-unstyled">';
        }
    }

    // Fecha o nível de profundidade (ex: fecha a <ul>)
    function end_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '</ul>';
        }
    }

    // Inicia cada item do menu
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        if ( $depth === 0 ) {
            $output .= '<div class="group-site-map"><h5><a href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a></h5>';
        } else {
            $output .= '<li><a href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a></li>';
        }
    }

    // Finaliza cada item do menu
    function end_el( &$output, $item, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '</div>';
        }
    }
}

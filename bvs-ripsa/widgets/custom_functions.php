<?php
/*
    function get_image_path($src) {
        global $blog_id;
        if(is_multisite()){
            if(!is_main_site($blog_id)){
                $src = explode('/wp-content' , $src);
                $src = $src[1];
            }
        }
        if(isset($blog_id) && $blog_id > 0) {
            $imageParts = explode('/files/' , $src);
            if(isset($imageParts[1])) {
                $src = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
            }
        }
        return $src;
    }
*/

function iahx_form( $atts ) {
    // Attributes
    $atts = shortcode_atts( array(
        'action' => '',
        'lang'   => 'pt'
    ), $atts );

    return '<form name="searchForm" action="' . $atts["action"] . '" method="get">
        <input type="hidden" name="lang" value="' . $atts["lang"] . '">
        <input type="hidden" name="_charset_" value="">
        <div class="searchItens vhl-search">
            <input type="text" name="q" class="expression" style="width: 50%; text-align: center;" placeholder="Pesquisar">
            <div>
                <select class="inputText" name="index">
                    <option selected="true" value="">Todos os índices</option>
                    <option value="ti">Título</option>
                    <option value="au">Autor</option>
                    <option value="mh">Assunto</option>
                </select>

                &nbsp;onde:

                <select class="inputText" name="where">
                    <option value="">Todas as fontes</option>
                    <option value="FICHAS">Fichas de qualificação</option>
                    <option value="DOCS">Documentos RIPSA</option>
                    <option value="RELATORIOS">&nbsp;&nbsp;&nbsp;&nbsp;Relatórios</option>
                    <option value="PUBLICACOES">&nbsp;&nbsp;&nbsp;&nbsp;Produtos</option>
                    <option value="NORMATIVOS">&nbsp;&nbsp;&nbsp;&nbsp;Atos Normativos</option>
                    <option value="CONSULTA">Literatura de consulta RIPSA</option>
                    <option value="LILACS">LILACS</option>
                    <option value="PAHO">PAHO</option>
                    <option value="WHOLIS">WHOLIS</option>
                    <option value="LIS">LIS - catálogo de sites</option>
                </select>
                <input type="submit" value="Pesquisar" name="submit" class="submit">
            </div>
        </div>
    </form>';
}
add_shortcode('searchform', 'iahx_form');

function enable_third_row_buttons($buttons) {
    $buttons[] = 'fontselect';
    $buttons[] = 'backcolor';
    $buttons[] = 'image';
    $buttons[] = 'media';
    $buttons[] = 'anchor';
    $buttons[] = 'sub';
    $buttons[] = 'sup';
    $buttons[] = 'hr';
    $buttons[] = 'wp_page';
    $buttons[] = 'cut';
    $buttons[] = 'copy';
    $buttons[] = 'paste';
    $buttons[] = 'newdocument';
    $buttons[] = 'code';
    $buttons[] = 'cleanup';
    $buttons[] = 'styleselect';

    return $buttons;
}
//add_filter("mce_buttons_3", "enable_third_row_buttons");

//add_filter( 'tiny_mce_before_init', 'customFormatTinyMCE' );
function customFormatTinyMCE( $in ) {

    $in['wordpress_adv_hidden'] = false;

    return $in;
    
}

?>

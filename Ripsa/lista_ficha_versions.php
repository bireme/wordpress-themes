<?php

$version_list = array();

$solr_url = 'http://srv.homolog.bvsalud.org/iahx-controller/?site=ripsa&col=main&output=json&lang=pt&q=indicador_ripsa:"' . $indicador . '"&op=search';

$response = @file_get_contents($solr_url);

if ($response){
    $result = json_decode($response, true);
    $version_list = $result['diaServerResponse'][0]['facet_counts']['facet_fields']['year_cluster'];
}

$indicador_slug = str_replace('.','-',$indicador);

if ( count($version_list) > 1 ){
	echo '<div class="row-fluid bg-blue margintop10">';	
	echo '    <div class="padding7">';
	echo '		  <h3 class="row-fluid single-h3">' . __( 'Outras versões', 'Ripsa') . '</h3>';
	echo '        <ul id="aplicacao">';
	foreach( $version_list as $version){
		$year = $version[0];		
		// check if is current version
		if ($year != $edicao){
			echo '<li><a href="/' . $version[0] .'/'. $indicador_slug .'/?l=' . $site_lang . '">' .  $version[0] . '</a></li>';
		}else{
			echo '<li>' . $version[0] . '</li>';
		}
	}
	echo '       </ul>';
	echo '   </div>';
	echo '</div>';
}
?>


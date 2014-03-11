<?php

$version_list = array();

$solr_url = 'http://srv.bvsalud.org/iahx-controller/?site=ripsa&col=main&output=json&lang=pt&q=indicador_ripsa:"' . $indicador . '"&op=search';

$response = @file_get_contents($solr_url);

if ($response){
    $result = json_decode($response, true);
    $version_list = $result['diaServerResponse'][0]['facet_counts']['facet_fields']['year_cluster'];
}

$indicador_slug = str_replace('.','-',$indicador);

if ( count($version_list) > 1 ){
	echo '		  <span class="row-fluid single-servicos">';
	echo '		  <i class="i-oldversions"></i><span class="single-servicos-text">' . __( 'Outras versões', 'Ripsa') . '</span>';
	echo '	      </span>';
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
	
}
?>


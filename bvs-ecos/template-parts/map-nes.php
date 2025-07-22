<?php
$template_directory = get_template_directory_uri();

$args = array(
    'post_type' => 'nes-addresses',
    'posts_per_page' => -1
);

$nes_addresses_query = new WP_Query($args);
?>

<div id="grid-legend-map" class="row">
    <div class="col-12">
        <h5 class="title-legend visually-hidden"><?php _e("Legenda:", "bvs-ecos"); ?></h5>
    </div>
    <div class="col-12 col-sm-6 col-md-3 col-lg-3 item-legend">
        <img src="<?php echo $template_directory .'/inc/assets/imgs/icons/map-markers/green.png'; ?>" alt="icon green" class="img-fluid" />
        <label><?php _e("Ativos e institucionalizados estaduais", "bvs-ecos"); ?></label>
    </div>
    <div class="col-12 col-sm-6 col-md-3 col-lg-3 item-legend">
        <img src="<?php echo $template_directory .'/inc/assets/imgs/icons/map-markers/red.png'; ?>" alt="icon red" class="img-fluid" />
        <label><?php _e("Inativos e institucionalizados estaduais", "bvs-ecos"); ?></label>
    </div>
    <div class="col-12 col-sm-6 col-md-3 col-lg-3 item-legend">
        <img src="<?php echo $template_directory .'/inc/assets/imgs/icons/map-markers/blue.png'; ?>" alt="icon blue" class="img-fluid" />
        <label><?php _e("Ativos e institucionalizados municipais", "bvs-ecos"); ?></label>
    </div>
    <div class="col-12 col-sm-6 col-md-3 col-lg-3 item-legend">
        <img src="<?php echo $template_directory .'/inc/assets/imgs/icons/map-markers/yellow.png'; ?>" alt="icon yellow" class="img-fluid" />
        <label><?php _e("Ativos e sem institucionalização municipais", "bvs-ecos"); ?></label>
    </div>
</div>
<div id="grid-map-locations" class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-4 grid-list-locations">
        <div class="list-locations">

            <?php 
            $data_map = array();
            if ($nes_addresses_query->have_posts()) {
                $total_posts = $nes_addresses_query->found_posts;
                $current_post_index = 0;
                while ($nes_addresses_query->have_posts()) {
                    $nes_addresses_query->the_post(); 
                    $current_post_index++;

                    $latitude = get_post_meta($post->ID, 'nes_latitude_coord', true);
                    $longitude = get_post_meta($post->ID, 'nes_longitude_coord', true);
                    $icon_color = get_post_meta(get_the_ID(), 'nes_icon_color', true);

                    $raw_content = get_the_content();
                    $clean_content = preg_replace('/\r\n\r\n|\n\r\n\r|\n\n|\r\n|\n\r/', '<br>', wp_strip_all_tags($raw_content));

                    $data_map[] = array(
                        'title' => get_the_title(),
                        'content' => $clean_content,
                        'color' => $icon_color,
                        'lat' => $latitude,
                        'lng' => $longitude,
                    );
            ?>

            <div class="location-item row" data-lat="<?php echo esc_attr($latitude); ?>" data-lng="<?php echo esc_attr($longitude); ?>">
                <div class="col-auto">
                    <img src="<?php echo $template_directory .'/inc/assets/imgs/icons/map-markers/'.$icon_color.'.png'; ?>" alt="icon" class="img-fluid" />
                </div>
                <div class="col title-address">
                    <h5 class="title"><?php the_title(); ?></h5>
                    <?php the_content(); ?>
                </div>
            </div>

            <?php if($current_post_index !== $total_posts){ ?>
            <span class="separator"></span>
            <?php } ?>

        <?php
                }
                wp_reset_postdata();
            }
        ?>

        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-12 col-lg-8 grid-map">
        <div id="map"></div>

        <!-- Popup -->
        <div id="popup" class="ol-popup">
            <div id="popup-content"></div>
        </div>
    </div>
</div>
<script>
    // Inicializando o mapa com OpenLayers
    var map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM() // Fonte de mapa OpenStreetMap
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([-47.9292, -15.7801]), // Centralizado no Brasil
            zoom: 4
        })
    });

    // Função para criar estilo do marcador com base na cor
    function getMarkerStyle(color) {
        var icon = "<?php echo $template_directory; ?>/inc/assets/imgs/icons/map-markers/red.png";

        if (color == 'red') {
            icon = "<?php echo $template_directory; ?>/inc/assets/imgs/icons/map-markers/red.png";
        } else if (color == 'blue') {
            icon = "<?php echo $template_directory; ?>/inc/assets/imgs/icons/map-markers/blue.png";
        } else if (color == 'green') {
            icon = "<?php echo $template_directory; ?>/inc/assets/imgs/icons/map-markers/green.png";
        } else if (color == 'yellow') {
            icon = "<?php echo $template_directory; ?>/inc/assets/imgs/icons/map-markers/yellow.png";
        }

        return new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                src: icon // Ícone de marcador
            })
        });
    }

    // Função para criar marcadores
    function createMarker(lon, lat, title, content, color) {
        var marker = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat([lon, lat])),
            name: title, // nome do marcador
            address: content // endereco do marcador cadastrado no content do post
        });

        var markerStyle = getMarkerStyle(color);
        marker.setStyle(markerStyle);
        return marker;
    }

    // Locais com coordenadas e títulos
    var locations = <?php echo json_encode($data_map); ?>;

    // Adicionando marcadores no mapa
    var vectorSource = new ol.source.Vector();
    locations.forEach(function(location) {
        var marker = createMarker(location.lng, location.lat, location.title, location.content, location.color);
        vectorSource.addFeature(marker);
    });

    var vectorLayer = new ol.layer.Vector({
        source: vectorSource
    });
    map.addLayer(vectorLayer);

    // Criando popup
    var container = document.getElementById('popup');
    var content = document.getElementById('popup-content');
    var overlay = new ol.Overlay({
        element: container,
        autoPan: true,
        autoPanAnimation: {
            duration: 250
        }
    });
    map.addOverlay(overlay);

    // Evento de clique no mapa para abrir o popup
    map.on('singleclick', function(event) {
        var feature = map.forEachFeatureAtPixel(event.pixel, function(feature) {
            return feature;
        });

        if (feature) {
            var coordinates = feature.getGeometry().getCoordinates();
            var title = feature.get('name');
            var address = feature.get('address');

            content.innerHTML = '<h5 class="title">' + title + '</h5><p>' + address + '</p>';
            overlay.setPosition(coordinates);
        } else {
            overlay.setPosition(undefined);
        }
    });

    // Interação com os itens da lista
    document.querySelectorAll('.location-item').forEach(function(item) {
        item.addEventListener('click', function() {
            var lat = this.getAttribute('data-lat');
            var lng = this.getAttribute('data-lng');
            map.getView().animate({
                center: ol.proj.fromLonLat([lng, lat]),
                zoom: 12,
                duration: 1000
            });

            // Destacando o item clicado
            document.querySelectorAll('.location-item').forEach(function(i) {
                i.classList.remove('active');
            });
            this.classList.add('active');

            // Abrindo o pop-up
            var title_address = this.querySelector('.title-address').innerHTML;

            var coordinates = ol.proj.fromLonLat([lng, lat]);
            content.innerHTML = title_address;
            overlay.setPosition(coordinates);
        });
    });
</script>
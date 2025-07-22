<?php

add_action('init', 'nes_addresses_post_type');
function nes_addresses_post_type() {
    $labels = array(
        'name'                  => _x('Endereços NES', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('Endereço NES', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('Endereços NES', 'text_domain'),
        'name_admin_bar'        => __('Endereço NES', 'text_domain'),
    );

    $args = array(
        'label'                 => __('Endereço NES', 'text_domain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor'),
        'public'                => false, // Post type privado
        'publicly_queryable'    => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_nav_menus'     => false,
        'exclude_from_search'   => true,
        'has_archive'           => false,
        'capability_type'       => 'post',
        'rewrite'               => false, // Não terá link permanente
        'menu_icon'             => 'dashicons-location-alt'
    );

    register_post_type('nes-addresses', $args);
}

add_action('add_meta_boxes', 'nes_addresses_add_meta_boxes');
function nes_addresses_add_meta_boxes() {
    add_meta_box(
        'nes_address_location',
        'Localização',
        'nes_addresses_location_callback',
        'nes-addresses',
        'normal',
        'high'
    );
}

// Função callback para exibir os campos
function nes_addresses_location_callback($post) {
    // Recupera os valores salvos
    $latitude = get_post_meta($post->ID, 'nes_latitude_coord', true);
    $longitude = get_post_meta($post->ID, 'nes_longitude_coord', true);
    $icon_color = get_post_meta($post->ID, 'nes_icon_color', true);
    $template_directory = get_template_directory_uri();

    //default value
    if(empty($icon_color)){
        $icon_color = 'red';
    }

    ?>
    <!-- Campo de busca e mapa -->
    <div class="grid-fields-map">

        <div class="grid-input-group">
            <input type="text" id="address" placeholder="<?php _e('Pesquise pela cidade, bairro, rua, ou coordenadas...', 'bvs-ecos'); ?>">
            <button type="button" id="search-address" class="button button-primary button-large"><?php _e("Buscar", "bvs-ecos"); ?></button>
        </div>

        <div class="grid-input-group">
            <!-- Coordenadas -->
            <label for="nes_latitude">Latitude</label>
            <input type="text" id="nes_latitude" name="nes_latitude" value="<?php echo esc_attr($latitude); ?>" readonly>

            <label for="nes_longitude">Longitude</label>
            <input type="text" id="nes_longitude" name="nes_longitude" value="<?php echo esc_attr($longitude); ?>" readonly>
        </div>

    </div>

    <!-- Mapa -->
    <div id="map" style="height: 400px; width: 100%;"></div>

    <!-- Campo de seleção da cor do ícone -->
    <h4>Cor do Ícone:</h4>
    <div class="icon-color-options">
        <label>
            <input type="radio" name="nes_icon_color" value="red" <?php checked($icon_color, 'red'); ?>>
            <img src="<?php echo $template_directory; ?>/inc/assets/imgs/icons/map-markers/red.png" alt="Red Icon" style="width: 30px;">
        </label>
        <label>
            <input type="radio" name="nes_icon_color" value="blue" <?php checked($icon_color, 'blue'); ?>>
            <img src="<?php echo $template_directory; ?>/inc/assets/imgs/icons/map-markers/blue.png" alt="Blue Icon" style="width: 30px;">
        </label>
        <label>
            <input type="radio" name="nes_icon_color" value="green" <?php checked($icon_color, 'green'); ?>>
            <img src="<?php echo $template_directory; ?>/inc/assets/imgs/icons/map-markers/green.png" alt="Green Icon" style="width: 30px;">
        </label>
        <label>
            <input type="radio" name="nes_icon_color" value="yellow" <?php checked($icon_color, 'yellow'); ?>>
            <img src="<?php echo $template_directory; ?>/inc/assets/imgs/icons/map-markers/yellow.png" alt="Yellow Icon" style="width: 30px;">
        </label>
    </div>
    <style type="text/css">
        .grid-fields-map{
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            align-items: center;
        }

        .grid-fields-map .grid-input-group{
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .grid-fields-map .grid-input-group:first-child{
            width: 50%;
        }

        .grid-fields-map .grid-input-group #address{
            width: 80%;
        }

        .icon-color-options{
            display: flex;
            justify-content: space-around;
        }

        .icon-color-options > label{
            display: flex;
            align-items: center;            
            margin-bottom: 15px;
        }
    </style>

    <!-- Incluindo CSS e JS do OpenLayers -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v10.2.1/ol.css">
    <script src="https://cdn.jsdelivr.net/npm/ol@v10.2.1/dist/ol.js"></script>

    <script>
        var selectedIconColor = "<?php echo esc_attr($icon_color); ?>";
        var iconPaths = {
            red: '<?php echo $template_directory; ?>/inc/assets/imgs/icons/map-markers/red.png',
            blue: '<?php echo $template_directory; ?>/inc/assets/imgs/icons/map-markers/blue.png',
            green: '<?php echo $template_directory; ?>/inc/assets/imgs/icons/map-markers/green.png',
            yellow: '<?php echo $template_directory; ?>/inc/assets/imgs/icons/map-markers/yellow.png',
        };

        // Inicializando o mapa
        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([-47.9292, -15.7801]),
                zoom: 4
            })
        });

        var markerLayer;

        // Função para adicionar marcador
        function addMarker(coordinates) {
            var marker = new ol.Feature({
                geometry: new ol.geom.Point(coordinates)
            });

            var markerStyle = new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 1],
                    src: iconPaths[selectedIconColor],
                    scale: 0.8
                })
            });

            marker.setStyle(markerStyle);

            var vectorSource = new ol.source.Vector({
                features: [marker]
            });

            markerLayer = new ol.layer.Vector({
                source: vectorSource
            });

            map.addLayer(markerLayer);
        }

        // Evento para clique no mapa
        map.on('click', function(evt) {
            var coordinates = evt.coordinate;
            var lonLatCoordinates = ol.proj.toLonLat(coordinates);

            document.getElementById('nes_latitude').value = lonLatCoordinates[1].toFixed(6);
            document.getElementById('nes_longitude').value = lonLatCoordinates[0].toFixed(6);

            if (markerLayer) {
                map.removeLayer(markerLayer);
            }

            addMarker(coordinates);
        });

        // Função para buscar endereço na API Nominatim
        async function searchAddress(query) {
            const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=1`;
            const response = await fetch(url);
            const data = await response.json();
            return data.length > 0 ? data[0] : null;
        }

        // Evento para o botão de busca de endereço
        document.getElementById('search-address').addEventListener('click', async function() {
            const address = document.getElementById('address').value;

            if (address) {
                const result = await searchAddress(address);

                if (result) {
                    const lon = parseFloat(result.lon);
                    const lat = parseFloat(result.lat);

                    document.getElementById('nes_latitude').value = lat.toFixed(6);
                    document.getElementById('nes_longitude').value = lon.toFixed(6);

                    const coordinates = ol.proj.fromLonLat([lon, lat]);

                    if (markerLayer) {
                        map.removeLayer(markerLayer);
                    }

                    addMarker(coordinates);

                    map.getView().animate({
                        center: coordinates,
                        zoom: 14,
                        duration: 1000
                    });
                } else {
                    alert('<?php _e('Endereço não encontrado!', 'bvs-ecos'); ?>');
                }
            }
        });

        // Evento para a mudança da cor do ícone
        document.querySelectorAll('input[name="nes_icon_color"]').forEach(function(input) {
            input.addEventListener('change', function() {
                selectedIconColor = this.value;
                if (markerLayer) {
                    map.removeLayer(markerLayer);
                }
                const lon = parseFloat(document.getElementById('nes_longitude').value);
                const lat = parseFloat(document.getElementById('nes_latitude').value);
                if (!isNaN(lon) && !isNaN(lat)) {
                    const coordinates = ol.proj.fromLonLat([lon, lat]);
                    addMarker(coordinates);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const lon = parseFloat(document.getElementById('nes_longitude').value);
            const lat = parseFloat(document.getElementById('nes_latitude').value);
            if (!isNaN(lon) && !isNaN(lat)) {
                const coordinates = ol.proj.fromLonLat([lon, lat]);
                
                if (markerLayer) {
                    map.removeLayer(markerLayer);
                }

                addMarker(coordinates);

                map.getView().animate({
                    center: coordinates,
                    zoom: 14,
                    duration: 1000
                });
            }
        });
    </script>
    <?php
}

// Salvando os valores de latitude, longitude e cor do ícone
add_action('save_post', 'nes_addresses_save_meta_box_data');
function nes_addresses_save_meta_box_data($post_id) {
    if (array_key_exists('nes_latitude', $_POST)) {
        update_post_meta($post_id, 'nes_latitude_coord', sanitize_text_field($_POST['nes_latitude']));
    }

    if (array_key_exists('nes_longitude', $_POST)) {
        update_post_meta($post_id, 'nes_longitude_coord', sanitize_text_field($_POST['nes_longitude']));
    }

    if (array_key_exists('nes_icon_color', $_POST)) {
        update_post_meta($post_id, 'nes_icon_color', sanitize_text_field($_POST['nes_icon_color']));
    }
}

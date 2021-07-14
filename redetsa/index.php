<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/banners') ?>
<?php
$home = new WP_Query([
  'post_type' => 'page',
  'pagename' => 'home'
]);
while($home->have_posts()) : $home->the_post();
  $text = get_sub_field('text');
  $title_rss = get_sub_field('title_rss');
  $rss = get_sub_field('rss');
  $text_button = get_sub_field('text_button');
  $link_button = get_sub_field('link_button');
endwhile;
?>
<section class="padding1 color2">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <?php $text; ?>
      </div>
      <div class="col-md-6">
        <h3 class="title1"><?php $title_rss; ?></h3>
        <ul class="listRSS">
          <li>
            <a href="https://sites.bvsalud.org/redetsa/brisa/?filter=author:%22Red%20Argentina%20P%C3%BAblica%20de%20Evaluaci%C3%B3n%20de%20Tecnolog%C3%ADas%20Sanitarias%22" target="_blank">Tratamiento con Suero Equino Hiperinmune en pacientes con COVID-19</a>
            <span>4 de fevereiro de 2021</span>
          </li>
          <li>
            <a href="https://sites.bvsalud.org/redetsa/brisa/?filter=author:%22Red%20Argentina%20P%C3%BAblica%20de%20Evaluaci%C3%B3n%20de%20Tecnolog%C3%ADas%20Sanitarias%22" target="_blank">COVID-19 et biothérapies dirigées contre l’interleukine 6 ou son récepteur</a>
            <span>2 de fevereiro de 2021</span>
          </li>
          <li>
            <a href="https://sites.bvsalud.org/redetsa/brisa/?filter=author:%22Red%20Argentina%20P%C3%BAblica%20de%20Evaluaci%C3%B3n%20de%20Tecnolog%C3%ADas%20Sanitarias%22" target="_blank">Vacunas contra la COVID-19</a>
            <span>26 de janeiro de 2021</span>
          </li>
          <li>
            <a href="https://sites.bvsalud.org/redetsa/brisa/?filter=author:%22Red%20Argentina%20P%C3%BAblica%20de%20Evaluaci%C3%B3n%20de%20Tecnolog%C3%ADas%20Sanitarias%22" target="_blank">Tetraidrocanabinol 27 mg/ml + canabidiol 25 mg/ml para o tratamento sintomático da espasticidade moderada a grave relacionada à esclerose múltipla</a>
            <span>6 de janeiro de 2021</span>
          </li>
          <li>
            <a href="https://sites.bvsalud.org/redetsa/brisa/?filter=author:%22Red%20Argentina%20P%C3%BAblica%20de%20Evaluaci%C3%B3n%20de%20Tecnolog%C3%ADas%20Sanitarias%22" target="_blank">Implante biodegradável de dexametasona no tratamento do Edema Macular Diabético em pacientes não responsivos à terapia prévia com anti-VEGF</a>
            <span>6 de janeiro de 2021</span>
          </li>
        </ul>
        <a href="https://sites.bvsalud.org/redetsa/brisa/" target="_blank" class="btn btn-block btn-primary w-100">Más resultados en el portal BRISA</a>
      </div>
    </div>
  </div>
</section>

<section class="padding1">
  <div class="container">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php
      $home = new WP_Query([
        'post_type' => 'page',
        'pagename' => 'Home'
      ]);
      while($home->have_posts()) : $home->the_post();
        if( have_rows('group_2') ): ?>
          <?php while( have_rows('group_2') ): the_row(); $row = get_row(); $count = count($row)/5; $loop = 0; ?>
            <?php while ($count > $loop) : $loop++; ?>
              <?php
              $image = get_sub_field('image_'.$loop);
              $title = get_sub_field('title_'.$loop);
              $text = get_sub_field('text_'.$loop);
              $link = get_sub_field('link_'.$loop);
              $window = get_sub_field('window_'.$loop);
              ?>
              <?php if ( $title ) : ?>
                <article class="col col-md-6">
                  <div class="card h-100">
                    <img src="<?php echo esc_url($image['url']); ?>" class="card-img-top" alt="<?php echo esc_url($image['alt']); ?>">
                    <div class="card-body">
                      <a href="<?php echo $link; ?>" target="<?php echo $window; ?>">
                        <h5 class="card-title"><?php echo $title; ?></h5>
                        <p class="card-text"><?php echo $text; ?></p>
                      </a>
                    </div>
                  </div>
                </article>
              <?php endif; ?>
            <?php endwhile; ?>
          <?php endwhile; ?>
        <?php endif; ?>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<?php get_template_part('includes/noticias') ?>

<section class="padding1">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="card mb-3">
          <div class="row">
            <div class="col-md-4" style='overflow: hidden;'>
              <img src="<?php bloginfo('template_directory'); ?>/img/reuniao.jpg" alt="..." class="cardA" >
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Reuniones RedETSA</h5>
                <p class="card-text">
                  <a href="reunioes.php">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure assumenda eius iusto error tempora fugit aperiam cumque quas vero quasi eum neque, aliquam culpa libero ducimus facere dolores vel similique!</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-3">
          <div class="row">
            <div class="col-md-4" style='overflow: hidden;'>
              <img src="<?php bloginfo('template_directory'); ?>/img/webinar.jpg" alt="..." class="cardA" >
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">WEBINARS</h5>
                <p class="card-text">
                  <a href="webinar.php">Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis enim tempora laboriosam ad, odit. Nisi veritatis odit modi, sunt aut sequi quos quisquam vel fugiat nobis, itaque, amet fuga eligendi.</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> 
  </div>
</section>

<section class="padding1 color1">
  <div class="container">
    <h2 class="title1 marginB1">Conheça</h2>

    <div id="boxConheca">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"> <i class="fas fa-question-circle"></i> ¿Qué es RedETSA?</a>
          <a class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-globe-americas"></i> ​​Miembros</a>
          <a class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"><i class="fas fa-edit"></i> Cómo afiliarse?</a>
          <a class="nav-link" id="nav-historia-tab" data-bs-toggle="tab" href="#nav-historia" role="tab" aria-controls="nav-historia" aria-selected="false"><i class="fas fa-landmark"></i> Historia</a>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <p>Lanzada en Río de Janeiro, en junio de 2011, la Red de Evaluación de Tecnologia en  Salud de las Américas (RedETSA) es una red, sin fines de lucro, formada por ministerios de salud, autoridades reguladoras, agencias de evaluación de tecnologías en salud, centros colaboradores de la Organización Mundial de la Salud/Organización Panamericana de la Salud (OMS/OPS) e instituciones de educación e investigación en la región de las Américas. RedETSA cuenta 17 países representados por 34 instituciones , con el objetivo de fortalecer y promover el proceso de evaluación tecnologías sanitarias en las Américas, permitiendo el intercambio de información, para apoyar la toma de decisiones sobre regulación, incorporación, uso y sustitución de dichas tecnologías. La Red dirige reuniones y planes de formación a la distancia.</p>
            <a href="oquee.php" class="btn btn-sm btn-outline-primary">Más sobre: ​​que es RedETSA</a>
          </div>
          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Aliquid ad ipsum saepe quidem, quae quibusdam doloremque necessitatibus explicabo fuga, eius velit consequatur laborum, asperiores incidunt consectetur praesentium iusto? Nisi, qui?</p>
            <a href="membros.php" class="btn btn-sm btn-outline-primary">Más sobre: ​​Miembros</a>
          </div>
          <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
            <p>Para ser aceptado como nuevo miembro de RedETSA, la institución deberá cumplir con los siguientes requisitos:</p>
            <a href="comofiliarse.php" class="btn btn-sm btn-outline-primary">Más sobre: ​​Cómo ser afiliado</a>
          </div>
          <div class="tab-pane fade" id="nav-historia" role="tabpanel" aria-labelledby="nav-historia-tab">
            <p>Uno de los grandes retos de los sistemas de salud basados en la atención primaria de salud es la búsqueda de equidad, calidad de la atención y eficiencia. En este contexto, las tecnologías sanitarias desempeñan un papel esencial. Por un lado, son decisivas para la calidad de la atención y, por el otro, representan un impacto presupuestario cada vez mayor que puede amenazar la sostenibilidad de los sistemas de salud. Por esto, la decisión sobre las tecnologías que deben ser provistas por los sistemas de salud es clave para que los países logren obtener los máximos beneficios en la esfera de la salud.</p>
            <a href="historia.php" class="btn btn-sm btn-outline-primary">Más información sobre: ​​Nuestra Historia</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php get_footer(); ?>
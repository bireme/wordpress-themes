<?php
// Simulação de dados do curso
$course_data = [
    'title' => 'Curso de Editoração Científica',
    'subtitle' => 'Aprenda as melhores práticas para a gestão de periódicos.',
    'image_url' => '#',
    'description' => 'Este curso abrangente cobre desde a submissão de artigos até a publicação final, incluindo ética, revisão por pares e indexação.',
    'link' => '#'
];
?>
<section class="course-section-wrapper">
    <div class="course-section">
        <div class="course-header">
            <h1><?php echo $course_data['title']; ?></h1>
        </div>
        <div class="course-content">
            <div class="course-image-container">
                <img src="<?php echo $course_data['image_url']; ?>" alt="Imagem do Curso">
            </div>
            <div class="course-info">
                <h2><?php echo $course_data['subtitle']; ?></h2>
                <p><?php echo $course_data['description']; ?></p>
                <a href="<?php echo $course_data['link']; ?>" class="course-button">Inscreva-se Agora</a>
            </div>
        </div>
    </div>
</section>

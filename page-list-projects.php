<?php

/**
 * Template Name: Listado de Proyectos (No Sidebar)
 */

get_header();
?>
<main class="container section">
  <ul class="grid-list">
    <?php
    $args = array(
      'post_type' => 'adolfob_proyectos'
    );
    $projects = new WP_Query($args);
    while ($projects->have_posts()) {
      $projects->the_post();
    ?>
      <li class="card">
        <?php the_post_thumbnail(); ?>
        <div class="content">
          <a href="<?php the_permalink(); ?>">
            <h3><?php the_title() ?></h3>
          </a>

        </div>
      </li>
    <?php }
    wp_reset_postdata()
    ?>
  </ul>
</main>
<?php get_footer() ?>
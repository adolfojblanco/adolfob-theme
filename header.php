<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body>

  <header class="header">
    <div class="container nav-bar">
      <!-- logo -->
      <div class="logo">
        <img class="logo-img" src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="">
      </div>
      <!-- logo end -->
      <!-- navbar -->
      <?php
      $args = array(
        'theme_location' => 'main_menu',
        'container' => 'nav',
        'container_class' => 'main-menu'
      );
      wp_nav_menu($args);
      ?>
      <!-- navbar end -->
    </div>
  </header>
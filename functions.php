<?php

function adolfob_setup(){
  // Habilitar imagenes destacadas
  add_theme_support('post-thumbnails');

  // Titulos para SEO
  add_theme_support('title-tag');

} 

add_action('after_setup_theme', 'adolfob_setup');

/**
 * Register menus
 */
function adolfob_menu()
{
  register_nav_menus(array(
    'main_menu' => __('Menu Principal', 'adolfob'),
    'social_media_menu' => __('Redes Sociales', 'adolfob'),
    'footer_menu' => __('Pie de Pagina', 'adolfob')
  ));
}

add_action('init', 'adolfob_menu'); // Init se ejecuta al iniciar wordpress

/**
 * Register css sheets
 */
function adolfob_scripts_styles() {
  wp_enqueue_style('normalize', 'https://necolas.github.io/normalize.css/8.0.1/normalize.css', array(), '8.0.1');
  wp_enqueue_style('style', get_stylesheet_uri(), array('normalize'), '1.0.0'); // Pasamos la ubicación de las hoja de estilo
}

add_action('wp_enqueue_scripts', 'adolfob_scripts_styles');
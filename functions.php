<?php

function adolfob_setup()
{
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
function adolfob_scripts_styles()
{
  wp_enqueue_style('normalize', 'https://necolas.github.io/normalize.css/8.0.1/normalize.css', array(), '8.0.1');
  wp_enqueue_style('style', get_stylesheet_uri(), array('normalize'), '1.0.0'); // Pasamos la ubicación de las hoja de estilo
  wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
}

add_action('wp_enqueue_scripts', 'adolfob_scripts_styles');


/**
 * 1. Añadir un Meta Box para el repositorio Git
 */
function agregar_metabox_git_clases()
{
  add_meta_box(
    'metabox_git_clase',                 // ID único
    'Enlaces del proyecto:',             // Título
    'mostrar_metabox_git_clase',         // Función que renderiza el contenido
    'adolfob_proyectos',                 // Nombre de tu post type
    'normal',                            // Contexto
    'default'                            // Prioridad
  );
}
add_action('add_meta_boxes', 'agregar_metabox_git_clases');

/**
 * 2. Mostrar el campo URL en el Meta Box
 */
function mostrar_metabox_git_clase($post)
{
  // Obtener el valor guardado (si existe)
  $git_url = get_post_meta($post->ID, '_git_url', true);
  $web_url = get_post_meta($post->ID, '_web_url', true);

  // Nonce para seguridad
  wp_nonce_field('guardar_metabox_git', 'metabox_git_nonce');

  // Campo de entrada para la URL
  echo '<label for="git_url">URL del Repositorio Git (GitHub, GitLab, etc.):</label>';
  echo '<input type="url" id="git_url" name="git_url" value="' . esc_attr($git_url) . '" style="width:100%;"" />';
  echo '<br/>';
  echo '<br/>';
  // Campo de entrada para la URL
  echo '<label for="web_url">URL del proyecto:</label>';
  echo '<input type="url" id="web_url" name="web_url" value="' . esc_attr($web_url) . '" style="width:100%;"" />';
}

/**
 * 3. Guardar el valor del campo al actualizar el post
 */
function guardar_metabox_git_clase($post_id)
{
  // Verificar nonce y permisos
  if (!isset($_POST['metabox_git_nonce']) || !wp_verify_nonce($_POST['metabox_git_nonce'], 'guardar_metabox_git')) {
    return;
  }

  // Verificar nonce y permisos
  if (!isset($_POST['metabox_git_nonce']) || !wp_verify_nonce($_POST['metabox_git_nonce'], 'guardar_metabox_git')) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

  if (!current_user_can('edit_post', $post_id)) return;

  // Guardar el campo si existe
  if (isset($_POST['git_url'])) {
    update_post_meta(
      $post_id,
      '_git_url',
      esc_url_raw($_POST['git_url'])  // Limpia y guarda como URL válida
    );
  }
  if (isset($_POST['web_url'])) {
    update_post_meta(
      $post_id,
      '_web_url',
      esc_url_raw($_POST['web_url'])  // Limpia y guarda como URL válida
    );
  }
}
add_action('save_post', 'guardar_metabox_git_clase');

// Añadir meta box para SEO
function add_seo_meta_box()
{
  add_meta_box(
    'seo_meta_box',
    'Configuración SEO Personalizada',
    'show_seo_meta_box',
    'page',
    'normal',
    'high'
  );
}
add_action('add_meta_boxes', 'add_seo_meta_box');

// Mostrar los campos en el meta box
function show_seo_meta_box($post)
{
  wp_nonce_field('save_seo_meta', 'seo_meta_nonce');

  $meta_title = get_post_meta($post->ID, '_seo_meta_title', true);
  $meta_description = get_post_meta($post->ID, '_seo_meta_description', true);
  $meta_keywords = get_post_meta($post->ID, '_seo_meta_keywords', true);

  echo '<div style="margin-bottom: 15px;">';
  echo '<label for="seo_meta_title" style="display: block; margin-bottom: 5px; font-weight: bold;">Título SEO:</label>';
  echo '<input type="text" id="seo_meta_title" name="seo_meta_title" value="' . esc_attr($meta_title) . '" style="width: 100%; padding: 8px;">';
  echo '<p class="description">Máximo 60 caracteres</p>';
  echo '</div>';

  echo '<div style="margin-bottom: 15px;">';
  echo '<label for="seo_meta_description" style="display: block; margin-bottom: 5px; font-weight: bold;">Meta Descripción:</label>';
  echo '<textarea id="seo_meta_description" name="seo_meta_description" style="width: 100%; padding: 8px; min-height: 80px;">' . esc_textarea($meta_description) . '</textarea>';
  echo '<p class="description">Máximo 160 caracteres</p>';
  echo '</div>';

  echo '<div>';
  echo '<label for="seo_meta_keywords" style="display: block; margin-bottom: 5px; font-weight: bold;">Palabras Clave:</label>';
  echo '<input type="text" id="seo_meta_keywords" name="seo_meta_keywords" value="' . esc_attr($meta_keywords) . '" style="width: 100%; padding: 8px;">';
  echo '<p class="description">Separadas por comas</p>';
  echo '</div>';
}

// Guardar los datos
function save_seo_meta($post_id)
{
  if (!isset($_POST['seo_meta_nonce']) || !wp_verify_nonce($_POST['seo_meta_nonce'], 'save_seo_meta')) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

  if (!current_user_can('edit_post', $post_id)) return;

  if (isset($_POST['seo_meta_title'])) {
    update_post_meta($post_id, '_seo_meta_title', sanitize_text_field($_POST['seo_meta_title']));
  }

  if (isset($_POST['seo_meta_description'])) {
    update_post_meta($post_id, '_seo_meta_description', sanitize_textarea_field($_POST['seo_meta_description']));
  }

  if (isset($_POST['seo_meta_keywords'])) {
    update_post_meta($post_id, '_seo_meta_keywords', sanitize_text_field($_POST['seo_meta_keywords']));
  }
}
add_action('save_post', 'save_seo_meta');

// Mostrar en el head
function add_seo_tags_to_head()
{
  if (is_page()) {
    global $post;
    $meta_title = get_post_meta($post->ID, '_seo_meta_title', true);
    $meta_description = get_post_meta($post->ID, '_seo_meta_description', true);
    $meta_keywords = get_post_meta($post->ID, '_seo_meta_keywords', true);

    if ($meta_title) {
      echo '<meta name="title" content="' . esc_attr($meta_title) . '">' . "\n";
    }

    if ($meta_description) {
      echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
    }

    if ($meta_keywords) {
      echo '<meta name="keywords" content="' . esc_attr($meta_keywords) . '">' . "\n";
    }
  }
}
add_action('wp_head', 'add_seo_tags_to_head');

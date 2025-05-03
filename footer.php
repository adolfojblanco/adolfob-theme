<footer class="footer container">
  <hr>
  <div class="content-footer">
    <?php
    $args = array(
      'theme_location' => 'main_menu',
      'container' => 'nav',
      'container_class' => 'main-menu'
    );
    wp_nav_menu($args);
    ?>
    <p class="copyright">Todos los derechos reservados. <strong><?php echo get_bloginfo('name'). " © " .date('Y'); ?></strong></p>
  </div>
</footer>
<?php wp_footer() ?>
</body>

</html>
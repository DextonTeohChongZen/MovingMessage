<?php
add_action('wp_ajax_load_news_posts_by_ajax', 'load_news_posts_by_ajax');
add_action('wp_ajax_nopriv_load_news_posts_by_ajax', 'load_news_posts_by_ajax');

function load_news_posts_by_ajax() {
  check_ajax_referer('load_more_posts', 'security');
  $paged = $_POST['page'];
  $args = [
    'post_type'       => 'post',
    'order'           => 'DESC',
    'orderby'         => 'date',
    'posts_per_page'	=> get_posts_per_page_news(),
    'paged'           => $paged,
    'post_status'     => ['publish'],
  ];

  $query = new WP_Query($args);
  if ( $query->have_posts() ) :
    while ( $query->have_posts() ) : $query->the_post();
        echo \App\template('partials.newsfeed-grid');
    endwhile;
  endif;

  wp_die();
}
?>

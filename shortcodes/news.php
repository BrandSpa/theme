<?php 

function ra_news_sc( $atts ) {
	$at = shortcode_atts([], $atts);
    $query = new Wp_Query(array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ));

    $posts = array_map(function($item) {
		$attachment_id = get_post_thumbnail_id($item->ID);
		$item->post_thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail')[0];
		$item->post_image = wp_get_attachment_image_src($attachment_id, 'full')[0];
		$item->post_categories = get_the_category($item->ID);
		return $item;
	}, $query->get_posts());

    ob_start();
?>

<section class="news">
    <?php 
        foreach($posts as $post){
            echo "<pre>";
            print_r($post);
            echo "</pre>";
        }
    ?>
</section>

<?php
	return ob_get_clean();
}

add_shortcode( 'ra_news', 'ra_news_sc' );

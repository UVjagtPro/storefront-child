<?php
        /**
         * Template Name: WooCommerce Google Merchant test feed
         */

        $params = array(
                'posts_per_page' => -1, // Value "-1" displays all products in feed
                'post_type' => 'product'
        );

        $wc_query = new WP_Query($params);

        header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
        echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

?>

<rss version="2.0"
        xmlns:content="http://purl.org/rss/1.0/modules/content/"
        xmlns:wfw="http://wellformedweb.org/CommentAPI/"
        xmlns:dc="http://purl.org/dc/elements/1.1/"
        xmlns:atom="http://www.w3.org/2005/Atom"
        xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
        xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
        xmlns:g="http://base.google.com/ns/1.0">
        <?php do_action('rss2_ns'); ?>>
        
        <channel>
                <title><?php bloginfo_rss('name'); ?> - Google Merchant Test Feed</title>
                <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
                <link><?php bloginfo_rss('url') ?></link>
                <description><?php bloginfo_rss('description') ?></description>
                <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
                <sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
                <sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
                
                <?php do_action('rss2_head'); ?>

                <?php while ($wc_query->have_posts()) : $wc_query->the_post(); ?>  
 
                        <?php $regularPrice = get_post_meta( get_the_ID(), '_regular_price', true); ?>
                        <?php $salePrice = get_post_meta( get_the_ID(), '_sale_price', true); ?>
                        <?php $stockStatus = get_post_meta( get_the_ID(), '_stock_status', true); ?>
                        <?php $stockQuantity = $product->get_stock_quantity(); ?>
                        <?php $currency = get_woocommerce_currency_symbol(); ?>
                        <?php $brand = get_post_meta( get_the_ID(), '_brand', true ); ?>
                        <?php $condition = get_post_meta( get_the_ID(), '_condition', true ); ?>
                        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>

                        <item>
                                <g:id><?php echo $product->get_sku(); ?></g:id>
                                <title><?php echo $product->get_name(); ?></title>
                                <g:description><?php echo $product->get_short_description(); ?></g:description>
                                <link><?php the_permalink_rss(); ?></link>
                                <g:image_link><?php echo $image[0]; ?></g:image_link>
                                <g:availability> <?php if ($stockQuantity >= 1) 
                                {
                                        echo 'in stock';
                                } else {
                                        echo 'out of stock';
                                } 
                                ?></g:availability>
                                <g:price><?php echo $regularPrice ?> <?php echo $currency ?></g:price>
                                <g:brand><?php echo $brand ?></g:brand>
                                <g:condition><?php echo $condition ?></g:condition>

                                <?php rss_enclosure(); ?>
                                <?php do_action('rss2_item'); ?>
                        </item>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
        </channel>
</rss>
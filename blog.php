<?php

/**
		/*
	     * Template Name: Arkiv
	     */

/**

 * The template for displaying archive pages.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */

	get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="woocommerce columns-3">
				<ul class="products columns-3">

					<?php 

			        $args = array(
			        	// 'posts_per_page' => 9, // Value "-1" displays all products in feed	
		                'post_type' => 'post'
			        );

			        $wp_query = new WP_Query( $args);        

			        if( $wp_query->have_posts() ) :

						while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

							<li class="product post-item">
								<span class="post-image">
									<a href="<?php the_permalink(); ?>">
										<?php 
											if ( has_post_thumbnail()) 
											{
												the_post_thumbnail();
											}
										?>
									</a>
								</span>
								<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
								<span class="post-category"><?php the_category(', ');?></span>
							</li>

						<?php endwhile; ?>

					<?php endif; ?>

				</ul>

				<nav>
					<?php
					
					//global $wp_query; // you can remove this line if everything works for you
					 
					// don't display the button if there are not enough posts
					if (  $wp_query->max_num_pages > 1 )
						echo '
							<div class="wordpress_wrapper">
								<div class="wordpress_loadmore">More posts</div>
							</div>'; // you can use <a> as well
					?>
				</nav>

				<?php wp_reset_postdata(); ?>
				
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
/*do_action( 'storefront_sidebar' );*/
get_footer();

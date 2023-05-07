<?php
get_header();
?>
<section class="blog-sec-wp ptb-100" id="primary">
		<div class="container">
			<?php
	            $sidebar_position = get_theme_mod('anymags_sidebar_position', 'right');
	            if ($sidebar_position == 'left') {
	                $sidebar_position = 'has-left-sidebar';
	            } elseif ($sidebar_position == 'right') {
	                $sidebar_position = 'has-right-sidebar';
	            } elseif ($sidebar_position == 'no') {
	                $sidebar_position = 'no-sidebar';
	            }
        	?>
			<div class="row <?php echo esc_attr($sidebar_position); ?>">
				<div class="col-lg-8">
		<?php if ( have_posts() ) :

				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
		?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;?>

			 <div class="paging-navigation">
                        <nav class="navigation">
                            <?php
                             echo paginate_links();
                            ?> 
                        </nav>
                    </div>
					<?php 

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
		</div>
		<?php
            if (($sidebar_position == 'has-left-sidebar') || ($sidebar_position == 'has-right-sidebar')) { ?>
			<div class="col-md-4">
					<?php get_sidebar()?>
			</div>
			<?php } ?>
				
			</div>
		</div>
	</div>
</section>
<?php
get_footer();

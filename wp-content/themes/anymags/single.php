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

					<?php
					while ( have_posts() ) :
						the_post();

						include get_template_directory() . '/template-parts/postdata.php';


						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
				?>
				</div>
				<div class="col-md-4">
					<?php
							get_sidebar();
					?>
				</div>
			</div>
		</div>
	</section>
<?php
get_footer();
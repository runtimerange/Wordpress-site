<?php
/**
Template Name: Page Fullwidth
**/
?>
<?php get_header();?>
<section class="blog-sec-wp ptb-100" id="primary">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
	
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'page' );
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endwhile; // End of the loop.
				?>
				</div>
				
			</div>
		</div>
</section>
<?php get_footer();?>
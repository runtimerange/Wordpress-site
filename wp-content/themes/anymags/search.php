<?php
get_header();
?>
<section class="blog-sec-wp ptb-100" id="primary">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'anymags' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			?>

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
		<div class="col-md-4">
						<?php get_sidebar()?>
		</div>
				
		</div>
	</div>
</div>
</section>
<?php
get_footer();
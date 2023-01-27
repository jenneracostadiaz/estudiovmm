<?php
/*
* Template Name: Secondary Shop Pages
*/
?>

<?php get_header(); ?>

<div class="row">

	<div class="col-md-12">
		<main id="content">
			<div class="row">
				<div class="col-md-12">

					<?php while ( have_posts() ) : the_post(); ?>
						<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
							<h2 class="entry-title">
								<?php the_title(); ?>
							</h2>

							<div class="entry-content">
								<?php the_content(); ?>
								<?php wp_link_pages(); ?>
							</div>

						</article>
					<?php endwhile; ?>

				</div>
			</div>
		</main>
	</div>

</div>

<?php get_footer(); ?>

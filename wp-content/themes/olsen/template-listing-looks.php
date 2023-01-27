<?php
/*
* Template Name: Looks
*/
?>

<?php get_header(); ?>

<div id="site-section">
	<h2 class="section-title"><?php single_post_title(); ?></h2>
</div>

<div class="row">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php
			$base_category  = get_post_meta( get_the_ID(), 'looks_base_category', true );
			$posts_per_page = get_post_meta( get_the_ID(), 'looks_posts_per_page', true );
			$layout         = get_post_meta( get_the_ID(), 'looks_layout', true );

			$item_column_classes = '';
			$row_column_classes  = '';

			if( $layout == '3cols_full' ) {
				$row_column_classes  = 'col-md-12';
				$item_column_classes = 'col-md-4 col-sm-6';
			} else {
				$row_column_classes  = 'col-md-8';
				$item_column_classes = 'col-sm-6';
			}

			$args = array(
				'post_type' => 'post',
				'paged'     => ci_theme_get_page_var()
			);

			if ( $posts_per_page >= 1 ) {
				$args['posts_per_page'] = $posts_per_page;
			} elseif ( $posts_per_page <= - 1 ) {
				$args['posts_per_page'] = - 1;
			} else {
				$args['posts_per_page'] = get_option( 'posts_per_page' );
			}

			if ( ! empty( $base_category ) and $base_category >= 1 ) {
				$args['tax_query'] = array(
					array(
						'taxonomy'         => 'category',
						'field'            => 'term_id',
						'terms'            => intval( $base_category ),
						'include_children' => true
					)
				);
			}

			$q = new WP_Query( $args );
		?>

		<div class="<?php echo esc_attr( $row_column_classes ); ?>">
			<main id="content" class="entries-looks">

				<div class="row">
					<?php while( $q->have_posts() ): $q->the_post(); ?>
						<div class="<?php echo esc_attr( $item_column_classes ); ?>">
							<article id="look-<?php the_ID(); ?>" <?php post_class( 'entry entry-look' ); ?>>
								<a href="<?php the_permalink(); ?>">
									<div class="entry-overlay">
										<div class="entry-wrap">
											<div class="entry-meta">
												<time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
											</div>
											<h2 class="entry-title"><?php the_title(); ?></h2>
										</div>
									</div>
									<?php $secondary_image_id = get_post_meta( get_the_ID(), 'secondary_featured_id', true ); ?>
									<?php if ( $secondary_image_id ): ?>
										<div class="entry-featured">
											<a href="<?php the_permalink(); ?>">
												<img src="<?php echo esc_url( ci_theme_get_image_src( $secondary_image_id, 'ci_tall' ) ); ?>" alt="<?php the_title_attribute(); ?>"/>
											</a>
										</div>
									<?php elseif ( has_post_thumbnail() ) : ?>
										<div class="entry-featured">
											<?php the_post_thumbnail( 'ci_tall' ); ?>
										</div>
									<?php endif; ?>
								</a>
							</article>
						</div>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>

				</div>

				<?php ci_theme_pagination( array(), $q ); ?>

			</main>
		</div>

	<?php endwhile; ?>

	<?php if( $layout != '3cols_full' ): ?>
		<div class="col-md-4">
			<?php get_sidebar(); ?>
		</div>
	<?php endif; ?>

</div>

<?php get_footer(); ?>

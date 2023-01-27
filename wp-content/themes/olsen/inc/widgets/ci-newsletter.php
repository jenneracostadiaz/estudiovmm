<?php
if ( ! class_exists( 'CI_Widget_Newsletter' ) ):
	class CI_Widget_Newsletter extends WP_Widget {

		public function __construct() {
			$widget_ops  = array( 'description' => __( 'Provides styling for popular newsletter forms.', 'ci-theme' ) );
			$control_ops = array();
			parent::__construct( 'ci-newsletter', $name = __( 'Theme - Newsletter', 'ci-theme' ), $widget_ops, $control_ops );
		}

		public function widget( $args, $instance ) {
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$text  = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );

			echo $args['before_widget'];
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			?><div class="widget_ci_newsletter"><?php echo ! empty( $instance['filter'] ) ? wpautop( do_shortcode( $text ) ) : do_shortcode( $text ); ?></div><?php

			echo $args['after_widget'];
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title'] = strip_tags( $new_instance['title'] );
			if ( current_user_can( 'unfiltered_html' ) ) {
				$instance['text'] = $new_instance['text'];
			} else {
				$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); // wp_filter_post_kses() expects slashed
			}
			$instance['filter'] = ! empty( $new_instance['filter'] );

			return $instance;
		}

		public function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array(
				'title' => '',
				'text'  => '',
			) );

			$title = strip_tags( $instance['title'] );
			$text  = esc_textarea( $instance['text'] );
			?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ci-theme' ); ?></label><input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/></p>

			<p><?php _e( 'Paste your newsletter form as given by popular 3rd-party newsletter services, such as MailChimp, Campaign Monitor, etc.', 'ci-theme' ); ?></p>
			<p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Newsletter form HTML:', 'ci-theme' ); ?></label><textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea></p>

			<p><input id="<?php echo $this->get_field_id( 'filter' ); ?>" name="<?php echo $this->get_field_name( 'filter' ); ?>" type="checkbox" <?php checked( isset( $instance['filter'] ) ? $instance['filter'] : 0 ); ?> />&nbsp;<label for="<?php echo $this->get_field_id( 'filter' ); ?>"><?php _e( 'Automatically add paragraphs', 'ci-theme' ); ?></label></p>
			<?php
		}
	}

	register_widget( 'CI_Widget_Newsletter' );

endif;
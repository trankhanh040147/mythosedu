<?php
/**
 */

use TUTOR\Input;

?>
<!-- import css file: wp-content\plugins\tutor\assets\css\edit-lesson.css -->
<link rel="stylesheet" href="<?php echo theme_assets('dist/css/edit-lesson.css')  ?>" />

<form class="tutor_lesson_modal_form">
	<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); 
		$lesson_game_id = get_post_meta($post->ID, 'lesson_game_id', true);
		$lesson_game_checked = !empty($lesson_game_id) && $lesson_game_id != '0' ? 'checked' : '';
	?>
	<input type="hidden" name="action" value="tutor_modal_create_or_update_lesson">
	<input type="hidden" name="lesson_id" value="<?php echo esc_attr( $post->ID ); ?>">
	<input type="hidden" name="current_topic_id" value="<?php echo esc_attr( $topic_id ); ?>">

	<?php do_action( 'tutor_lesson_edit_modal_form_before', $post ); ?>

	<div class="tutor-mb-32">
		<label class="tutor-form-label"><?php esc_html_e( 'Lesson Name', 'tutor' ); ?></label>
		<input type="text" name="lesson_title" class="tutor-form-control" value="<?php echo esc_attr( stripslashes( $post->post_title ) ); ?>"/>
		<div class="tutor-form-feedback">
			<i class="tutor-icon-circle-info-o tutor-form-feedback-icon"></i>
			<div><?php esc_html_e( 'Lesson titles are displayed publicly wherever required.', 'tutor' ); ?></div>
		</div>
	</div>

	<!-- Checkbox Lesson Game: is lesson has game or not ? -->
	<div class="tutor-mb-32 lesson-game-wrapper" style="display: none !important">  <!-- hidden by style="display: none !important" -->
		<label class="tutor-form-label"><?php esc_html_e( 'Lesson Game', 'tutor' ); ?></label>
		<div class="tutor-form-checkbox-wrap">
        	<input type="checkbox" name="lesson_game" class="tutor-form-control" value="1" <?php echo $lesson_game_checked; ?> />
			<label><?php esc_html_e( 'Enable Lesson Game', 'tutor' ); ?></label>
		</div>
		<div class="tutor-form-feedback">
			<i class="tutor-icon-circle-info-o tutor-form-feedback-icon"></i>
			<div><?php esc_html_e( 'Enable Lesson Game to allow students to play a game after completing the lesson.', 'tutor' ); ?></div>
		</div>
		<!-- Game list: Game description - Game ID -->
		<div class="tutor-form-checkbox-wrap">
			<label class="tutor-form-label"><?php esc_html_e( 'Game List', 'tutor' ); ?></label>
			<div class="tutor-form-checkbox-wrap">
				<!-- select list game dummy -->
				<select name="lesson_game_id" id="lesson_game_id" class="tutor-form-control">
					<option value="0" <?php selected($lesson_game_id, '0'); ?>>
						<?php esc_html_e('Select Game', 'tutor'); ?>
					</option>
					<option value="1" <?php selected($lesson_game_id, '1'); ?>>
						<?php esc_html_e('Game 1', 'tutor'); ?>
					</option>
					<option value="2" <?php selected($lesson_game_id, '2'); ?>>
						<?php esc_html_e('Game 2', 'tutor'); ?>
					</option>
					<option value="3" <?php selected($lesson_game_id, '3'); ?>>
						<?php esc_html_e('Game 3', 'tutor'); ?>
					</option>
					<option value="4" <?php selected($lesson_game_id, '4'); ?>>
						<?php esc_html_e('Game 4', 'tutor'); ?>
					</option>
					<option value="5" <?php selected($lesson_game_id, '5'); ?>>
						<?php esc_html_e('Game 5', 'tutor'); ?>
					</option>
				</select>
			</div>
		</div>
	</div>

	<!-- JS: Hide-set null/Show lesson_game_id base on lesson_game  -->
	<script>
    (function ($) {
        $(document).ready(function () {
            // Initial state based on the checkbox
            if ($('input[name="lesson_game"]').is(':checked')) {
                $('#lesson_game_id').show();
            } else {
                $('#lesson_game_id').hide();
            }

            // Toggle visibility on click
            $('input[name="lesson_game"]').click(function () {
                if ($(this).is(':checked')) {
                    $('#lesson_game_id').show();
                } else {
                    $('#lesson_game_id').hide();
                    $('#lesson_game_id').val(0);
                }
            });
        });
    })(jQuery);
	</script>

	<div class="tutor-mb-32">
		<label class="tutor-form-label">
			<?php
			esc_html_e( 'Lesson Content', 'tutor' );

			if ( get_tutor_option( 'enable_lesson_classic_editor' ) ) {
				?>
				<a class="tutor-btn tutor-btn-link tutor-ml-12" 
					target="_blank" 
					href="<?php echo esc_url( get_admin_url() . 'post.php?post=' . esc_attr( $post->ID ) . '&action=edit' ); ?>" 
					data-lesson-id="<?php echo esc_attr( $post->ID ); ?>" 
					onclick="tutorLessonWPEditor(event)">
					<i class="tutor-icon-edit tutor-mr-8"></i> <?php echo esc_html_e( 'WP Editor', 'tutor' ); ?>
				</a>
				<?php
			}
			?>
		</label>

		<?php
			/**
			 * Allow iframe inside lesson modal
			 */
			add_filter( 'wp_kses_allowed_html', Input::class . '::allow_iframe', 10, 2 );
			$sanitized_content = wp_kses_post( wp_unslash( str_replace( 'data-mce-style', 'style', $post->post_content ) ) );
			wp_editor( $sanitized_content, 'tutor_lesson_modal_editor', array( 'editor_height' => 150 ) );
		?>

		<div class="tutor-form-feedback">
			<i class="tutor-icon-circle-info-o tutor-form-feedback-icon"></i>
			<div><?php esc_html_e( 'The idea of a summary is a short text to prepare students for the activities within the topic or week. The text is shown on the course page under the topic name.', 'tutor' ); ?></div>
		</div>
	</div>

	<div class="tutor-mb-32">
		<label class="tutor-form-label"><?php esc_html_e( 'Feature Image', 'tutor' ); ?></label>
		<?php
		$lesson_thumbnail_id = '';
		if ( has_post_thumbnail( $post->ID ) ) {
			$lesson_thumbnail_id = get_post_meta( $post->ID, '_thumbnail_id', true );
		}

		tutor_load_template_from_custom_path(
			tutor()->path . '/views/fragments/thumbnail-uploader.php',
			array(
				'media_id'   => $lesson_thumbnail_id,
				'input_name' => '_lesson_thumbnail_id',
			),
			false
		);
		?>
	</div>

	<?php
		require tutor()->path . 'views/metabox/video-metabox.php';
		do_action( 'tutor_lesson_edit_modal_after_video' );

		require tutor()->path . 'views/metabox/lesson-attachments-metabox.php';
		do_action( 'tutor_lesson_edit_modal_after_attachment' );

		do_action( 'tutor_lesson_edit_modal_form_after', $post );
	?>
</form>
<script>
	/**
	 * Without lesson ID don't redirect user to the edit
	 * 
	 */
	function tutorLessonWPEditor(e) {
		e.preventDefault();
		const currentTarget = e.currentTarget;
		lessonId = currentTarget.dataset.lessonId;
		if (lessonId == 0) {
			tutor_toast('Warning', 'You can access and edit this Lesson with WP Editor only when you update this Lesson at first.', 'warning');
			return;
		} else {
			window.open(currentTarget.href, '_blank');
		}
	}
</script>

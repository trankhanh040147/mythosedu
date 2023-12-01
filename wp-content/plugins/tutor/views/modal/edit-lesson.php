<form class="tutor_lesson_modal_form">
	<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
	<input type="hidden" name="action" value="tutor_modal_create_or_update_lesson">
	<input type="hidden" name="lesson_id" value="<?php echo esc_attr( $post->ID ); ?>">
	<input type="hidden" name="current_topic_id" value="<?php echo esc_attr( $topic_id ); ?>">

    <?php do_action('tutor_lesson_edit_modal_form_before', $post); ?>

    <div class="tutor-mb-32">
        <label class="tutor-form-label"><?php _e('Lesson Name', 'tutor'); ?></label>
        <div class="tutor-input-group">
            <input type="text" name="lesson_title" class="tutor-form-control" value="<?php echo stripslashes($post->post_title); ?>"/>
            <div class="tutor-input-feedback tutor-has-icon">
                <i class="tutor-icon-info-circle-outline-filled tutor-input-feedback-icon"></i>
                <?php _e('Lesson titles are displayed publicly wherever required.', 'tutor'); ?>
            </div>
        </div>
    </div>

    <div class="tutor-mb-32">
        <label class="tutor-form-label">
            <?php 
                _e('Lesson Content', 'tutor'); 
                $post_parent_id = wp_get_post_parent_id($topic_id);
                if (get_tutor_option('enable_lesson_classic_editor')){
                    ?>
                        <a class="tutor-ml-12" target="_blank" href="<?php echo esc_url(get_admin_url()); ?>post.php?post=<?php echo $post->ID; ?>&action=edit" >
                            <i class="tutor-icon-edit-filled"></i> <?php echo __('WP Editor', 'tutor'); ?>
                        </a>
                    <?php
                }
            ?>
        </label>
        <div class="tutor-input-group">
            <?php
                wp_editor(stripslashes($post->post_content), 'tutor_lesson_modal_editor', array( 'editor_height' => 150));
            ?>
            <div class="tutor-input-feedback tutor-has-icon tutor-mt-17">
                <i class="tutor-icon-info-circle-outline-filled tutor-input-feedback-icon"></i>
                <?php _e('The idea of a summary is a short text to prepare students for the activities within the section or week. The text is shown on the course page under the section name.', 'tutor'); ?>
            </div>
        </div>
    </div>
	
	<div class="tutor-mb-32">
        <label class="tutor-form-label"><?php _e('H5P', 'tutor'); $h5p_list = tutor_utils()->get_h5p_list();
					?></label>
        <div class="tutor-input-group">
            <!--<input type="number" name="h5p_option[h5p_id]" class="tutor-form-control" value="<?php echo tutor_utils()->get_h5p_option($post->ID, 'h5p_id') ?>"/>
            -->
			<div class="tutor-form-field-course-list">
				<select name="h5p_option[h5p_id]" class="tutor_select2 tutor-form-select">
				<option value="0">Please select</option>										
				<?php
					//var_dump($h5p_list);
					$h5p_used = tutor_utils()->h5p_used($post->ID);
					foreach($h5p_list as $hitem) {
						//if(in_array($hitem->id,$h5p_used)) continue;
						echo '<option ';
						if ($hitem->id == tutor_utils()->get_h5p_option($post->ID, 'h5p_id')) echo ' selected="true" ';
						echo ' value="'. $hitem->id.'">' . $hitem->title . '</option>';
					}
				?>
				</select>
			</div>	
			<div class="tutor-input-feedback tutor-has-icon">
                <i class="tutor-icon-info-circle-outline-filled tutor-input-feedback-icon"></i>
                <?php _e('Select the H5P to intergrate the H5P content to this lesson', 'tutor'); ?>
            </div>
        </div>
    </div>
	
	<div class="tutor-mb-32">
        <label class="tutor-form-label"><?php _e('Include this H5P in course total point', 'tutor');$checked= (tutor_utils()->get_h5p_option($post->ID, 'enable_h5p_points_to_course')==="0")?0:1; ?></label>
        <div class="tutor-input-group">
            <div class="tutor-row tutor-align-items-center">
                <div class="tutor-col-sm-12 tutor-col-md-12 tutor-mt-4 tutor-mb-4">
                    <label class="tutor-form-toggle">
						<input type="hidden" value="0" name="h5p_option[enable_h5p_points_to_course]" >
                        <input type="checkbox" class="tutor-form-toggle-input" value="1" name="h5p_option[enable_h5p_points_to_course]" <?php checked('1', $checked); ?> />
                        <span class="tutor-form-toggle-control"></span> <?php _e('Include H5P point: No - Yes', 'tutor'); ?>
                    </label>
                </div>
            </div>
            <p class="text-regular-small tutor-color-muted tutor-mt-12">
                <?php _e('Enable this option to add the points of this H5P to the points of the course.
						Default is yes.', 'tutor'); ?>
            </p>
        </div>
    </div>
	
	<div class="tutor-mb-32">
        <label class="tutor-form-label"><?php _e('Test Category', 'tutor'); ?></label>
        <div class="tutor-input-group">
			<?php $grade_categories = tutor_utils()->get_course_grades($post_parent_id); ?>
            <select name="h5p_option[grade_category]" class="tutor-form-select">
				<option value="0" >Please select one</option>
				<?php foreach($grade_categories as $grade_key=>$grade_category):?>
				<option value="<?php echo $grade_key;?>" <?php selected(tutor_utils()->get_h5p_option($post->ID, 'grade_category'), $grade_key); ?>><?php echo $grade_category[0]; ?> (<?php echo $grade_category[1] ?>%)</option>
				<?php endforeach;?>
            </select>
            <p class="tutor-input-feedback">
                <?php _e('Set the passing percentage for this H5P', 'tutor');?>
            </p>
        </div>
    </div>
	<div class="tutor-mb-32">
        <label class="tutor-form-label"><?php _e('Fullscreen View', 'tutor'); ?></label>
        <div class="tutor-input-group">
            <div class="tutor-row tutor-align-items-center">
                <div class="tutor-col-sm-12 tutor-col-md-12 tutor-mt-4 tutor-mb-4">
                    <label class="tutor-form-toggle">
                        <input type="checkbox" class="tutor-form-toggle-input" value="1" name="h5p_option[h5p_fullscreen]" <?php checked('1', tutor_utils()->get_h5p_option($post->ID, 'h5p_fullscreen')); ?> />
                        <span class="tutor-form-toggle-control"></span> <?php _e('View this H5P in fullscreen mode: No - Yes', 'tutor'); ?>
                    </label>
                </div>
            </div>
            <p class="text-regular-small tutor-color-muted tutor-mt-12">
                <?php _e('Enable this option to view this H5P in fullscreen mode.
						Default is disable.', 'tutor'); ?>
            </p>
        </div>
    </div>

    <div class="tutor-mb-32">
        <label class="tutor-form-label"><?php _e('Feature Image', 'tutor'); ?></label>
        <div class="tutor-input-group">
            <?php 
                $lesson_thumbnail_id = '';
                if (has_post_thumbnail($post->ID)){
                    $lesson_thumbnail_id = get_post_meta($post->ID, '_thumbnail_id', true);
                }

                tutor_load_template_from_custom_path(tutor()->path.'/views/fragments/thumbnail-uploader.php', array(
                    'media_id' => $lesson_thumbnail_id,
                    'input_name' => '_lesson_thumbnail_id'
                ), false);
            ?>
        </div>
    </div>

    <?php
        include tutor()->path.'views/metabox/video-metabox.php';
        do_action( 'tutor_lesson_edit_modal_after_video' );
        
        include tutor()->path.'views/metabox/lesson-attachments-metabox.php';
        do_action( 'tutor_lesson_edit_modal_after_attachment' );
        
        do_action('tutor_lesson_edit_modal_form_after', $post); 
    ?>
</form>
<script type='text/javascript' src='/wp-content/plugins/tutor/assets/js/tutor-front.min.js?ver=2.0.0' id='tutor-frontend-js'></script>
<style type="text/css">
.selection .select2-selection--single{display:none}	
body.tutor-screen-course-builder .select2-container {
    display:none;
}
.tutor-dropdown-select{width:500px}
</style>
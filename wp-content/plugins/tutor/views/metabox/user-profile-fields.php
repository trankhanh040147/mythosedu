<h2><?php _e( 'Informations', 'tutor' ); ?></h2>

<?php
/**
 * Enqueue Media Scripts
 */
wp_enqueue_media();
?>

<table class="form-table">
	<?php do_action('tutor_backend_profile_fields_before'); ?>
	<tr class="user-description-wrap">
		<th><label for="description"><?php esc_html_e( 'VUS Member', 'tutor' ); ?></label></th>
		<td>
			<?php 
				$_tutor_vus_member = esc_attr( get_user_meta( $user->ID, '_tutor_vus_member', true ) ); 
				if(!$_tutor_vus_member) $_tutor_vus_member = 'Internal';
			?>
			<select name="_tutor_vus_member" id="tutor_vus_member">
				<option value="Internal" <?php if($_tutor_vus_member=='Internal') echo 'selected="selected"';?>>Internal</option>
				<option value="External" <?php if($_tutor_vus_member=='External') echo 'selected="selected"';?>>External</option>
			</select>
		</td>
	</tr>
	<tr class="user-description-wrap">
		<th><label for="description"><?php esc_html_e( 'Gender', 'tutor' ); ?></label></th>
		<td>
			<?php 
				$_tutor_gender = esc_attr( get_user_meta( $user->ID, '_tutor_gender', true ) ); 
				if(!$_tutor_gender) $_tutor_gender = 'Others';
			?>
			<select name="_tutor_gender" id="tutor_gender">
				<option value="Male" <?php if($_tutor_gender=='Male') echo 'selected="selected"';?>>Male</option>
				<option value="Female" <?php if($_tutor_gender=='Female') echo 'selected="selected"';?>>Female</option>
				<option value="Others" <?php if($_tutor_gender=='Others') echo 'selected="selected"';?>>Others</option>
			</select>
		</td>
	</tr>
	<tr class="user-description-wrap">
		<th><label for="description"><?php esc_html_e( 'D.O.B', 'tutor' ); ?></label></th>
		<td>
			<?php 
				$_tutor_age =  get_user_meta( $user->ID, '_tutor_age', true ) ; 
				
			?>
			<input type="date" name="_tutor_age" id="_tutor_age" value="<?php echo $_tutor_age;?>" class="regular-text">
		</td>
	</tr>
	
	<tr class="user-description-wrap">
		<th><label for="description"><?php esc_html_e( 'Manage Campus', 'tutor' ); ?></label></th>
		<td class="td_branchs">
		<?php
			$branchs = tutor_utils()->get_branchs();
			$manage_branchs = tutor_utils()->get_user_manage_branchs($user->ID);
			$manage_branchs_name = tutor_utils()->get_user_manage_branchs_name($manage_branchs);
		?>
			<select multiple="multiple" id="ure_select_other_roles_2" name="sl_manage_branchs" style="width: 700px;" >
				<?php
	                foreach ($branchs as $ke=>$val){
		                echo "<option value='{$ke}'>{$val}</option>";
	                }
	            ?>
			</select><br>
			<input type="hidden" name="ip_manage_branchs" id="ure_other_roles_2" value="<?php echo $manage_branchs;?>" />
			<span id="ure_other_roles_list_2"><?php echo $manage_branchs_name;?></span>
		</td>
	</tr>
	<tr class="user-description-wrap">
		<th><label for="description"><?php esc_html_e( 'Manage Users', 'tutor' ); ?></label></th>
		<td class="td_users">
		<?php
			$users_list = get_users(array(
							'role'    => 'subscriber',
							'orderby' => 'user_nicename',
							'order'   => 'ASC'
						));
			$manage_users = tutor_utils()->get_user_manage_users($user->ID);
			$manage_users_name = tutor_utils()->get_user_manage_users_name($manage_users);
		?>
			<select multiple="multiple" id="ure_select_other_roles_3" name="sl_manage_users" style="width: 700px;" >
				<?php
	                foreach ($users_list as $us){
		                echo "<option value='{$us->ID}'>{$us->display_name}</option>";
	                }
	            ?>
			</select><br>
			<input type="hidden" name="ip_manage_users" id="ure_other_roles_3" value="<?php echo $manage_users;?>" />
			<span id="ure_other_roles_list_3"><?php echo $manage_users_name;?></span>
		</td>
	</tr>

	<tr class="user-description-wrap">
		<th><label for="description"><?php esc_html_e( 'Department Name', 'tutor' ); ?></label></th>
		<td class="td_groups">
		<?php
			// $branchs = tutor_utils()->get_branchs();
			// $manage_branchs = tutor_utils()->get_user_manage_branchs($user->ID);
			$__deparments = _DEFINE_DEPARTMENT_NAME;

			$DepartmentName_profile = tutor_utils()->get_DepartmentName($user->ID); //var_dump($DepartmentName_profile);
		?>
			
			<div class="w3-col s4">
			<?php
					$indx = 1;
	                foreach ($__deparments as $ke=>$val){
						$checkedbox = '';
						$find_me = trim($val);
						if ($DepartmentName_profile != "" && str_contains($DepartmentName_profile, $find_me ) ) {
							$checkedbox = 'checked="checked"';
						}
						$indx ++;
			?>
						<label class="checkcontainer"><?php echo $val; ?>
							<input type="checkbox" <?php echo $checkedbox;?> name="ip_DepartmentName[]" id="ure_DepartmentName_2" value="<?php echo $val;?>">
							<span class="checkmark"></span>
						</label>
			<?php
	                }
	        ?>
			</div>
		</td>
	</tr>

	<tr class="user-description-wrap">
		<th><label for="description"><?php esc_html_e( 'Job Title', 'tutor' ); ?></label></th>
		<td>
			<input type="text" name="_tutor_profile_job_title" id="_tutor_profile_job_title" value="<?php echo esc_attr( get_user_meta( $user->ID, '_tutor_profile_job_title', true ) ); ?>" class="regular-text" />
		</td>
	</tr>

	<tr class="user-description-wrap">
		<th><label for="description"><?php esc_html_e( 'Profile Bio', 'tutor' ); ?></label></th>
		<td>
			<?php
			$settings = array(
				'teeny' => true,
				'media_buttons' => false,
				'quicktags' => false,
				'editor_height' => 200,
			);
			wp_editor( get_user_meta( $user->ID, '_tutor_profile_bio', true ), '_tutor_profile_bio', $settings );
			?>

			<p class="description"><?php esc_html_e( 'Write a little bit more about you, it will show publicly.', 'tutor' ); ?></p>
		</td>
	</tr>

	<tr class="user-description-wrap">
		<th><label for="description"><?php esc_html_e( 'Profile Photo', 'tutor' ); ?></label></th>
		<td>
			<div class="tutor-video-poster-wrap">
				<p class="video-poster-img">
					<?php
					$user_profile_photo = get_user_meta( $user->ID, '_tutor_profile_photo', true );
					if ( $user_profile_photo ) {
						echo '<img src="' . esc_url( wp_get_attachment_image_url( $user_profile_photo ) ) . '"/>';
					}
					?>
				</p>
				<input type="hidden" name="_tutor_profile_photo" value="<?php echo esc_attr( $user_profile_photo ); ?>">
				<button type="button" class="tutor_video_poster_upload_btn button button-primary"><?php esc_html_e( 'Upload', 'tutor' ); ?></button>
			</div>

			<input type="hidden" name="tutor_action" value="tutor_profile_update_by_wp">
		</td>
	</tr>
	<?php do_action( 'tutor_backend_profile_fields_after' ); ?>
</table>

		<script>
			jQuery(window).on('load', function() { 
				jQuery(".td_branchs span.placeholder").html('Select multi branchs');
				jQuery(".td_users span.placeholder").html('Select multi users');
				jQuery(".td_groups span.placeholder").html('Select multi groups');
			});    
		</script>

<div id="added-instructor-id-<?php echo $instructor->ID; ?>" class="added-instructor-item added-instructor-item-<?php echo $instructor->ID; ?>" data-instructor-id="<?php echo $instructor->ID; ?>">
    <?php echo tutor_utils()->get_tutor_avatar($instructor->ID, 'md'); ?>
    <span class="instructor-name tutor-ml-12"> 
        <div class="instructor-intro">
            <div class="tutor-text-btn-xlarge tutor-color-black"><?php echo $instructor->display_name; ?></div>
            <?php echo isset($authorTag) ? $authorTag : ''; ?>
        </div>
        <div class="instructor-email tutor-d-block tutor-fs-7 tutor-color-secondary">
            <?php echo $instructor->user_email; ?>
        </div>
    </span>
    <?php if(get_current_user_id()!=$instructor->ID): ?>
        <span class="instructor-control">
            <a href="javascript:void(0)" class="<?php echo isset($delete_class) ? $delete_class : ''; ?> tutor-action-icon tutor-iconic-btn">
                <i class="tutor-icon-times"></i>
            </a>
        </span>
    <?php endif; ?>
    <?php echo isset($inner_content) ? $inner_content : ''; ?>
</div>
jQuery(document).on('DOMContentLoaded', function() {
    jQuery('#toplevel_page_tutor .wp-menu-name').html('Course');
    jQuery('#toplevel_page_tutor .wp-menu-name').show();

    // hide all course submenu
    // jQuery('ul.wp-submenu li a"]').hide();

    // show only 
    // <li><a href="edit-tags.php?taxonomy=course-category&amp;post_type=courses">Categories</a></li>
    // <li class="wp-first-item current"><a href="admin.php?page=tutor" class="wp-first-item current" aria-current="page">Courses</a></li>
    jQuery('ul.wp-submenu li a[href*="edit-tags.php?taxonomy=course-category"]').show();
    jQuery('ul.wp-submenu li a[href="admin.php?page=tutor"]').show();

    // HIDE href="https://mythosedu.com/wp-admin/admin.php?page=aioseo-search-statistics"
    jQuery('ul.wp-submenu li a[href*="admin.php?page=aioseo-search-statistics"]').hide();

    // jQuery('ul.wp-submenu li a[href*="edit-tags.php?taxonomy=course-tag"]').hide();
    // jQuery('ul.wp-submenu li a[href*="admin.php?page=tutor-students"]').hide();
    // jQuery('ul.wp-submenu li a[href*="admin.php?page=tutor_announcements"]').hide();
    // jQuery('ul.wp-submenu li a[href*="admin.php?page=question_answer"]').hide();
    // jQuery('ul.wp-submenu li a[href*="admin.php?page=tutor_quiz_attempts"]').hide();
    // jQuery('ul.wp-submenu li a[href*="admin.php?page=tutor-addons"]').hide();
    // jQuery('ul.wp-submenu li a[href*="admin.php?page=tutor-tools"]').hide();
    // jQuery('ul.wp-submenu li a[href*="admin.php?page=tutor_settings"]').hide();
    // jQuery('ul.wp-submenu li a[href*="admin.php?page=tutor-pro-license"]').hide();
    // jQuery('ul.wp-submenu li a[href*="admin.php?page=tutor-whats-new"]').hide();

    

 });
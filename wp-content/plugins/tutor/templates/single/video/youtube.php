<?php
/**
 * Display Video HTML5
 *
 * @since v.1.0.0
 * @author themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

$disable_default_player_youtube = tutor_utils()->get_option('disable_default_player_youtube');
$video_info = tutor_utils()->get_video_info();
$youtube_video_id = tutor_utils()->get_youtube_video_id(tutor_utils()->avalue_dot('source_youtube', $video_info));

do_action('tutor_lesson/single/before/video/youtube');
?>

<?php if($youtube_video_id ): ?>
    <div class="course-players-parent">
        <div class="course-players">
            <div class="loading-spinner"></div>
            <?php if (!$disable_default_player_youtube): ?>
                <iframe  id="youplay" class="plyr__video-wrapper plyr__video-embed"  src="https://www.youtube.com/embed/<?php echo $youtube_video_id; ?>?&autoplay=1&mute=1&enablejsapi=1" frameborder="0" allow="autoplay"></iframe>
            <?php else: ?>
                <div class="plyr__video-embed tutorPlayer">
                    <iframe  src="https://www.youtube.com/embed/<?php echo $youtube_video_id; ?>?&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;autoplay=1&amp;mute=1&amp;muted=1&amp;enablejsapi=1" allow="autoplay"></iframe>
                </div>
				<script>
					setTimeout(
					  function() 
					  {
						var videoURL = $('.plyr__video-embed iframe').prop('src');
						videoURL += "&autoplay=1&muted=1&mute=1&enablejsapi=1";
						alert($('.plyr__video-embed iframe').prop('src'));
						$('.plyr__video-embed iframe').prop('src',videoURL);
						//alert($('.plyr__video-embed iframe').prop('src'));
					  }, 5000);
				</script>
            <?php endif; ?>
        </div>
		

    </div>
<?php endif; ?>

<?php do_action('tutor_lesson/single/after/video/youtube'); ?>
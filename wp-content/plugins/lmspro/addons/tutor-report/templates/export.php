<?php 
/**
 * Export Template
 */
use \TUTOR_REPORT\Analytics;

$analytics      = new Analytics;
$data           = $analytics->analytics_data();
$students       = $data['students'];
$earnings       = $data['earnings'];
$discounts      = $data['discounts'];
$refunds        = $data['refunds'];
$disabled       = true;

if( count($students) || count($earnings) || count($discounts) || count($refunds) ) {
    $disabled       = false;
}
?>
<div class="analytics-export-wrapper">
    <div class="content-image-wrapper">
        <div class="content">
            <div class="tutor-fs-4 tutor-fw-medium tutor-color-black">
                <?php _e( 'Detailed Report of Your Sales & Students', 'tutor-pro' ); ?>
            </div>
            <div class="tutor-fs-6 tutor-color-secondary tutor-mt-16">
                <?php _e( 'Export to keep a copy of your analytics data.', 'tutor-pro' ); ?>
            </div>
            <div class="tutor-mt-28">
                <button type="button" id="download_analytics" class="<?php esc_attr_e( 'tutor-btn tutor-btn-primary' ); ?>"<?php esc_attr_e( $disabled ? ' disabled': '' ); ?>>
                    <i class="tutor-icon-import-o tutor-mr-12"></i> <?php _e( 'Download CSV' ); ?>
                </button>
            </div>
        </div>
        <div class="image" style="background-image: url(<?php echo esc_url( TUTOR_REPORT()->url.'assets/images/export-bg.svg')?>)"></div>
    </div>
</div>

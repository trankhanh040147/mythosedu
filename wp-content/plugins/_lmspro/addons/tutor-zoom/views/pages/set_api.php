<?php
if ( ! defined( 'ABSPATH' ) )
    exit;
/**
 * Specific button style for frontend & admin side
 * 
 * @since 1.9.4
 */
$save_button = 'tutor-btn' ;
$api_button  = 'tutor-btn tutor-button-zoom-api-check' ;
$check_api   = tutor_zoom_check_api_connection();
?>
<?php if ( ! is_admin() ) : ?>
<div class="zoom-configure-wrapper tutor-d-xl-flex tutor-align-center tutor-mt-36">
    <div class="tutor-zoom-icon-content-wrapper tutor-d-flex tutor-sm-32 tutor-p-16">
        <i class="tutor-icon-brand-zoom tutor-mt-4" area-hidden="true"></i>
        <div class="zoom-content">
            <div class="tutor-fs-4 tutor-fw-medium tutor-color-black tutor-mb-12">
                <?php esc_html_e( 'Setup your Zoom Integration', 'tutor-pro' ); ?>
            </div>
            
            <div class="tutor-fs-7 tutor-color-secondary">
                <?php
                    $content = "Please set your API Credentials. Without valid credentials, Zoom integration will not work. Create credentials by following " . '<a class="tutor-btn tutor-btn-link tutor-btn-sm" target="_blank" href="https://marketplace.zoom.us/develop/create" rel="noreferrer noopener">this link</a>' . ".";
                    echo wp_kses_post( $content, 'tutor-pro' );
                ?>
            </div>
        </div>
    </div>
    <div class="zoom-image tutor-mt-xl-0 tutor-mt-16">
        <img class="tutor-m-auto" src="<?php echo esc_url( TUTOR_ZOOM()->url . '/assets/images/zoom-api-key-banner.svg', 'tutor-pro' ); ?>" alt="zoom-config">
    </div>
</div>
<?php endif; ?>

<div class="tutor-zoom-api-container">
    <form id="tutor-zoom-settings" action="">
        <input type="hidden" name="action" value="tutor_save_zoom_api">
        <div class="tutor-zoom-form-container <?php echo is_admin() ? 'tutor-p-20 tutor-p-xl-40' : 'tutor-pt-40'; ?>">
            <div class="tutor-row tutor-align-center tutor-gx-xl-5">
                <div class="tutor-col-lg-6 tutor-mb-32 tutor-mb-lg-0">
                    <div class="tutor-mb-32">
                        <div class="tutor-fs-5 tutor-fw-medium tutor-mb-0 tutor-color-black">
                            <?php esc_html_e( 'Setup your Zoom Integration', 'tutor-pro' ); ?>
                        </div>

                        <?php if ( is_admin() ) : ?>
                            <div class="tutor-mt-12">
                                <?php esc_html_e( 'Visit your Zoom account and fetch the API key to connect Zoom with your eLearning website. Go to ', 'tutor-pro' ); ?><a href="https://marketplace.zoom.us/develop/create" target="_blank"> <?php esc_html_e( 'Zoom Website.', 'tutor-pro' ); ?></a>
                            </div>
                        <?php endif;?>
                    </div>

                    <div class="tutor-mb-32">
                        <label for="tutor_zoom_api_key" class="tutor-form-label tutor-mb-12"><?php esc_html_e( 'API Key', 'tutor-pro' ); ?></label>
                        <input type="text" id="tutor_zoom_api_key" class="tutor-form-control" name="<?php echo esc_attr( $this->api_key ); ?>[api_key]" value="<?php echo esc_attr( $this->get_api('api_key') ); ?>" placeholder="<?php esc_attr_e( 'Enter Your Zoom Api Key', 'tutor-pro' ); ?>"/>
                    </div>

                    <div class="tutor-mb-32">
                        <label for="tutor_zoom_api_secret" class="tutor-form-label tutor-mb-12"><?php esc_html_e( 'Secret Key', 'tutor-pro' ); ?></label>
                        <input type="text" id="tutor_zoom_api_secret" class="tutor-form-control" name="<?php echo esc_attr( $this->api_key ); ?>[api_secret]" value="<?php echo esc_attr( $this->get_api('api_secret') ); ?>" placeholder="<?php esc_attr_e( 'Enter Your Zoom Secret Key', 'tutor-pro' ); ?>"/>
                    </div>

                    <button type="submit" id="save-changes" class="tutor-btn tutor-btn-primary">
                        <?php esc_html_e( 'Save & Check Connection', 'tutor-pro' ); ?>
                    </button>
                </div>

                <?php if ( is_admin() ) : ?>
                    <div class="tutor-col-lg-6">
                        <img class="tutor-img-responsive" src="<?php echo esc_url( TUTOR_ZOOM()->url . '/assets/images/zoom-api-key-banner.svg', 'tutor-pro' ); ?>" alt="zoom-config">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>
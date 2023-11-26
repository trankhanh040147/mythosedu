<?php
if ( !class_exists('MHCommon') ) {
    class MHCommon {
        const PREMIUM_ADV_NOTICE = 'premium_advertising';
        const LICENSE_CODE_EMPTY_NOTICE = 'license_empty';

        private $pluginAbbrev;
        private $pluginAlias;
        private $pluginTitle;
        private $pluginBaseFile;

        private function __construct($pluginAlias,
                                     $pluginTitle,
                                     $pluginBaseFile,
                                     $pluginAbbrev) {

            $this->pluginAlias = $pluginAlias;
            $this->pluginTitle = $pluginTitle;
            $this->pluginBaseFile = $pluginBaseFile;
            $this->pluginAbbrev = $pluginAbbrev;
        }

        public function getPluginAlias() {
            return $this->pluginAlias;
        }

        public function getPluginAbbrev() {
            return $this->pluginAbbrev;
        }

        public function getPluginBaseFile() {
            return $this->pluginBaseFile;
        }

        public function getPluginTitle() {
            if ( $this->isPremiumVersion() ) {
                return $this->pluginTitle . ' PRO';
            }

            return $this->pluginTitle;
        }

        public function isPremiumVersion() {
            return apply_filters("mh_{$this->pluginAbbrev}_is_premium", false);
        }

        /**
         * Initialize all hooks and filters calls for settings, upgrader and support
         * @version 2
         */
        public static function initializeV2($pluginAlias,
                                            $pluginAbbrev,
                                            $pluginBaseFile,
                                            $pluginTitle) {

            $common = new self($pluginAlias, $pluginTitle, $pluginBaseFile, $pluginAbbrev);

            include_once( dirname(__FILE__) . '/MHSettings.php' );
            $settings = new MHSettings($pluginAlias, $pluginAbbrev, $pluginTitle, $pluginBaseFile, $common);

            include_once( dirname(__FILE__) . '/MHNotice.php' );
            $noticeObject = new MHNotice($common);

            if ( $common->isPremiumVersion() ) {
                if ( file_exists(dirname(__FILE__) . '/MHSupport.php') ) {
                    include_once( dirname(__FILE__) . '/MHSupport.php' );
                    new MHSupport($pluginAlias, $pluginTitle, $pluginBaseFile, $pluginAbbrev);
    
                    include_once( dirname(__FILE__) . '/MHUpgrader.php' );
                    new MHUpgrader($pluginAlias, $pluginBaseFile, $pluginTitle, $pluginAbbrev, $noticeObject);
                }
            }
            else if ( $settings->has_premium_features() ) {
                $text = sprintf(
                    __("You're using the free version of %s. If you want more features and better support, please <a href='%s'>check the premium page</a>."),
                    $pluginTitle,
                    $settings->tab_premium_url()
                );

                $text = wp_kses($text, array(
                    'a' => array('href' => array())
                ));

                $noticeObject->addNotice(self::PREMIUM_ADV_NOTICE, 'success', $text, 90);
            }
        }
    }
}

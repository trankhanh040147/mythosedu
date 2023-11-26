<?php
if ( !class_exists('MHNotice') ) {
    class MHNotice {
        /**
         * @var MHCommon
         */
        private $common;

        public function __construct($common) {
            $this->common = $common;

            $pluginAlias = $common->getPluginAlias();

            add_action('admin_notices', array($this, 'checkNotices'));

            if ( !empty($_GET['MHCommonDismiss']) && !empty($_GET['alias']) && ( $_GET['MHCommonDismiss'] == $pluginAlias ) ) {
                $this->dismissNotice($_GET['alias']);
                wp_safe_redirect( esc_url_raw( admin_url('plugins.php') ) );
            }
        }

        public function checkNotices(){
            global $pagenow;

            if ( $pagenow != 'plugins.php' ) {
                return;
            }

            $notices = $this->readNotices();
            $pluginAlias = $this->common->getPluginAlias();
            $isPremium = $this->common->isPremiumVersion();

            foreach ( $notices as $alias => $notice ) {
                // ignore dismissed notices
                if ( get_transient($this->transactionAlias($alias)) ) {
                    continue;
                }
                
                // custom hook to prevent display notices
                if ( !apply_filters($this->common->getPluginAbbrev() . '_' . $alias, true) ) {
                    continue;
                }

                // ignore undesired notices
                if ( $isPremium && ( $alias == MHCommon::PREMIUM_ADV_NOTICE ) ) {
                    continue;
                }

                if ( !$isPremium && ( $alias == MHCommon::LICENSE_CODE_EMPTY_NOTICE ) ) {
                    continue;
                }

                $dismissUrl = admin_url('plugins.php?MHCommonDismiss=' . $pluginAlias . '&alias=' . $alias);
                $dismissLink = sprintf('<a href="%s">Dismiss for %d days</a>', $dismissUrl, $notice['dismissDays']);
                
                $pluginTitle = esc_html__($this->common->getPluginTitle());
                $type = esc_html__($notice['type']);
                $message = $notice['message'];

                echo '<div class="notice notice-'.$type.'">
                        <strong>'.$pluginTitle.'</strong>
                        <p>
                            '.$message.'
                        </p>
                        <p style="text-align: right; margin-top: -10px;">
                            '.$dismissLink.'
                        </p>
                    </div>';
            }
        }

        public function addNotice($alias, $type, $message, $dismissDays) {

            $notices = $this->readNotices();
            $notices[$alias] = array(
                'message' => $message,
                'type' => $type,
                'dismissDays' => $dismissDays,
            );

            $this->storeNotices($notices);
        }

        public function removeNotice($alias) {
            $notices = $this->readNotices();
            
            if ( !empty($notices[$alias]) ) {
                unset($notices[$alias]);
                $this->storeNotices($notices);
            }

            delete_transient($this->transactionAlias($alias));
        }

        private function dismissNotice($alias) {
            $notices = $this->readNotices();

            if ( !empty($notices[$alias])) {
                $dismissDays = $notices[$alias]['dismissDays'];
                $expiration = ( $dismissDays * DAY_IN_SECONDS );

                set_transient($this->transactionAlias($alias), 'x', $expiration);
            }
        }

        private function transactionAlias($alias) {
            $pluginAbbrev = $this->common->getPluginAbbrev();
            return $pluginAbbrev . '_notice_' . $alias;
        }

        private function storeNotices($notices) {
            $pluginAbbrev = $this->common->getPluginAbbrev();
            return update_option($pluginAbbrev . '_notices', $notices);
        }

        private function readNotices() {
            $pluginAbbrev = $this->common->getPluginAbbrev();
            return get_option($pluginAbbrev . '_notices', array());
        }
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 4/1/20
 * Time: 6:32 PM
 */


/**
 * Construct and output tab navigation.
 *
 * @since 1.0.0
 *
 * @param string $page Whether it's the CPT or Taxonomy page. Optional. Default "post_types".
 * @return string
 */
function cpt_settings_tab_menu( $page = 'post_types' ) {

    /**
     * Filters the tabs to render on a given page.
     *
     * @since 1.3.0
     *
     * @param array  $value Array of tabs to render.
     * @param string $page  Current page being displayed.
     */
    $tabs = (array) apply_filters( 'cpt_get_tabs', [], $page );

    if ( empty( $tabs['page_title'] ) ) {
        return '';
    }

    $tmpl = '<h1>%s</h1><nav class="nav-tab-wrapper wp-clearfix" aria-label="Secondary menu">%s</nav>';

    $tab_output = '';
    foreach ( $tabs['tabs'] as $tab ) {
        $tab_output .= sprintf(
            '<a class="%s" href="%s" aria-selected="%s">%s</a>',
            implode( ' ', $tab['classes'] ),
            $tab['url'],
            $tab['aria-selected'],
            $tab['text']
        );
    }

    printf(
        $tmpl,
        $tabs['page_title'],
        $tab_output
    );
}


/**
 * Return a notice based on conditions.
 *
 * @since 1.0.0
 *
 * @param string $action       The type of action that occurred. Optional. Default empty string.
 * @param string $object_type  Whether it's from a post type or taxonomy. Optional. Default empty string.
 * @param bool   $success      Whether the action succeeded or not. Optional. Default true.
 * @param string $custom       Custom message if necessary. Optional. Default empty string.
 * @return bool|string false on no message, else HTML div with our notice message.
 */
function cpt_admin_notices( $action = '', $object_type = '', $success = true, $custom = '' ) {

    $class       = [];
    $class[]     = $success ? 'updated' : 'error';
    $class[]     = 'notice is-dismissible';
    $object_type = esc_attr( $object_type );

    $messagewrapstart = '<div id="message" class="' . implode( ' ', $class ) . '"><p>';
    $message = '';

    $messagewrapend = '</p></div>';

    if ( 'add' === $action ) {
        if ( $success ) {
            $message .= sprintf( __( '%s has been successfully added', CPT_LANG ), $object_type );
        } else {
            $message .= sprintf( __( '%s has failed to be added', CPT_LANG ), $object_type );
        }
    } elseif ( 'update' === $action ) {
        if ( $success ) {
            $message .= sprintf( __( '%s has been successfully updated', CPT_LANG ), $object_type );
        } else {
            $message .= sprintf( __( '%s has failed to be updated', CPT_LANG ), $object_type );
        }
    } elseif ( 'delete' === $action ) {
        if ( $success ) {
            $message .= sprintf( __( '%s has been successfully deleted', CPT_LANG ), $object_type );
        } else {
            $message .= sprintf( __( '%s has failed to be deleted', CPT_LANG ), $object_type );
        }
    } elseif ( 'import' === $action ) {
        if ( $success ) {
            $message .= sprintf( __( '%s has been successfully imported', CPT_LANG ), $object_type );
        } else {
            $message .= sprintf( __( '%s has failed to be imported', CPT_LANG ), $object_type );
        }
    } elseif ( 'error' === $action ) {
        if ( ! empty( $custom ) ) {
            $message = $custom;
        }
    }

    if ( $message ) {

        /**
         * Filters the custom admin notice for CPT.
         *
         * @since 1.0.0
         *
         * @param string $value            Complete HTML output for notice.
         * @param string $action           Action whose message is being generated.
         * @param string $message          The message to be displayed.
         * @param string $messagewrapstart Beginning wrap HTML.
         * @param string $messagewrapend   Ending wrap HTML.
         */
        return apply_filters( 'cpt_admin_notice', $messagewrapstart . $message . $messagewrapend, $action, $message, $messagewrapstart, $messagewrapend );
    }

    return false;
}

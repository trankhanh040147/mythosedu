<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 8/21/19
 * Time: 2:33 PM
 */
namespace CoreSystem\Helpers;

class ModalLayout {
    static function render($id, $title, $body_data, $buttonTitle) {
        $modal = '<div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
        $modal .= '<div class="modal-dialog" role="document">';
        $modal .= '<div class="modal-content">';
        $modal .= '<form class="fr-form-validate" method="post" action="">';
        $modal .= self::renderHeader($title);
        $modal .= self::renderBody($body_data);
        $modal .= self::renderFooter($buttonTitle);
        $modal .= '</form>';
        $modal .= '</div>';
        $modal .= '</div>';
        $modal .= '</div>';

        return $modal;
    }

    static function renderHeader($title) {
        $header = '<div class="modal-header">';
        $header .= '<h5 class="modal-title" id="exampleModalLabel">' . $title . '</h5>';
        $header .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $header .= '<span aria-hidden="true">&times;</span>';
        $header .= '</button>';
        $header .= '</div>';

        return $header;
    }

    static function renderBody($body_data) {
        $body = '<div class="modal-body">';

        if ( !empty( $body_data["title"] ) ) {
            $body .= $body_data["title"];
        }

        if ( !empty( $body_data["items"] ) ) {
            foreach ($body_data["items"] as $item) {
                $body .= FormLayout::renderInputGroup($item);
            }
        }

        $body .= '</div>';
        return $body;
    }

    static function renderFooter($buttonTitle) {
        $footer = '<div class="modal-footer">';
        $footer .= '<input type="submit" class="btn btn-primary" id="modal-submit" value="' . $buttonTitle . '">';
        $footer .= '</div>';

        return $footer;
    }
}

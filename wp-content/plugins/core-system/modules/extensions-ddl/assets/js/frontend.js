(function( $ ) {
    "use strict";

    var getElementSettings = function( $element ) {
        var elementSettings = {},
            modelCID 		= $element.data( 'model-cid' );

        if ( isEditMode && modelCID ) {
            var settings 		= elementorFrontend.config.elements.data[ modelCID ],
                settingsKeys 	= elementorFrontend.config.elements.keys[ settings.attributes.widgetType || settings.attributes.elType ];

            jQuery.each( settings.getActiveControls(), function( controlKey ) {
                if ( -1 !== settingsKeys.indexOf( controlKey ) ) {
                    elementSettings[ controlKey ] = settings.attributes[ controlKey ];
                }
            } );
        } else {
            elementSettings = $element.data('settings') || {};
        }

        return elementSettings;
    };

    var isEditMode		= false;

    var TimelineHandler = function ( $scope, $ ) {
        var $carousel            = $scope.find( '.ets-co-timeline-horizontal .ets-co-timeline-items' ).eq( 0 ),
            $slider_wrap         = $scope.find( '.ets-co-timeline-wrapper' ),
            $slider_nav          = $scope.find( '.ets-co-timeline-navigation' ),
            elementSettings      = getElementSettings( $scope ),
            $arrow_next          = elementSettings.arrow,
            $arrow_prev          = ( $arrow_next !== undefined ) ? $arrow_next.replace( "right", "left" ) : '',
            $items               = ( elementSettings.columns !== undefined && elementSettings.columns !== '' ) ? parseInt( elementSettings.columns ) : 3,
            $items_tablet        = ( elementSettings.columns_tablet !== undefined && elementSettings.columns_tablet !== '' ) ? parseInt( elementSettings.columns_tablet ) : 2,
            $items_mobile        = ( elementSettings.columns_mobile !== undefined && elementSettings.columns_mobile !== '' ) ? parseInt( elementSettings.columns_mobile ) : 1;

        if ( elementSettings.layout == 'horizontal' ) {
            $carousel.slick({
                slidesToShow:           $items,
                slidesToScroll:  		1,
                autoplay:               'yes' === elementSettings.autoplay,
                autoplaySpeed:          elementSettings.autoplay_speed,
                arrows:                 false,
                centerMode:             true,
                speed:                  elementSettings.animation_speed,
                infinite:               true,
                rtl:                    'right' === elementSettings.direction,
                asNavFor:               $slider_nav,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: $items_tablet,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: $items_mobile,
                        }
                    },
                ]
            });

            $slider_nav.slick({
                slidesToShow:           $items,
                slidesToScroll:  		1,
                autoplay:               'yes' === elementSettings.autoplay,
                autoplaySpeed:          elementSettings.autoplay_speed,
                asNavFor:               $carousel,
                arrows:                 'yes' === elementSettings.arrows,
                prevArrow:              '<div class="ets-co-slider-arrow ets-co-arrow ets-co-arrow-prev"><i class="' + $arrow_prev + '"></i></div>',
                nextArrow:              '<div class="ets-co-slider-arrow ets-co-arrow ets-co-arrow-next"><i class="' + $arrow_next + '"></i></div>',
                centerMode:             true,
                infinite:               true,
                focusOnSelect:          true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: $items_tablet,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: $items_mobile,
                        }
                    },
                ]
            });

            $carousel.slick( 'setPosition' );

            if ( isEditMode ) {
                $slider_wrap.resize( function() {
                    $carousel.slick( 'setPosition' );
                });
            }
        }

        var settings = {};

        if ( isEditMode ) {
            settings.window = elementor.$previewContents;
        }

        var timeline = new COTimeline( settings, $scope );
    };

    var TableHandler = function ($scope, $) {
        $( document ).trigger( "enhance.tablesaw" );
    };

    $(window).on('elementor/frontend/init', function () {
        if ( elementorFrontend.isEditMode() ) {
            isEditMode = true;
        }
        elementorFrontend.hooks.addAction('frontend/element_ready/co-timeline.default', TimelineHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/co-table.default', TableHandler);
    });

})(jQuery);
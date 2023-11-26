(function($) {

    COTimeline = function( settings, $scope ) {
        this.node               = $scope;
        this.timeline           = this.node.find('.ets-co-timeline');
        this.items              = this.node.find('.ets-co-timeline-vertical .ets-co-timeline-item');
        this.connector_wrap     = this.node.find('.ets-co-timeline-vertical .ets-co-timeline-connector-wrap');
        this.connector          = this.node.find('.ets-co-timeline-vertical .ets-co-timeline-connector');
        this.progressBar        = this.node.find('.ets-co-timeline-vertical .ets-co-timeline-connector-inner');
        this.iconClass        = this.node.find('.ets-co-timeline-vertical .ets-co-timeline-icon-wrapper');

        if ( 'undefined' !== typeof settings.window ) {
            this.window	= settings.window;
        }

        this.init();
    };

    COTimeline.prototype = {
        node: '',
        items: '',
        connector: '',
        progressBar: '',
        window: $(window),
        winHeight: 0,
        scrollTop: 0,
        lastWinHeight: -1,
        lastScrollTop: -1,
        isScrolling: false,
        isResizing: false,
        isAnimating: false,
        animationClass: 'bounce-in',

        init: function()
        {
            var timeline_layout = this.timeline.data('timeline-layout');

            if ( timeline_layout == 'vertical' ) {
                this.winHeight	= $(window).height();
                this.scrollTop	= this.window.scrollTop();

                this.bindEvents();
                this.requestAnimation();
                this.revealItems();
            }
        },

        bindEvents: function()
        {
            this.window.on( 'scroll', $.proxy( function() {
                this.scrollTop = this.window.scrollTop();

                this.requestAnimation();
                this.revealItems();
            }, this ) );

            $(window).on( 'resize', $.proxy( function() {
                this.scrollTop 	= this.window.scrollTop();
                this.winHeight	= $(window).height();

                this.requestAnimation();
            }, this ) );
        },

        requestAnimation: function()
        {
            if ( ! this.isAnimating ) {
                var frameId = requestAnimationFrame( this.reboot.bind(this) );
            }

            this.isAnimating = true;
        },

        revealItems: function()
        {
            var self = this;

            this.items.each( function() {
                if ( ( $(this).offset().top <= ( self.window.scrollTop() + $(window).outerHeight() * 0.95 ) ) && $(this).hasClass('ets-co-timeline-item-hidden') ) {
                    $(this).removeClass('ets-co-timeline-item-hidden').addClass( self.animationClass );
                }
            } );
        },

        setup: function()
        {
            var self = this;
            this.connector_wrap.css('left', self.iconClass.eq(0)[0].offsetLeft + self.iconClass.eq(0).width() / 2 - self.connector_wrap.width() / 2 );
            this.connector.css({
                'top': self.items.first().find( self.iconClass ).offset().top - self.items.first().offset().top,
                'bottom': ( self.node.offset().top + self.node.outerHeight() ) - self.items.last().find( self.iconClass ).offset().top
            });
        },

        reboot: function()
        {
            this.isAnimating = false;

            if ( this.winHeight !== this.lastWinHeight ) {
                this.setup();
            }

            this.start.bind( this )();
        },

        start: function()
        {
            if ( this.scrollTop !== this.lastScrollTop || this.winHeight !== this.lastWinHeight ) {
                this.lastScrollTop = this.scrollTop;
                this.lastWinHeight = this.winHeight;

                this.progress();
            }
        },

        progress: function()
        {
            var self = this,
                win	= $(window);

            this.items.each( function() {
                if ( $(this).find( self.iconClass ).offset().top < ( self.window.scrollTop() + win.outerHeight() / 2 ) ) {
                    $(this).addClass('ets-co-timeline-item-active');
                } else {
                    $(this).removeClass('ets-co-timeline-item-active');
                }
            } );

            var lastMarkerPos = this.node.find('.ets-co-timeline-connector').height() + this.items.first().find( this.iconClass ).offset().top,
                progressPos	= ( this.window.scrollTop() - this.progressBar.offset().top ) + ( win.outerHeight() / 2 );

            if ( lastMarkerPos <= ( this.window.scrollTop() + win.outerHeight() / 2 ) ) {
                progressPos = lastMarkerPos - this.progressBar.offset().top;
            }
            this.progressBar.css( 'height', progressPos + 'px' );
        }
    };

})(jQuery);
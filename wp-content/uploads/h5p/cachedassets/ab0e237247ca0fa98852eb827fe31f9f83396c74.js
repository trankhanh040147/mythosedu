var H5P = H5P || {};

/**
 * Constructor.
 *
 * @param {Object} params Options for this library.
 * @param {Number} id Content identifier
 * @returns {undefined}
 */
(function ($) {
  H5P.Image = function (params, id, extras) {
    H5P.EventDispatcher.call(this);
    this.extras = extras;

    if (params.file === undefined || !(params.file instanceof Object)) {
      this.placeholder = true;
    }
    else {
      this.source = H5P.getPath(params.file.path, id);
      this.width = params.file.width;
      this.height = params.file.height;
    }

    this.alt = (!params.decorative && params.alt !== undefined) ?
      this.stripHTML(this.htmlDecode(params.alt)) :
      '';

    if (params.title !== undefined) {
      this.title = this.stripHTML(this.htmlDecode(params.title));
    }
  };

  H5P.Image.prototype = Object.create(H5P.EventDispatcher.prototype);
  H5P.Image.prototype.constructor = H5P.Image;

  /**
   * Wipe out the content of the wrapper and put our HTML in it.
   *
   * @param {jQuery} $wrapper
   * @returns {undefined}
   */
  H5P.Image.prototype.attach = function ($wrapper) {
    var self = this;
    var source = this.source;

    if (self.$img === undefined) {
      if(self.placeholder) {
        self.$img = $('<div>', {
          width: '100%',
          height: '100%',
          class: 'h5p-placeholder',
          title: this.title === undefined ? '' : this.title,
          on: {
            load: function () {
              self.trigger('loaded');
            }
          }
        });
      } else {
        self.$img = $('<img>', {
          width: '100%',
          height: '100%',
          src: source,
          alt: this.alt,
          title: this.title === undefined ? '' : this.title,
          on: {
            load: function () {
              self.trigger('loaded');
            }
          }
        });
      }
    }

    $wrapper.addClass('h5p-image').html(self.$img);
  };

  /**
   * Retrieve decoded HTML encoded string.
   *
   * @param {string} input HTML encoded string.
   * @returns {string} Decoded string.
   */
  H5P.Image.prototype.htmlDecode = function (input) {
    const dparser = new DOMParser().parseFromString(input, 'text/html');
    return dparser.documentElement.textContent;
  };

  /**
   * Retrieve string without HTML tags.
   *
   * @param {string} input Input string.
   * @returns {string} Output string.
   */
  H5P.Image.prototype.stripHTML = function (html) {
    const div = document.createElement('div');
    div.innerHTML = html;
    return div.textContent || div.innerText || '';
  };

  return H5P.Image;
}(H5P.jQuery));
;
var H5P = H5P || {};
/**
 * Transition contains helper function relevant for transitioning
 */
H5P.Transition = (function ($) {

  /**
   * @class
   * @namespace H5P
   */
  Transition = {};

  /**
   * @private
   */
  Transition.transitionEndEventNames = {
    'WebkitTransition': 'webkitTransitionEnd',
    'transition':       'transitionend',
    'MozTransition':    'transitionend',
    'OTransition':      'oTransitionEnd',
    'msTransition':     'MSTransitionEnd'
  };

  /**
   * @private
   */
  Transition.cache = [];

  /**
   * Get the vendor property name for an event
   *
   * @function H5P.Transition.getVendorPropertyName
   * @static
   * @private
   * @param  {string} prop Generic property name
   * @return {string}      Vendor specific property name
   */
  Transition.getVendorPropertyName = function (prop) {

    if (Transition.cache[prop] !== undefined) {
      return Transition.cache[prop];
    }

    var div = document.createElement('div');

    // Handle unprefixed versions (FF16+, for example)
    if (prop in div.style) {
      Transition.cache[prop] = prop;
    }
    else {
      var prefixes = ['Moz', 'Webkit', 'O', 'ms'];
      var prop_ = prop.charAt(0).toUpperCase() + prop.substr(1);

      if (prop in div.style) {
        Transition.cache[prop] = prop;
      }
      else {
        for (var i = 0; i < prefixes.length; ++i) {
          var vendorProp = prefixes[i] + prop_;
          if (vendorProp in div.style) {
            Transition.cache[prop] = vendorProp;
            break;
          }
        }
      }
    }

    return Transition.cache[prop];
  };

  /**
   * Get the name of the transition end event
   *
   * @static
   * @private
   * @return {string}  description
   */
  Transition.getTransitionEndEventName = function () {
    return Transition.transitionEndEventNames[Transition.getVendorPropertyName('transition')] || undefined;
  };

  /**
   * Helper function for listening on transition end events
   *
   * @function H5P.Transition.onTransitionEnd
   * @static
   * @param  {domElement} $element The element which is transitioned
   * @param  {function} callback The callback to be invoked when transition is finished
   * @param  {number} timeout  Timeout in milliseconds. Fallback if transition event is never fired
   */
  Transition.onTransitionEnd = function ($element, callback, timeout) {
    // Fallback on 1 second if transition event is not supported/triggered
    timeout = timeout || 1000;
    Transition.transitionEndEventName = Transition.transitionEndEventName || Transition.getTransitionEndEventName();
    var callbackCalled = false;

    var doCallback = function () {
      if (callbackCalled) {
        return;
      }
      $element.off(Transition.transitionEndEventName, callback);
      callbackCalled = true;
      clearTimeout(timer);
      callback();
    };

    var timer = setTimeout(function () {
      doCallback();
    }, timeout);

    $element.on(Transition.transitionEndEventName, function () {
      doCallback();
    });
  };

  /**
   * Wait for a transition - when finished, invokes next in line
   *
   * @private
   *
   * @param {Object[]}    transitions             Array of transitions
   * @param {H5P.jQuery}  transitions[].$element  Dom element transition is performed on
   * @param {number=}     transitions[].timeout   Timeout fallback if transition end never is triggered
   * @param {bool=}       transitions[].break     If true, sequence breaks after this transition
   * @param {number}      index                   The index for current transition
   */
  var runSequence = function (transitions, index) {
    if (index >= transitions.length) {
      return;
    }

    var transition = transitions[index];
    H5P.Transition.onTransitionEnd(transition.$element, function () {
      if (transition.end) {
        transition.end();
      }
      if (transition.break !== true) {
        runSequence(transitions, index+1);
      }
    }, transition.timeout || undefined);
  };

  /**
   * Run a sequence of transitions
   *
   * @function H5P.Transition.sequence
   * @static
   * @param {Object[]}    transitions             Array of transitions
   * @param {H5P.jQuery}  transitions[].$element  Dom element transition is performed on
   * @param {number=}     transitions[].timeout   Timeout fallback if transition end never is triggered
   * @param {bool=}       transitions[].break     If true, sequence breaks after this transition
   */
  Transition.sequence = function (transitions) {
    runSequence(transitions, 0);
  };

  return Transition;
})(H5P.jQuery);
;
var H5P = H5P || {};

/**
 * Class responsible for creating a help text dialog
 */
H5P.JoubelHelpTextDialog = (function ($) {

  var numInstances = 0;
  /**
   * Display a pop-up containing a message.
   *
   * @param {H5P.jQuery}  $container  The container which message dialog will be appended to
   * @param {string}      message     The message
   * @param {string}      closeButtonTitle The title for the close button
   * @return {H5P.jQuery}
   */
  function JoubelHelpTextDialog(header, message, closeButtonTitle) {
    H5P.EventDispatcher.call(this);

    var self = this;

    numInstances++;
    var headerId = 'joubel-help-text-header-' + numInstances;
    var helpTextId = 'joubel-help-text-body-' + numInstances;

    var $helpTextDialogBox = $('<div>', {
      'class': 'joubel-help-text-dialog-box',
      'role': 'dialog',
      'aria-labelledby': headerId,
      'aria-describedby': helpTextId
    });

    $('<div>', {
      'class': 'joubel-help-text-dialog-background'
    }).appendTo($helpTextDialogBox);

    var $helpTextDialogContainer = $('<div>', {
      'class': 'joubel-help-text-dialog-container'
    }).appendTo($helpTextDialogBox);

    $('<div>', {
      'class': 'joubel-help-text-header',
      'id': headerId,
      'role': 'header',
      'html': header
    }).appendTo($helpTextDialogContainer);

    $('<div>', {
      'class': 'joubel-help-text-body',
      'id': helpTextId,
      'html': message,
      'role': 'document',
      'tabindex': 0
    }).appendTo($helpTextDialogContainer);

    var handleClose = function () {
      $helpTextDialogBox.remove();
      self.trigger('closed');
    };

    var $closeButton = $('<div>', {
      'class': 'joubel-help-text-remove',
      'role': 'button',
      'title': closeButtonTitle,
      'tabindex': 1,
      'click': handleClose,
      'keydown': function (event) {
        // 32 - space, 13 - enter
        if ([32, 13].indexOf(event.which) !== -1) {
          event.preventDefault();
          handleClose();
        }
      }
    }).appendTo($helpTextDialogContainer);

    /**
     * Get the DOM element
     * @return {HTMLElement}
     */
    self.getElement = function () {
      return $helpTextDialogBox;
    };

    self.focus = function () {
      $closeButton.focus();
    };
  }

  JoubelHelpTextDialog.prototype = Object.create(H5P.EventDispatcher.prototype);
  JoubelHelpTextDialog.prototype.constructor = JoubelHelpTextDialog;

  return JoubelHelpTextDialog;
}(H5P.jQuery));
;
var H5P = H5P || {};

/**
 * Class responsible for creating auto-disappearing dialogs
 */
H5P.JoubelMessageDialog = (function ($) {

  /**
   * Display a pop-up containing a message.
   *
   * @param {H5P.jQuery} $container The container which message dialog will be appended to
   * @param {string} message The message
   * @return {H5P.jQuery}
   */
  function JoubelMessageDialog ($container, message) {
    var timeout;

    var removeDialog = function () {
      $warning.remove();
      clearTimeout(timeout);
      $container.off('click.messageDialog');
    };

    // Create warning popup:
    var $warning = $('<div/>', {
      'class': 'joubel-message-dialog',
      text: message
    }).appendTo($container);

    // Remove after 3 seconds or if user clicks anywhere in $container:
    timeout = setTimeout(removeDialog, 3000);
    $container.on('click.messageDialog', removeDialog);

    return $warning;
  }

  return JoubelMessageDialog;
})(H5P.jQuery);
;
var H5P = H5P || {};

/**
 * Class responsible for creating a circular progress bar
 */

H5P.JoubelProgressCircle = (function ($) {

  /**
   * Constructor for the Progress Circle
   *
   * @param {Number} number The amount of progress to display
   * @param {string} progressColor Color for the progress meter
   * @param {string} backgroundColor Color behind the progress meter
   */
  function ProgressCircle(number, progressColor, fillColor, backgroundColor) {
    progressColor = progressColor || '#1a73d9';
    fillColor = fillColor || '#f0f0f0';
    backgroundColor = backgroundColor || '#ffffff';
    var progressColorRGB = this.hexToRgb(progressColor);

    //Verify number
    try {
      number = Number(number);
      if (number === '') {
        throw 'is empty';
      }
      if (isNaN(number)) {
        throw 'is not a number';
      }
    } catch (e) {
      number = 'err';
    }

    //Draw circle
    if (number > 100) {
      number = 100;
    }

    // We can not use rgba, since they will stack on top of each other.
    // Instead we create the equivalent of the rgba color
    // and applies this to the activeborder and background color.
    var progressColorString = 'rgb(' + parseInt(progressColorRGB.r, 10) +
      ',' + parseInt(progressColorRGB.g, 10) +
      ',' + parseInt(progressColorRGB.b, 10) + ')';

    // Circle wrapper
    var $wrapper = $('<div/>', {
      'class': "joubel-progress-circle-wrapper"
    });

    //Active border indicates progress
    var $activeBorder = $('<div/>', {
      'class': "joubel-progress-circle-active-border"
    }).appendTo($wrapper);

    //Background circle
    var $backgroundCircle = $('<div/>', {
      'class': "joubel-progress-circle-circle"
    }).appendTo($activeBorder);

    //Progress text/number
    $('<span/>', {
      'text': number + '%',
      'class': "joubel-progress-circle-percentage"
    }).appendTo($backgroundCircle);

    var deg = number * 3.6;
    if (deg <= 180) {
      $activeBorder.css('background-image',
        'linear-gradient(' + (90 + deg) + 'deg, transparent 50%, ' + fillColor + ' 50%),' +
        'linear-gradient(90deg, ' + fillColor + ' 50%, transparent 50%)')
        .css('border', '2px solid' + backgroundColor)
        .css('background-color', progressColorString);
    } else {
      $activeBorder.css('background-image',
        'linear-gradient(' + (deg - 90) + 'deg, transparent 50%, ' + progressColorString + ' 50%),' +
        'linear-gradient(90deg, ' + fillColor + ' 50%, transparent 50%)')
        .css('border', '2px solid' + backgroundColor)
        .css('background-color', progressColorString);
    }

    this.$activeBorder = $activeBorder;
    this.$backgroundCircle = $backgroundCircle;
    this.$wrapper = $wrapper;

    this.initResizeFunctionality();

    return $wrapper;
  }

  /**
   * Initializes resize functionality for the progress circle
   */
  ProgressCircle.prototype.initResizeFunctionality = function () {
    var self = this;

    $(window).resize(function () {
      // Queue resize
      setTimeout(function () {
        self.resize();
      });
    });

    // First resize
    setTimeout(function () {
      self.resize();
    }, 0);
  };

  /**
   * Resize function makes progress circle grow or shrink relative to parent container
   */
  ProgressCircle.prototype.resize = function () {
    var $parent = this.$wrapper.parent();

    if ($parent !== undefined && $parent) {

      // Measurements
      var fontSize = parseInt($parent.css('font-size'), 10);

      // Static sizes
      var fontSizeMultiplum = 3.75;
      var progressCircleWidthPx = parseInt((fontSize / 4.5), 10) % 2 === 0 ? parseInt((fontSize / 4.5), 10) + 4 : parseInt((fontSize / 4.5), 10) + 5;
      var progressCircleOffset = progressCircleWidthPx / 2;

      var width = fontSize * fontSizeMultiplum;
      var height = fontSize * fontSizeMultiplum;
      this.$activeBorder.css({
        'width': width,
        'height': height
      });

      this.$backgroundCircle.css({
        'width': width - progressCircleWidthPx,
        'height': height - progressCircleWidthPx,
        'top': progressCircleOffset,
        'left': progressCircleOffset
      });
    }
  };

  /**
   * Hex to RGB conversion
   * @param hex
   * @returns {{r: Number, g: Number, b: Number}}
   */
  ProgressCircle.prototype.hexToRgb = function (hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
      r: parseInt(result[1], 16),
      g: parseInt(result[2], 16),
      b: parseInt(result[3], 16)
    } : null;
  };

  return ProgressCircle;

}(H5P.jQuery));
;
var H5P = H5P || {};

H5P.SimpleRoundedButton = (function ($) {

  /**
   * Creates a new tip
   */
  function SimpleRoundedButton(text) {

    var $simpleRoundedButton = $('<div>', {
      'class': 'joubel-simple-rounded-button',
      'title': text,
      'role': 'button',
      'tabindex': '0'
    }).keydown(function (e) {
      // 32 - space, 13 - enter
      if ([32, 13].indexOf(e.which) !== -1) {
        $(this).click();
        e.preventDefault();
      }
    });

    $('<span>', {
      'class': 'joubel-simple-rounded-button-text',
      'html': text
    }).appendTo($simpleRoundedButton);

    return $simpleRoundedButton;
  }

  return SimpleRoundedButton;
}(H5P.jQuery));
;
var H5P = H5P || {};

/**
 * Class responsible for creating speech bubbles
 */
H5P.JoubelSpeechBubble = (function ($) {

  var $currentSpeechBubble;
  var $currentContainer;  
  var $tail;
  var $innerTail;
  var removeSpeechBubbleTimeout;
  var currentMaxWidth;

  var DEFAULT_MAX_WIDTH = 400;

  var iDevice = navigator.userAgent.match(/iPod|iPhone|iPad/g) ? true : false;

  /**
   * Creates a new speech bubble
   *
   * @param {H5P.jQuery} $container The speaking object
   * @param {string} text The text to display
   * @param {number} maxWidth The maximum width of the bubble
   * @return {H5P.JoubelSpeechBubble}
   */
  function JoubelSpeechBubble($container, text, maxWidth) {
    maxWidth = maxWidth || DEFAULT_MAX_WIDTH;
    currentMaxWidth = maxWidth;
    $currentContainer = $container;

    this.isCurrent = function ($tip) {
      return $tip.is($currentContainer);
    };

    this.remove = function () {
      remove();
    };

    var fadeOutSpeechBubble = function ($speechBubble) {
      if (!$speechBubble) {
        return;
      }

      // Stop removing bubble
      clearTimeout(removeSpeechBubbleTimeout);

      $speechBubble.removeClass('show');
      setTimeout(function () {
        if ($speechBubble) {
          $speechBubble.remove();
          $speechBubble = undefined;
        }
      }, 500);
    };

    if ($currentSpeechBubble !== undefined) {
      remove();
    }

    var $h5pContainer = getH5PContainer($container);

    // Make sure we fade out old speech bubble
    fadeOutSpeechBubble($currentSpeechBubble);

    // Create bubble
    $tail = $('<div class="joubel-speech-bubble-tail"></div>');
    $innerTail = $('<div class="joubel-speech-bubble-inner-tail"></div>');
    var $innerBubble = $(
      '<div class="joubel-speech-bubble-inner">' +
      '<div class="joubel-speech-bubble-text">' + text + '</div>' +
      '</div>'
    ).prepend($innerTail);

    $currentSpeechBubble = $(
      '<div class="joubel-speech-bubble" aria-live="assertive">'
    ).append([$tail, $innerBubble])
      .appendTo($h5pContainer);

    // Show speech bubble with transition
    setTimeout(function () {
      $currentSpeechBubble.addClass('show');
    }, 0);

    position($currentSpeechBubble, $currentContainer, maxWidth, $tail, $innerTail);

    // Handle click to close
    H5P.$body.on('mousedown.speechBubble', handleOutsideClick);

    // Handle window resizing
    H5P.$window.on('resize', '', handleResize);

    // Handle clicks when inside IV which blocks bubbling.
    $container.parents('.h5p-dialog')
      .on('mousedown.speechBubble', handleOutsideClick);

    if (iDevice) {
      H5P.$body.css('cursor', 'pointer');
    }

    return this;
  }

  // Remove speechbubble if it belongs to a dom element that is about to be hidden
  H5P.externalDispatcher.on('domHidden', function (event) {
    if ($currentSpeechBubble !== undefined && event.data.$dom.find($currentContainer).length !== 0) {
      remove();
    }
  });

  /**
   * Returns the closest h5p container for the given DOM element.
   * 
   * @param {object} $container jquery element
   * @return {object} the h5p container (jquery element)
   */
  function getH5PContainer($container) {
    var $h5pContainer = $container.closest('.h5p-frame');

    // Check closest h5p frame first, then check for container in case there is no frame.
    if (!$h5pContainer.length) {
      $h5pContainer = $container.closest('.h5p-container');
    }

    return $h5pContainer;
  }

  /**
   * Event handler that is called when the window is resized.
   */
  function handleResize() {
    position($currentSpeechBubble, $currentContainer, currentMaxWidth, $tail, $innerTail);
  }

  /**
   * Repositions the speech bubble according to the position of the container.
   * 
   * @param {object} $currentSpeechbubble the speech bubble that should be positioned   
   * @param {object} $container the container to which the speech bubble should point 
   * @param {number} maxWidth the maximum width of the speech bubble
   * @param {object} $tail the tail (the triangle that points to the referenced container)
   * @param {object} $innerTail the inner tail (the triangle that points to the referenced container)
   */
  function position($currentSpeechBubble, $container, maxWidth, $tail, $innerTail) {
    var $h5pContainer = getH5PContainer($container);

    // Calculate offset between the button and the h5p frame
    var offset = getOffsetBetween($h5pContainer, $container);

    var direction = (offset.bottom > offset.top ? 'bottom' : 'top');
    var tipWidth = offset.outerWidth * 0.9; // Var needs to be renamed to make sense
    var bubbleWidth = tipWidth > maxWidth ? maxWidth : tipWidth;

    var bubblePosition = getBubblePosition(bubbleWidth, offset);
    var tailPosition = getTailPosition(bubbleWidth, bubblePosition, offset, $container.width());
    // Need to set font-size, since element is appended to body.
    // Using same font-size as parent. In that way it will grow accordingly
    // when resizing
    var fontSize = 16;//parseFloat($parent.css('font-size'));

    // Set width and position of speech bubble
    $currentSpeechBubble.css(bubbleCSS(
      direction,
      bubbleWidth,
      bubblePosition,
      fontSize
    ));

    var preparedTailCSS = tailCSS(direction, tailPosition);
    $tail.css(preparedTailCSS);
    $innerTail.css(preparedTailCSS);
  }

  /**
   * Static function for removing the speechbubble
   */
  var remove = function () {
    H5P.$body.off('mousedown.speechBubble');
    H5P.$window.off('resize', '', handleResize);
    $currentContainer.parents('.h5p-dialog').off('mousedown.speechBubble');
    if (iDevice) {
      H5P.$body.css('cursor', '');
    }
    if ($currentSpeechBubble !== undefined) {
      // Apply transition, then remove speech bubble
      $currentSpeechBubble.removeClass('show');

      // Make sure we remove any old timeout before reassignment
      clearTimeout(removeSpeechBubbleTimeout);
      removeSpeechBubbleTimeout = setTimeout(function () {
        $currentSpeechBubble.remove();
        $currentSpeechBubble = undefined;
      }, 500);
    }
    // Don't return false here. If the user e.g. clicks a button when the bubble is visible,
    // we want the bubble to disapear AND the button to receive the event
  };

  /**
   * Remove the speech bubble and container reference
   */
  function handleOutsideClick(event) {
    if (event.target === $currentContainer[0]) {
      return; // Button clicks are not outside clicks
    }

    remove();
    // There is no current container when a container isn't clicked
    $currentContainer = undefined;
  }

  /**
   * Calculate position for speech bubble
   *
   * @param {number} bubbleWidth The width of the speech bubble
   * @param {object} offset
   * @return {object} Return position for the speech bubble
   */
  function getBubblePosition(bubbleWidth, offset) {
    var bubblePosition = {};

    var tailOffset = 9;
    var widthOffset = bubbleWidth / 2;

    // Calculate top position
    bubblePosition.top = offset.top + offset.innerHeight;

    // Calculate bottom position
    bubblePosition.bottom = offset.bottom + offset.innerHeight + tailOffset;

    // Calculate left position
    if (offset.left < widthOffset) {
      bubblePosition.left = 3;
    }
    else if ((offset.left + widthOffset) > offset.outerWidth) {
      bubblePosition.left = offset.outerWidth - bubbleWidth - 3;
    }
    else {
      bubblePosition.left = offset.left - widthOffset + (offset.innerWidth / 2);
    }

    return bubblePosition;
  }

  /**
   * Calculate position for speech bubble tail
   *
   * @param {number} bubbleWidth The width of the speech bubble
   * @param {object} bubblePosition Speech bubble position
   * @param {object} offset
   * @param {number} iconWidth The width of the tip icon
   * @return {object} Return position for the tail
   */
  function getTailPosition(bubbleWidth, bubblePosition, offset, iconWidth) {
    var tailPosition = {};
    // Magic numbers. Tuned by hand so that the tail fits visually within
    // the bounds of the speech bubble.
    var leftBoundary = 9;
    var rightBoundary = bubbleWidth - 20;

    tailPosition.left = offset.left - bubblePosition.left + (iconWidth / 2) - 6;
    if (tailPosition.left < leftBoundary) {
      tailPosition.left = leftBoundary;
    }
    if (tailPosition.left > rightBoundary) {
      tailPosition.left = rightBoundary;
    }

    tailPosition.top = -6;
    tailPosition.bottom = -6;

    return tailPosition;
  }

  /**
   * Return bubble CSS for the desired growth direction
   *
   * @param {string} direction The direction the speech bubble will grow
   * @param {number} width The width of the speech bubble
   * @param {object} position Speech bubble position
   * @param {number} fontSize The size of the bubbles font
   * @return {object} Return CSS
   */
  function bubbleCSS(direction, width, position, fontSize) {
    if (direction === 'top') {
      return {
        width: width + 'px',
        bottom: position.bottom + 'px',
        left: position.left + 'px',
        fontSize: fontSize + 'px',
        top: ''
      };
    }
    else {
      return {
        width: width + 'px',
        top: position.top + 'px',
        left: position.left + 'px',
        fontSize: fontSize + 'px',
        bottom: ''
      };
    }
  }

  /**
   * Return tail CSS for the desired growth direction
   *
   * @param {string} direction The direction the speech bubble will grow
   * @param {object} position Tail position
   * @return {object} Return CSS
   */
  function tailCSS(direction, position) {
    if (direction === 'top') {
      return {
        bottom: position.bottom + 'px',
        left: position.left + 'px',
        top: ''
      };
    }
    else {
      return {
        top: position.top + 'px',
        left: position.left + 'px',
        bottom: ''
      };
    }
  }

  /**
   * Calculates the offset between an element inside a container and the
   * container. Only works if all the edges of the inner element are inside the
   * outer element.
   * Width/height of the elements is included as a convenience.
   *
   * @param {H5P.jQuery} $outer
   * @param {H5P.jQuery} $inner
   * @return {object} Position offset
   */
  function getOffsetBetween($outer, $inner) {
    var outer = $outer[0].getBoundingClientRect();
    var inner = $inner[0].getBoundingClientRect();

    return {
      top: inner.top - outer.top,
      right: outer.right - inner.right,
      bottom: outer.bottom - inner.bottom,
      left: inner.left - outer.left,
      innerWidth: inner.width,
      innerHeight: inner.height,
      outerWidth: outer.width,
      outerHeight: outer.height
    };
  }

  return JoubelSpeechBubble;
})(H5P.jQuery);
;
var H5P = H5P || {};

H5P.JoubelThrobber = (function ($) {

  /**
   * Creates a new tip
   */
  function JoubelThrobber() {

    // h5p-throbber css is described in core
    var $throbber = $('<div/>', {
      'class': 'h5p-throbber'
    });

    return $throbber;
  }

  return JoubelThrobber;
}(H5P.jQuery));
;
H5P.JoubelTip = (function ($) {
  var $conv = $('<div/>');

  /**
   * Creates a new tip element.
   *
   * NOTE that this may look like a class but it doesn't behave like one.
   * It returns a jQuery object.
   *
   * @param {string} tipHtml The text to display in the popup
   * @param {Object} [behaviour] Options
   * @param {string} [behaviour.tipLabel] Set to use a custom label for the tip button (you want this for good A11Y)
   * @param {boolean} [behaviour.helpIcon] Set to 'true' to Add help-icon classname to Tip button (changes the icon)
   * @param {boolean} [behaviour.showSpeechBubble] Set to 'false' to disable functionality (you may this in the editor)
   * @param {boolean} [behaviour.tabcontrol] Set to 'true' if you plan on controlling the tabindex in the parent (tabindex="-1")
   * @return {H5P.jQuery|undefined} Tip button jQuery element or 'undefined' if invalid tip
   */
  function JoubelTip(tipHtml, behaviour) {

    // Keep track of the popup that appears when you click the Tip button
    var speechBubble;

    // Parse tip html to determine text
    var tipText = $conv.html(tipHtml).text().trim();
    if (tipText === '') {
      return; // The tip has no textual content, i.e. it's invalid.
    }

    // Set default behaviour
    behaviour = $.extend({
      tipLabel: tipText,
      helpIcon: false,
      showSpeechBubble: true,
      tabcontrol: false
    }, behaviour);

    // Create Tip button
    var $tipButton = $('<div/>', {
      class: 'joubel-tip-container' + (behaviour.showSpeechBubble ? '' : ' be-quiet'),
      'aria-label': behaviour.tipLabel,
      'aria-expanded': false,
      role: 'button',
      tabindex: (behaviour.tabcontrol ? -1 : 0),
      click: function (event) {
        // Toggle show/hide popup
        toggleSpeechBubble();
        event.preventDefault();
      },
      keydown: function (event) {
        if (event.which === 32 || event.which === 13) { // Space & enter key
          // Toggle show/hide popup
          toggleSpeechBubble();
          event.stopPropagation();
          event.preventDefault();
        }
        else { // Any other key
          // Toggle hide popup
          toggleSpeechBubble(false);
        }
      },
      // Add markup to render icon
      html: '<span class="joubel-icon-tip-normal ' + (behaviour.helpIcon ? ' help-icon': '') + '">' +
              '<span class="h5p-icon-shadow"></span>' +
              '<span class="h5p-icon-speech-bubble"></span>' +
              '<span class="h5p-icon-info"></span>' +
            '</span>'
      // IMPORTANT: All of the markup elements must have 'pointer-events: none;'
    });

    const $tipAnnouncer = $('<div>', {
      'class': 'hidden-but-read',
      'aria-live': 'polite',
      appendTo: $tipButton,
    });

    /**
     * Tip button interaction handler.
     * Toggle show or hide the speech bubble popup when interacting with the
     * Tip button.
     *
     * @private
     * @param {boolean} [force] 'true' shows and 'false' hides.
     */
    var toggleSpeechBubble = function (force) {
      if (speechBubble !== undefined && speechBubble.isCurrent($tipButton)) {
        // Hide current popup
        speechBubble.remove();
        speechBubble = undefined;

        $tipButton.attr('aria-expanded', false);
        $tipAnnouncer.html('');
      }
      else if (force !== false && behaviour.showSpeechBubble) {
        // Create and show new popup
        speechBubble = H5P.JoubelSpeechBubble($tipButton, tipHtml);
        $tipButton.attr('aria-expanded', true);
        $tipAnnouncer.html(tipHtml);
      }
    };

    return $tipButton;
  }

  return JoubelTip;
})(H5P.jQuery);
;
var H5P = H5P || {};

H5P.JoubelSlider = (function ($) {

  /**
   * Creates a new Slider
   *
   * @param {object} [params] Additional parameters
   */
  function JoubelSlider(params) {
    H5P.EventDispatcher.call(this);

    this.$slider = $('<div>', $.extend({
      'class': 'h5p-joubel-ui-slider'
    }, params));

    this.$slides = [];
    this.currentIndex = 0;
    this.numSlides = 0;
  }
  JoubelSlider.prototype = Object.create(H5P.EventDispatcher.prototype);
  JoubelSlider.prototype.constructor = JoubelSlider;

  JoubelSlider.prototype.addSlide = function ($content) {
    $content.addClass('h5p-joubel-ui-slide').css({
      'left': (this.numSlides*100) + '%'
    });
    this.$slider.append($content);
    this.$slides.push($content);

    this.numSlides++;

    if(this.numSlides === 1) {
      $content.addClass('current');
    }
  };

  JoubelSlider.prototype.attach = function ($container) {
    $container.append(this.$slider);
  };

  JoubelSlider.prototype.move = function (index) {
    var self = this;

    if(index === 0) {
      self.trigger('first-slide');
    }
    if(index+1 === self.numSlides) {
      self.trigger('last-slide');
    }
    self.trigger('move');

    var $previousSlide = self.$slides[this.currentIndex];
    H5P.Transition.onTransitionEnd(this.$slider, function () {
      $previousSlide.removeClass('current');
      self.trigger('moved');
    });
    this.$slides[index].addClass('current');

    var translateX = 'translateX(' + (-index*100) + '%)';
    this.$slider.css({
      '-webkit-transform': translateX,
      '-moz-transform': translateX,
      '-ms-transform': translateX,
      'transform': translateX
    });

    this.currentIndex = index;
  };

  JoubelSlider.prototype.remove = function () {
    this.$slider.remove();
  };

  JoubelSlider.prototype.next = function () {
    if(this.currentIndex+1 >= this.numSlides) {
      return;
    }

    this.move(this.currentIndex+1);
  };

  JoubelSlider.prototype.previous = function () {
    this.move(this.currentIndex-1);
  };

  JoubelSlider.prototype.first = function () {
    this.move(0);
  };

  JoubelSlider.prototype.last = function () {
    this.move(this.numSlides-1);
  };

  return JoubelSlider;
})(H5P.jQuery);
;
var H5P = H5P || {};

/**
 * @module
 */
H5P.JoubelScoreBar = (function ($) {

  /* Need to use an id for the star SVG since that is the only way to reference
     SVG filters  */
  var idCounter = 0;

  /**
   * Creates a score bar
   * @class H5P.JoubelScoreBar
   * @param {number} maxScore  Maximum score
   * @param {string} [label] Makes it easier for readspeakers to identify the scorebar
   * @param {string} [helpText] Score explanation
   * @param {string} [scoreExplanationButtonLabel] Label for score explanation button
   */
  function JoubelScoreBar(maxScore, label, helpText, scoreExplanationButtonLabel) {
    var self = this;

    self.maxScore = maxScore;
    self.score = 0;
    idCounter++;

    /**
     * @const {string}
     */
    self.STAR_MARKUP = '<svg tabindex="-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 63.77 53.87" aria-hidden="true" focusable="false">' +
        '<title>star</title>' +
        '<filter tabindex="-1" id="h5p-joubelui-score-bar-star-inner-shadow-' + idCounter + '" x0="-50%" y0="-50%" width="200%" height="200%">' +
          '<feGaussianBlur in="SourceAlpha" stdDeviation="3" result="blur"></feGaussianBlur>' +
          '<feOffset dy="2" dx="4"></feOffset>' +
          '<feComposite in2="SourceAlpha" operator="arithmetic" k2="-1" k3="1" result="shadowDiff"></feComposite>' +
          '<feFlood flood-color="#ffe95c" flood-opacity="1"></feFlood>' +
          '<feComposite in2="shadowDiff" operator="in"></feComposite>' +
          '<feComposite in2="SourceGraphic" operator="over" result="firstfilter"></feComposite>' +
          '<feGaussianBlur in="firstfilter" stdDeviation="3" result="blur2"></feGaussianBlur>' +
          '<feOffset dy="-2" dx="-4"></feOffset>' +
          '<feComposite in2="firstfilter" operator="arithmetic" k2="-1" k3="1" result="shadowDiff"></feComposite>' +
          '<feFlood flood-color="#ffe95c" flood-opacity="1"></feFlood>' +
          '<feComposite in2="shadowDiff" operator="in"></feComposite>' +
          '<feComposite in2="firstfilter" operator="over"></feComposite>' +
        '</filter>' +
        '<path tabindex="-1" class="h5p-joubelui-score-bar-star-shadow" d="M35.08,43.41V9.16H20.91v0L9.51,10.85,9,10.93C2.8,12.18,0,17,0,21.25a11.22,11.22,0,0,0,3,7.48l8.73,8.53-1.07,6.16Z"/>' +
        '<g tabindex="-1">' +
          '<path tabindex="-1" class="h5p-joubelui-score-bar-star-border" d="M61.36,22.8,49.72,34.11l2.78,16a2.6,2.6,0,0,1,.05.64c0,.85-.37,1.6-1.33,1.6A2.74,2.74,0,0,1,49.94,52L35.58,44.41,21.22,52a2.93,2.93,0,0,1-1.28.37c-.91,0-1.33-.75-1.33-1.6,0-.21.05-.43.05-.64l2.78-16L9.8,22.8A2.57,2.57,0,0,1,9,21.25c0-1,1-1.33,1.81-1.49l16.07-2.35L34.09,2.83c.27-.59.85-1.33,1.55-1.33s1.28.69,1.55,1.33l7.21,14.57,16.07,2.35c.75.11,1.81.53,1.81,1.49A3.07,3.07,0,0,1,61.36,22.8Z"/>' +
          '<path tabindex="-1" class="h5p-joubelui-score-bar-star-fill" d="M61.36,22.8,49.72,34.11l2.78,16a2.6,2.6,0,0,1,.05.64c0,.85-.37,1.6-1.33,1.6A2.74,2.74,0,0,1,49.94,52L35.58,44.41,21.22,52a2.93,2.93,0,0,1-1.28.37c-.91,0-1.33-.75-1.33-1.6,0-.21.05-.43.05-.64l2.78-16L9.8,22.8A2.57,2.57,0,0,1,9,21.25c0-1,1-1.33,1.81-1.49l16.07-2.35L34.09,2.83c.27-.59.85-1.33,1.55-1.33s1.28.69,1.55,1.33l7.21,14.57,16.07,2.35c.75.11,1.81.53,1.81,1.49A3.07,3.07,0,0,1,61.36,22.8Z"/>' +
          '<path tabindex="-1" filter="url(#h5p-joubelui-score-bar-star-inner-shadow-' + idCounter + ')" class="h5p-joubelui-score-bar-star-fill-full-score" d="M61.36,22.8,49.72,34.11l2.78,16a2.6,2.6,0,0,1,.05.64c0,.85-.37,1.6-1.33,1.6A2.74,2.74,0,0,1,49.94,52L35.58,44.41,21.22,52a2.93,2.93,0,0,1-1.28.37c-.91,0-1.33-.75-1.33-1.6,0-.21.05-.43.05-.64l2.78-16L9.8,22.8A2.57,2.57,0,0,1,9,21.25c0-1,1-1.33,1.81-1.49l16.07-2.35L34.09,2.83c.27-.59.85-1.33,1.55-1.33s1.28.69,1.55,1.33l7.21,14.57,16.07,2.35c.75.11,1.81.53,1.81,1.49A3.07,3.07,0,0,1,61.36,22.8Z"/>' +
        '</g>' +
      '</svg>';

    /**
     * @function appendTo
     * @memberOf H5P.JoubelScoreBar#
     * @param {H5P.jQuery}  $wrapper  Dom container
     */
    self.appendTo = function ($wrapper) {
      self.$scoreBar.appendTo($wrapper);
    };

    /**
     * Create the text representation of the scorebar .
     *
     * @private
     * @return {string}
     */
    var createLabel = function (score) {
      if (!label) {
        return '';
      }

      return label.replace(':num', score).replace(':total', self.maxScore);
    };

    /**
     * Creates the html for this widget
     *
     * @method createHtml
     * @private
     */
    var createHtml = function () {
      // Container div
      self.$scoreBar = $('<div>', {
        'class': 'h5p-joubelui-score-bar',
      });

      var $visuals = $('<div>', {
        'class': 'h5p-joubelui-score-bar-visuals',
        appendTo: self.$scoreBar
      });

      // The progress bar wrapper
      self.$progressWrapper = $('<div>', {
        'class': 'h5p-joubelui-score-bar-progress-wrapper',
        appendTo: $visuals
      });

      self.$progress = $('<div>', {
        'class': 'h5p-joubelui-score-bar-progress',
        'html': createLabel(self.score),
        appendTo: self.$progressWrapper
      });

      // The star
      $('<div>', {
        'class': 'h5p-joubelui-score-bar-star',
        html: self.STAR_MARKUP
      }).appendTo($visuals);

      // The score container
      var $numerics = $('<div>', {
        'class': 'h5p-joubelui-score-numeric',
        appendTo: self.$scoreBar,
        'aria-hidden': true
      });

      // The current score
      self.$scoreCounter = $('<span>', {
        'class': 'h5p-joubelui-score-number h5p-joubelui-score-number-counter',
        text: 0,
        appendTo: $numerics
      });

      // The separator
      $('<span>', {
        'class': 'h5p-joubelui-score-number-separator',
        text: '/',
        appendTo: $numerics
      });

      // Max score
      self.$maxScore = $('<span>', {
        'class': 'h5p-joubelui-score-number h5p-joubelui-score-max',
        text: self.maxScore,
        appendTo: $numerics
      });

      if (helpText) {
        H5P.JoubelUI.createTip(helpText, {
          tipLabel: scoreExplanationButtonLabel ? scoreExplanationButtonLabel : helpText,
          helpIcon: true
        }).appendTo(self.$scoreBar);
        self.$scoreBar.addClass('h5p-score-bar-has-help');
      }
    };

    /**
     * Set the current score
     * @method setScore
     * @memberOf H5P.JoubelScoreBar#
     * @param  {number} score
     */
    self.setScore = function (score) {
      // Do nothing if score hasn't changed
      if (score === self.score) {
        return;
      }
      self.score = score > self.maxScore ? self.maxScore : score;
      self.updateVisuals();
    };

    /**
     * Increment score
     * @method incrementScore
     * @memberOf H5P.JoubelScoreBar#
     * @param  {number=}        incrementBy Optional parameter, defaults to 1
     */
    self.incrementScore = function (incrementBy) {
      self.setScore(self.score + (incrementBy || 1));
    };

    /**
     * Set the max score
     * @method setMaxScore
     * @memberOf H5P.JoubelScoreBar#
     * @param  {number}    maxScore The max score
     */
    self.setMaxScore = function (maxScore) {
      self.maxScore = maxScore;
    };

    /**
     * Updates the progressbar visuals
     * @memberOf H5P.JoubelScoreBar#
     * @method updateVisuals
     */
    self.updateVisuals = function () {
      self.$progress.html(createLabel(self.score));
      self.$scoreCounter.text(self.score);
      self.$maxScore.text(self.maxScore);

      setTimeout(function () {
        // Start the progressbar animation
        self.$progress.css({
          width: ((self.score / self.maxScore) * 100) + '%'
        });

        H5P.Transition.onTransitionEnd(self.$progress, function () {
          // If fullscore fill the star and start the animation
          self.$scoreBar.toggleClass('h5p-joubelui-score-bar-full-score', self.score === self.maxScore);
          self.$scoreBar.toggleClass('h5p-joubelui-score-bar-animation-active', self.score === self.maxScore);

          // Only allow the star animation to run once
          self.$scoreBar.one("animationend", function() {
            self.$scoreBar.removeClass("h5p-joubelui-score-bar-animation-active");
          });
        }, 600);
      }, 300);
    };

    /**
     * Removes all classes
     * @method reset
     */
    self.reset = function () {
      self.$scoreBar.removeClass('h5p-joubelui-score-bar-full-score');
    };

    createHtml();
  }

  return JoubelScoreBar;
})(H5P.jQuery);
;
var H5P = H5P || {};

H5P.JoubelProgressbar = (function ($) {

  /**
   * Joubel progressbar class
   * @method JoubelProgressbar
   * @constructor
   * @param  {number}          steps Number of steps
   * @param {Object} [options] Additional options
   * @param {boolean} [options.disableAria] Disable readspeaker assistance
   * @param {string} [options.progressText] A progress text for describing
   *  current progress out of total progress for readspeakers.
   *  e.g. "Slide :num of :total"
   */
  function JoubelProgressbar(steps, options) {
    H5P.EventDispatcher.call(this);
    var self = this;
    this.options = $.extend({
      progressText: 'Slide :num of :total'
    }, options);
    this.currentStep = 0;
    this.steps = steps;

    this.$progressbar = $('<div>', {
      'class': 'h5p-joubelui-progressbar'
    });
    this.$background = $('<div>', {
      'class': 'h5p-joubelui-progressbar-background'
    }).appendTo(this.$progressbar);
  }

  JoubelProgressbar.prototype = Object.create(H5P.EventDispatcher.prototype);
  JoubelProgressbar.prototype.constructor = JoubelProgressbar;

  JoubelProgressbar.prototype.updateAria = function () {
    var self = this;
    if (this.options.disableAria) {
      return;
    }

    if (!this.$currentStatus) {
      this.$currentStatus = $('<div>', {
        'class': 'h5p-joubelui-progressbar-slide-status-text',
        'aria-live': 'assertive'
      }).appendTo(this.$progressbar);
    }
    var interpolatedProgressText = self.options.progressText
      .replace(':num', self.currentStep)
      .replace(':total', self.steps);
    this.$currentStatus.html(interpolatedProgressText);
  };

  /**
   * Appends to a container
   * @method appendTo
   * @param  {H5P.jquery} $container
   */
  JoubelProgressbar.prototype.appendTo = function ($container) {
    this.$progressbar.appendTo($container);
  };

  /**
   * Update progress
   * @method setProgress
   * @param  {number}    step
   */
  JoubelProgressbar.prototype.setProgress = function (step) {
    // Check for valid value:
    if (step > this.steps || step < 0) {
      return;
    }
    this.currentStep = step;
    this.$background.css({
      width: ((this.currentStep/this.steps)*100) + '%'
    });

    this.updateAria();
  };

  /**
   * Increment progress with 1
   * @method next
   */
  JoubelProgressbar.prototype.next = function () {
    this.setProgress(this.currentStep+1);
  };

  /**
   * Reset progressbar
   * @method reset
   */
  JoubelProgressbar.prototype.reset = function () {
    this.setProgress(0);
  };

  /**
   * Check if last step is reached
   * @method isLastStep
   * @return {Boolean}
   */
  JoubelProgressbar.prototype.isLastStep = function () {
    return this.steps === this.currentStep;
  };

  return JoubelProgressbar;
})(H5P.jQuery);
;
var H5P = H5P || {};

/**
 * H5P Joubel UI library.
 *
 * This is a utility library, which does not implement attach. I.e, it has to bee actively used by
 * other libraries
 * @module
 */
H5P.JoubelUI = (function ($) {

  /**
   * The internal object to return
   * @class H5P.JoubelUI
   * @static
   */
  function JoubelUI() {}

  /* Public static functions */

  /**
   * Create a tip icon
   * @method H5P.JoubelUI.createTip
   * @param  {string}  text   The textual tip
   * @param  {Object}  params Parameters
   * @return {H5P.JoubelTip}
   */
  JoubelUI.createTip = function (text, params) {
    return new H5P.JoubelTip(text, params);
  };

  /**
   * Create message dialog
   * @method H5P.JoubelUI.createMessageDialog
   * @param  {H5P.jQuery}               $container The dom container
   * @param  {string}                   message    The message
   * @return {H5P.JoubelMessageDialog}
   */
  JoubelUI.createMessageDialog = function ($container, message) {
    return new H5P.JoubelMessageDialog($container, message);
  };

  /**
   * Create help text dialog
   * @method H5P.JoubelUI.createHelpTextDialog
   * @param  {string}             header  The textual header
   * @param  {string}             message The textual message
   * @param  {string}             closeButtonTitle The title for the close button
   * @return {H5P.JoubelHelpTextDialog}
   */
  JoubelUI.createHelpTextDialog = function (header, message, closeButtonTitle) {
    return new H5P.JoubelHelpTextDialog(header, message, closeButtonTitle);
  };

  /**
   * Create progress circle
   * @method H5P.JoubelUI.createProgressCircle
   * @param  {number}             number          The progress (0 to 100)
   * @param  {string}             progressColor   The progress color in hex value
   * @param  {string}             fillColor       The fill color in hex value
   * @param  {string}             backgroundColor The background color in hex value
   * @return {H5P.JoubelProgressCircle}
   */
  JoubelUI.createProgressCircle = function (number, progressColor, fillColor, backgroundColor) {
    return new H5P.JoubelProgressCircle(number, progressColor, fillColor, backgroundColor);
  };

  /**
   * Create throbber for loading
   * @method H5P.JoubelUI.createThrobber
   * @return {H5P.JoubelThrobber}
   */
  JoubelUI.createThrobber = function () {
    return new H5P.JoubelThrobber();
  };

  /**
   * Create simple rounded button
   * @method H5P.JoubelUI.createSimpleRoundedButton
   * @param  {string}                  text The button label
   * @return {H5P.SimpleRoundedButton}
   */
  JoubelUI.createSimpleRoundedButton = function (text) {
    return new H5P.SimpleRoundedButton(text);
  };

  /**
   * Create Slider
   * @method H5P.JoubelUI.createSlider
   * @param  {Object} [params] Parameters
   * @return {H5P.JoubelSlider}
   */
  JoubelUI.createSlider = function (params) {
    return new H5P.JoubelSlider(params);
  };

  /**
   * Create Score Bar
   * @method H5P.JoubelUI.createScoreBar
   * @param  {number=}       maxScore The maximum score
   * @param {string} [label] Makes it easier for readspeakers to identify the scorebar
   * @return {H5P.JoubelScoreBar}
   */
  JoubelUI.createScoreBar = function (maxScore, label, helpText, scoreExplanationButtonLabel) {
    return new H5P.JoubelScoreBar(maxScore, label, helpText, scoreExplanationButtonLabel);
  };

  /**
   * Create Progressbar
   * @method H5P.JoubelUI.createProgressbar
   * @param  {number=}       numSteps The total numer of steps
   * @param {Object} [options] Additional options
   * @param {boolean} [options.disableAria] Disable readspeaker assistance
   * @param {string} [options.progressText] A progress text for describing
   *  current progress out of total progress for readspeakers.
   *  e.g. "Slide :num of :total"
   * @return {H5P.JoubelProgressbar}
   */
  JoubelUI.createProgressbar = function (numSteps, options) {
    return new H5P.JoubelProgressbar(numSteps, options);
  };

  /**
   * Create standard Joubel button
   *
   * @method H5P.JoubelUI.createButton
   * @param {object} params
   *  May hold any properties allowed by jQuery. If href is set, an A tag
   *  is used, if not a button tag is used.
   * @return {H5P.jQuery} The jquery element created
   */
  JoubelUI.createButton = function(params) {
    var type = 'button';
    if (params.href) {
      type = 'a';
    }
    else {
      params.type = 'button';
    }
    if (params.class) {
      params.class += ' h5p-joubelui-button';
    }
    else {
      params.class = 'h5p-joubelui-button';
    }
    return $('<' + type + '/>', params);
  };

  /**
   * Fix for iframe scoll bug in IOS. When focusing an element that doesn't have
   * focus support by default the iframe will scroll the parent frame so that
   * the focused element is out of view. This varies dependening on the elements
   * of the parent frame.
   */
  if (H5P.isFramed && !H5P.hasiOSiframeScrollFix &&
      /iPad|iPhone|iPod/.test(navigator.userAgent)) {
    H5P.hasiOSiframeScrollFix = true;

    // Keep track of original focus function
    var focus = HTMLElement.prototype.focus;

    // Override the original focus
    HTMLElement.prototype.focus = function () {
      // Only focus the element if it supports it natively
      if ( (this instanceof HTMLAnchorElement ||
            this instanceof HTMLInputElement ||
            this instanceof HTMLSelectElement ||
            this instanceof HTMLTextAreaElement ||
            this instanceof HTMLButtonElement ||
            this instanceof HTMLIFrameElement ||
            this instanceof HTMLAreaElement) && // HTMLAreaElement isn't supported by Safari yet.
          !this.getAttribute('role')) { // Focus breaks if a different role has been set
          // In theory this.isContentEditable should be able to recieve focus,
          // but it didn't work when tested.

        // Trigger the original focus with the proper context
        focus.call(this);
      }
    };
  }

  return JoubelUI;
})(H5P.jQuery);
;
(()=>{var e={46:e=>{e.exports=function(e,t){this.index=e,this.parent=t}},575:(e,t,i)=>{const n=i(46),r=H5P.EventDispatcher;function s(e,t){const i=this;r.call(i),i.children=[];var s=function(e){for(let t=e;t<i.children.length;t++)i.children[t].index=t};if(i.addChild=function(t,r){void 0===r&&(r=i.children.length);const o=new n(r,i);return r===i.children.length?i.children.push(o):(i.children.splice(r,0,o),s(r)),e.call(o,t),o},i.removeChild=function(e){i.children.splice(e,1),s(e)},i.moveChild=function(e,t){const n=i.children.splice(e,1)[0];i.children.splice(t,0,n),s(t<e?t:e)},t)for(let e=0;e<t.length;e++)i.addChild(t[e])}s.prototype=Object.create(r.prototype),s.prototype.constructor=s,e.exports=s}},t={};function i(n){var r=t[n];if(void 0!==r)return r.exports;var s=t[n]={exports:{}};return e[n](s,s.exports,i),s.exports}i.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return i.d(t,{a:t}),t},i.d=(e,t)=>{for(var n in t)i.o(t,n)&&!i.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},i.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{"use strict";var e=i(575),t=i.n(e),n=H5P.jQuery,r=H5P.EventDispatcher,s=H5P.JoubelUI,o=function(e){return e.concat.apply([],e)},a=function(e){return"function"==typeof e},l=null!==navigator.userAgent.match(/iPad/i),d=null!==navigator.userAgent.match(/iPad|iPod|iPhone/i),c=function(e,t){return-1!==e.indexOf(t)},p=function(e,t){return void 0!==e?e:t},h=13,u=27,m=32,f=function(e,t,i){e.click((function(e){t.call(i||this,e)})),e.keydown((function(e){c([h,m],e.which)&&(e.preventDefault(),t.call(i||this,e))}))},v=n("<div>");const g=function(){function e(e,t){this.$summarySlide=t,this.cp=e}return e.prototype.updateSummarySlide=function(e,t){var i=this,r=void 0===this.cp.editor&&void 0!==this.$summarySlide&&e>=this.cp.slides.length-1,o=!this.cp.showSummarySlide&&this.cp.hasAnswerElements;if(r){i.cp.presentation.keywordListEnabled&&i.cp.presentation.keywordListAlwaysShow&&i.cp.hideKeywords(),this.$summarySlide.children().remove();var a=i.cp.getSlideScores(t),l=i.outputScoreStats(a);if(n(l).appendTo(i.$summarySlide),!o){var d=i.totalScores(a);if(!isNaN(d.totalPercentage)){var c=s.createScoreBar(d.totalMaxScore,"","","");c.setScore(d.totalScore);var p=n(".h5p-summary-total-score",i.$summarySlide);c.appendTo(p),setTimeout((function(){p.append(n("<div/>",{"aria-live":"polite",class:"hidden-but-read",html:i.cp.l10n.summary+". "+i.cp.l10n.accessibilityTotalScore.replace("@score",d.totalScore).replace("@maxScore",d.totalMaxScore)}))}),100)}if(1==i.cp.enableTwitterShare){var h=n(".h5p-summary-twitter-message",i.$summarySlide);this.addTwitterScoreLinkTo(h,d)}if(1==i.cp.enableFacebookShare){var u=n(".h5p-summary-facebook-message",i.$summarySlide);this.addFacebookScoreLinkTo(u,d)}if(1==i.cp.enableGoogleShare){var m=n(".h5p-summary-google-message",i.$summarySlide);this.addGoogleScoreLinkTo(m)}i.$summarySlide.find(".h5p-td > .h5p-slide-link").each((function(){var e=n(this);e.click((function(t){i.cp.jumpToSlide(parseInt(e.data("slide"),10)-1),t.preventDefault()}))}))}var f=n(".h5p-summary-footer",i.$summarySlide);this.cp.showSummarySlideSolutionButton&&s.createButton({class:"h5p-show-solutions",html:i.cp.l10n.showSolutions,on:{click:function(){i.toggleSolutionMode(!0)}},appendTo:f}),this.cp.showSummarySlideRetryButton&&s.createButton({class:"h5p-cp-retry-button",html:i.cp.l10n.retry,on:{click:function(){i.cp.resetTask()}},appendTo:f}),i.cp.hasAnswerElements&&s.createButton({class:"h5p-eta-export",html:i.cp.l10n.exportAnswers,on:{click:function(){H5P.ExportableTextArea.Exporter.run(i.cp.slides,i.cp.elementInstances)}},appendTo:f})}},e.prototype.outputScoreStats=function(e){if(void 0===e)return this.$summarySlide.addClass("h5p-summary-only-export"),'<div class="h5p-summary-footer"></div>';var t,i=this,n=0,r=0,s="",o=0,a="";for(t=0;t<e.length;t+=1)a=this.getSlideDescription(e[t]),o=Math.round(e[t].score/e[t].maxScore*100),isNaN(o)&&(o=0),s+='<tr><td class="h5p-td h5p-summary-task-title"><a href="#" class="h5p-slide-link"  aria-label=" '+i.cp.l10n.slide+" "+e[t].slide+": "+a.replace(/(<([^>]+)>)/gi,"")+" "+o+'%" data-slide="'+e[t].slide+'">'+i.cp.l10n.slide+" "+e[t].slide+": "+a.replace(/(<([^>]+)>)/gi,"")+'</a></td><td class="h5p-td h5p-summary-score-bar"><p class="hidden-but-read">'+o+"%</p><p>"+e[t].score+"<span>/</span>"+e[t].maxScore+"</p></td></tr>",n+=e[t].score,r+=e[t].maxScore;this.cp.isSolutionMode||i.cp.triggerXAPICompleted(n,r);var l=i.cp.enableTwitterShare||i.cp.enableFacebookShare||i.cp.enableGoogleShare?'<span class="h5p-show-results-text">'+i.cp.l10n.shareResult+"</span>":"",d=1==i.cp.enableTwitterShare?'<span class="h5p-summary-twitter-message" aria-label="'+i.cp.l10n.shareTwitter+'"></span>':"",c=1==i.cp.enableFacebookShare?'<span class="h5p-summary-facebook-message" aria-label="'+i.cp.l10n.shareFacebook+'"></span>':"",p=1==i.cp.enableGoogleShare?'<span class="h5p-summary-google-message" aria-label="'+i.cp.l10n.shareGoogle+'"></span>':"";return'<div class="h5p-summary-table-holder"><div class="h5p-summary-table-pages"><table class="h5p-score-table"><thead><tr><th class="h5p-summary-table-header slide">'+i.cp.l10n.slide+'</th><th class="h5p-summary-table-header score">'+i.cp.l10n.score+"<span>/</span>"+i.cp.l10n.total.toLowerCase()+"</th></tr></thead><tbody>"+s+'</tbody></table></div><div class="h5p-summary-total-table"><div class="h5p-summary-social">'+l+c+d+p+'</div><div class="h5p-summary-total-score"><p>'+i.cp.l10n.totalScore+'</p></div></div></div><div class="h5p-summary-footer"></div>'},e.prototype.getSlideDescription=function(e){var t,i,n=this,r=n.cp.slides[e.slide-1].elements;if(e.indexes.length>1)t=n.cp.l10n.summaryMultipleTaskText;else if(void 0!==r[e.indexes[0]]&&r[0])if(i=r[e.indexes[0]].action,"function"==typeof n.cp.elementInstances[e.slide-1][e.indexes[0]].getTitle)t=n.cp.elementInstances[e.slide-1][e.indexes[0]].getTitle();else if(void 0!==i.library&&i.library){var s=i.library.split(" ")[0].split(".")[1].split(/(?=[A-Z])/),o="";s.forEach((function(e,t){0!==t&&(e=e.toLowerCase()),o+=e,t<=s.length-1&&(o+=" ")})),t=o}return t},e.prototype.addTwitterScoreLinkTo=function(e,t){var i=this,n=i.cp.twitterShareStatement||"",r=i.cp.twitterShareHashtags||"",s=i.cp.twitterShareUrl||"";s=s.replace("@currentpageurl",window.location.href),n=n.replace("@score",t.totalScore).replace("@maxScore",t.totalMaxScore).replace("@percentage",t.totalPercentage+"%").replace("@currentpageurl",window.location.href),r=r.trim().replace(" ",""),n=encodeURIComponent(n),r=encodeURIComponent(r),s=encodeURIComponent(s);var o="https://twitter.com/intent/tweet?";o+=n.length>0?"text="+n+"&":"",o+=s.length>0?"url="+s+"&":"",o+=r.length>0?"hashtags="+r:"";var a=window.innerWidth/2,l=window.innerHeight/2;e.attr("tabindex","0").attr("role","button"),f(e,(function(){return window.open(o,i.cp.l10n.shareTwitter,"width=800,height=300,left="+a+",top="+l),!1}))},e.prototype.addFacebookScoreLinkTo=function(e,t){var i=this,n=i.cp.facebookShareUrl||"",r=i.cp.facebookShareQuote||"";n=n.replace("@currentpageurl",window.location.href),r=r.replace("@currentpageurl",window.location.href).replace("@percentage",t.totalPercentage+"%").replace("@score",t.totalScore).replace("@maxScore",t.totalMaxScore),n=encodeURIComponent(n),r=encodeURIComponent(r);var s="https://www.facebook.com/sharer/sharer.php?";s+=n.length>0?"u="+n+"&":"",s+=r.length>0?"quote="+r:"";var o=window.innerWidth/2,a=window.innerHeight/2;e.attr("tabindex","0").attr("role","button"),f(e,(function(){return window.open(s,i.cp.l10n.shareFacebook,"width=800,height=300,left="+o+",top="+a),!1}))},e.prototype.addGoogleScoreLinkTo=function(e){var t=this,i=t.cp.googleShareUrl||"";i=i.replace("@currentpageurl",window.location.href),i=encodeURIComponent(i);var n="https://plus.google.com/share?";n+=i.length>0?"url="+i:"";var r=window.innerWidth/2,s=window.innerHeight/2;e.attr("tabindex","0").attr("role","button"),f(e,(function(){return window.open(n,t.cp.l10n.shareGoogle,"width=401,height=437,left="+r+",top="+s),!1}))},e.prototype.totalScores=function(e){if(void 0===e)return{totalScore:0,totalMaxScore:0,totalPercentage:0};var t,i=0,n=0;for(t=0;t<e.length;t+=1)i+=e[t].score,n+=e[t].maxScore;var r=Math.round(i/n*100);return isNaN(r)&&(r=0),{totalScore:i,totalMaxScore:n,totalPercentage:r}},e.prototype.toggleSolutionMode=function(e){if(this.cp.isSolutionMode=e,e){var t=this.cp.showSolutions();this.cp.setProgressBarFeedback(t),this.cp.$footer.addClass("h5p-footer-solution-mode"),this.setFooterSolutionModeText(this.cp.l10n.solutionModeText)}else this.cp.$footer.removeClass("h5p-footer-solution-mode"),this.setFooterSolutionModeText(),this.cp.setProgressBarFeedback()},e.prototype.setFooterSolutionModeText=function(e){void 0!==e&&e?this.cp.$exitSolutionModeText.html(e):this.cp.$exitSolutionModeText&&this.cp.$exitSolutionModeText.html("")},e}();var b=function(e){var t=0;function i(){}return i.supported=function(){return"function"==typeof window.print},i.print=function(t,i,n){t.trigger("printing",{finished:!1,allSlides:n});var r=e(".h5p-slide.h5p-current"),s=r.height(),o=r.width()/670,a=e(".h5p-slide");a.css({height:s/o+"px",width:"670px",fontSize:Math.floor(100/o)+"%"});var l=i.height();i.css("height","auto"),a.toggleClass("doprint",!0===n),r.addClass("doprint"),setTimeout((function(){window.print(),a.css({height:"",width:"",fontSize:""}),i.css("height",l+"px"),t.trigger("printing",{finished:!0})}),500)},i.showDialog=function(i,n,r){var s=this,o=t++,a="h5p-cp-print-dialog-".concat(o,"-title"),l="h5p-cp-print-dialog-".concat(o,"-ingress"),d=e('<div class="h5p-popup-dialog h5p-print-dialog">\n                      <div role="dialog" aria-labelledby="'.concat(a,'" aria-describedby="').concat(l,'" tabindex="-1" class="h5p-inner">\n                        <h2 id="').concat(a,'">').concat(i.printTitle,'</h2>\n                        <div class="h5p-scroll-content"></div>\n                        <div class="h5p-close" role="button" tabindex="0" title="').concat(H5P.t("close"),'">\n                      </div>\n                    </div>')).insertAfter(n).click((function(){s.close()})).children(".h5p-inner").click((function(){return!1})).end();f(d.find(".h5p-close"),(function(){return s.close()}));var c=d.find(".h5p-scroll-content");return c.append(e("<div>",{class:"h5p-cp-print-ingress",id:l,html:i.printIngress})),H5P.JoubelUI.createButton({html:i.printAllSlides,class:"h5p-cp-print-all-slides",click:function(){s.close(),r(!0)}}).appendTo(c),H5P.JoubelUI.createButton({html:i.printCurrentSlide,class:"h5p-cp-print-current-slide",click:function(){s.close(),r(!1)}}).appendTo(c),this.open=function(){setTimeout((function(){d.addClass("h5p-open"),H5P.jQuery(s).trigger("dialog-opened",[d])}),1)},this.close=function(){d.removeClass("h5p-open"),setTimeout((function(){d.remove()}),200)},this.open(),d},i}(H5P.jQuery);const y=b,S=function(e){const t=e.length;return function i(){const n=Array.prototype.slice.call(arguments,0);return n.length>=t?e.apply(null,n):function(){const e=Array.prototype.slice.call(arguments,0);return i.apply(null,n.concat(e))}}},w=S((function(e,t){t.forEach(e)})),x=(S((function(e,t){return t.map(e)})),S((function(e,t){return t.filter(e)}))),k=(S((function(e,t){return t.some(e)})),S((function(e,t){return-1!=t.indexOf(e)}))),T=S((function(e,t){return x((t=>!k(t,e)),t)})),C=S(((e,t)=>t.getAttribute(e))),E=S(((e,t,i)=>i.setAttribute(e,t))),P=S(((e,t)=>t.removeAttribute(e))),$=S(((e,t)=>t.hasAttribute(e))),I=(S(((e,t,i)=>i.getAttribute(e)===t)),S(((e,t)=>{const i=C(e,t);E(e,("true"!==i).toString(),t)})),S(((e,t)=>e.appendChild(t))),S(((e,t)=>t.querySelector(e))),S(((e,t)=>{return i=t.querySelectorAll(e),Array.prototype.slice.call(i);var i})),S(((e,t)=>e.removeChild(t))),S(((e,t)=>t.classList.contains(e))),S(((e,t)=>t.classList.add(e)))),A=S(((e,t)=>t.classList.remove(e))),B=I("hidden"),H=A("hidden"),M=(S(((e,t)=>(e?H:B)(t))),S(((e,t,i)=>{i.classList[t?"add":"remove"](e)})),P("tabindex")),L=(w(M),E("tabindex","0")),j=E("tabindex","-1"),O=$("tabindex");class D{constructor(e){Object.assign(this,{listeners:{},on:function(e,t,i){const n={listener:t,scope:i};return this.listeners[e]=this.listeners[e]||[],this.listeners[e].push(n),this},fire:function(e,t){return(this.listeners[e]||[]).every((function(e){return!1!==e.listener.call(e.scope||this,t)}))},propagate:function(e,t){let i=this;e.forEach((e=>t.on(e,(t=>i.fire(e,t)))))}}),this.plugins=e||[],this.elements=[],this.negativeTabIndexAllowed=!1,this.on("nextElement",this.nextElement,this),this.on("previousElement",this.previousElement,this),this.on("firstElement",this.firstElement,this),this.on("lastElement",this.lastElement,this),this.initPlugins()}addElement(e){this.elements.push(e),this.firesEvent("addElement",e),1===this.elements.length&&this.setTabbable(e)}insertElementAt(e,t){this.elements.splice(t,0,e),this.firesEvent("addElement",e),1===this.elements.length&&this.setTabbable(e)}removeElement(e){this.elements=T([e],this.elements),O(e)&&(this.setUntabbable(e),this.elements[0]&&this.setTabbable(this.elements[0])),this.firesEvent("removeElement",e)}count(){return this.elements.length}firesEvent(e,t){const i=this.elements.indexOf(t);return this.fire(e,{element:t,index:i,elements:this.elements,oldElement:this.tabbableElement})}nextElement({index:e}){const t=e===this.elements.length-1,i=this.elements[t?0:e+1];this.setTabbable(i),i.focus()}firstElement(){const e=this.elements[0];this.setTabbable(e),e.focus()}lastElement(){const e=this.elements[this.elements.length-1];this.setTabbable(e),e.focus()}setTabbableByIndex(e){const t=this.elements[e];t&&this.setTabbable(t)}setTabbable(e){w(this.setUntabbable.bind(this),this.elements),L(e),this.tabbableElement=e}setUntabbable(e){e!==document.activeElement&&(this.negativeTabIndexAllowed?j(e):M(e))}previousElement({index:e}){const t=0===e,i=this.elements[t?this.elements.length-1:e-1];this.setTabbable(i),i.focus()}useNegativeTabIndex(){this.negativeTabIndexAllowed=!0,this.elements.forEach((e=>{e.hasAttribute("tabindex")||j(e)}))}initPlugins(){this.plugins.forEach((function(e){void 0!==e.init&&e.init(this)}),this)}}class K{constructor(){this.selectability=!0}init(e){this.boundHandleKeyDown=this.handleKeyDown.bind(this),this.controls=e,this.controls.on("addElement",this.listenForKeyDown,this),this.controls.on("removeElement",this.removeKeyDownListener,this)}listenForKeyDown({element:e}){e.addEventListener("keydown",this.boundHandleKeyDown)}removeKeyDownListener({element:e}){e.removeEventListener("keydown",this.boundHandleKeyDown)}handleKeyDown(e){switch(e.which){case 27:this.close(e.target),e.preventDefault(),e.stopPropagation();break;case 35:this.lastElement(e.target),e.preventDefault(),e.stopPropagation();break;case 36:this.firstElement(e.target),e.preventDefault(),e.stopPropagation();break;case 13:case 32:this.select(e.target),e.preventDefault(),e.stopPropagation();break;case 37:case 38:this.hasChromevoxModifiers(e)||(this.previousElement(e.target),e.preventDefault(),e.stopPropagation());break;case 39:case 40:this.hasChromevoxModifiers(e)||(this.nextElement(e.target),e.preventDefault(),e.stopPropagation())}}hasChromevoxModifiers(e){return e.shiftKey||e.ctrlKey}previousElement(e){!1!==this.controls.firesEvent("beforePreviousElement",e)&&(this.controls.firesEvent("previousElement",e),this.controls.firesEvent("afterPreviousElement",e))}nextElement(e){!1!==this.controls.firesEvent("beforeNextElement",e)&&(this.controls.firesEvent("nextElement",e),this.controls.firesEvent("afterNextElement",e))}select(e){this.selectability&&!1!==this.controls.firesEvent("before-select",e)&&(this.controls.firesEvent("select",e),this.controls.firesEvent("after-select",e))}firstElement(e){!1!==this.controls.firesEvent("beforeFirstElement",e)&&(this.controls.firesEvent("firstElement",e),this.controls.firesEvent("afterFirstElement",e))}lastElement(e){!1!==this.controls.firesEvent("beforeLastElement",e)&&(this.controls.firesEvent("lastElement",e),this.controls.firesEvent("afterLastElement",e))}disableSelectability(){this.selectability=!1}enableSelectability(){this.selectability=!0}close(e){!1!==this.controls.firesEvent("before-close",e)&&(this.controls.firesEvent("close",e),this.controls.firesEvent("after-close",e))}}function F(e,t,i){return t in e?Object.defineProperty(e,t,{value:i,enumerable:!0,configurable:!0,writable:!0}):e[t]=i,e}var W="none",N="not-answered",z="answered",R="has-only-correct",Q="has-incorrect",U=function(e){function t(e){var t;this.cp=e,this.answeredLabels=(F(t={},N,this.cp.l10n.containsNotCompleted+"."),F(t,z,this.cp.l10n.containsCompleted+"."),F(t,R,this.cp.l10n.containsOnlyCorrect+"."),F(t,Q,this.cp.l10n.containsIncorrectAnswers+"."),F(t,W,""),t),this.initProgressbar(this.cp.slidesWithSolutions),this.initFooter(),this.initTaskAnsweredListener(),this.toggleNextAndPreviousButtonDisabled(this.cp.getCurrentSlideIndex())}return t.prototype.initTaskAnsweredListener=function(){var e=this;this.cp.elementInstances.forEach((function(t,i){t.filter((function(e){return a(e.on)})).forEach((function(t){t.on("xAPI",(function(t){var n=t.getVerb();if(c(["interacted","answered","attempted"],n)){var r=e.cp.slideHasAnsweredTask(i);e.setTaskAnswered(i,r)}else"completed"===n&&t.setVerb("answered");void 0===t.data.statement.context.extensions&&(t.data.statement.context.extensions={}),t.data.statement.context.extensions["http://id.tincanapi.com/extension/ending-point"]=i+1}))}))}))},t.prototype.initProgressbar=function(t){var i=this,n=i.cp.previousState&&i.cp.previousState.progress||0;this.progresbarKeyboardControls=new D([new K]),this.progresbarKeyboardControls.negativeTabIndexAllowed=!0,this.progresbarKeyboardControls.on("select",(function(t){i.displaySlide(e(t.element).data("slideNumber"))})),this.progresbarKeyboardControls.on("beforeNextElement",(function(e){return e.index!==e.elements.length-1})),this.progresbarKeyboardControls.on("beforePreviousElement",(function(e){return 0!==e.index})),void 0!==this.cp.progressbarParts&&this.cp.progressbarParts&&this.cp.progressbarParts.forEach((function(e){i.progresbarKeyboardControls.removeElement(e.children("a").get(0)),e.remove()})),i.cp.progressbarParts=[];for(var r=function(t){t.preventDefault();var n=e(this).data("slideNumber");i.progresbarKeyboardControls.setTabbableByIndex(n),i.displaySlide(n),i.cp.focus()},s=0;s<this.cp.slides.length;s+=1){var o=this.cp.slides[s],a=this.createSlideTitle(s),l=e("<div>",{class:"h5p-progressbar-part",id:"progressbar-part-"+s,role:"tab","aria-label":a,"aria-controls":"slide-"+s,"aria-selected":!1}).appendTo(i.cp.$progressbar),c=e("<a>",{href:"#",html:'<span class="h5p-progressbar-part-title hidden-but-read">'+a+"</span>",tabindex:"-1"}).data("slideNumber",s).click(r).appendTo(l);if(this.progresbarKeyboardControls.addElement(c.get(0)),this.isSummarySlide(s)&&l.addClass("progressbar-part-summary-slide"),d||H5P.Tooltip(l.get(0),{position:"top"}),0===s&&l.addClass("h5p-progressbar-part-show"),s===n&&l.addClass("h5p-progressbar-part-selected").attr("aria-selected",!0),i.cp.progressbarParts.push(l),this.updateSlideTitle(s),this.cp.slides.length<=60&&o.elements&&o.elements.length>0){var p=t[s]&&t[s].length>0,h=!!(i.cp.previousState&&i.cp.previousState.answered&&i.cp.previousState.answered[s]);p&&(e("<div>",{class:"h5p-progressbar-part-has-task"}).appendTo(c),this.setTaskAnswered(s,h))}}},t.prototype.displaySlide=function(e){var t=this;this.cp.jumpToSlide(e,!1,(function(){var i=t.cp.getCurrentSlideIndex();t.updateSlideTitle(e,{isCurrent:!0}),t.updateSlideTitle(i,{isCurrent:!1}),t.toggleNextAndPreviousButtonDisabled(e)}))},t.prototype.createSlideTitle=function(e){var t=this.cp.slides[e];return t.keywords&&t.keywords.length>0?t.keywords[0].main:this.isSummarySlide(e)?this.cp.l10n.summary:this.cp.l10n.slide+" "+(e+1)},t.prototype.isSummarySlide=function(e){return!(void 0!==this.cp.editor||e!==this.cp.slides.length-1||!this.cp.showSummarySlide)},t.prototype.initFooter=function(){var t=this,i=this,n=this.cp.$footer,r=e("<div/>",{class:"h5p-footer-left-adjusted"}).appendTo(n),s=e("<div/>",{class:"h5p-footer-center-adjusted"}).appendTo(n),o=e("<div/>",{role:"toolbar",class:"h5p-footer-right-adjusted"}).appendTo(n);this.cp.$keywordsButton=e("<div/>",{class:"h5p-footer-button h5p-footer-toggle-keywords","aria-expanded":"false","aria-label":this.cp.l10n.showKeywords,role:"button",tabindex:"0",html:'<span class="h5p-icon-menu"></span><span class="current-slide-title"></span>'}).appendTo(r),H5P.Tooltip(this.cp.$keywordsButton.get(0)),f(this.cp.$keywordsButton,(function(e){i.cp.presentation.keywordListAlwaysShow||(i.cp.toggleKeywords(),e.stopPropagation())})),!this.cp.presentation.keywordListAlwaysShow&&this.cp.initKeywords||this.cp.$keywordsButton.hide(),this.cp.presentation.keywordListEnabled||this.cp.$keywordsWrapper.add(this.$keywordsButton).hide(),this.updateFooterKeyword(0),this.cp.$prevSlideButton=e("<div/>",{class:"h5p-footer-button h5p-footer-previous-slide","aria-label":this.cp.l10n.prevSlide,role:"button",tabindex:"-1","aria-disabled":"true"}).appendTo(s),new H5P.Tooltip(this.cp.$prevSlideButton.get(0),{position:"left"}),f(this.cp.$prevSlideButton,(function(){return t.cp.previousSlide(void 0,!1)}));var a=e("<div/>",{class:"h5p-footer-slide-count"}).appendTo(s);this.cp.$footerCurrentSlide=e("<div/>",{html:"1",class:"h5p-footer-slide-count-current",title:this.cp.l10n.currentSlide,"aria-hidden":"true"}).appendTo(a),this.cp.$footerCounter=e("<div/>",{class:"hidden-but-read",html:this.cp.l10n.slideCount.replace("@index","1").replace("@total",this.cp.slides.length.toString())}).appendTo(s),e("<div/>",{html:"/",class:"h5p-footer-slide-count-delimiter","aria-hidden":"true"}).appendTo(a),this.cp.$footerMaxSlide=e("<div/>",{html:this.cp.slides.length,class:"h5p-footer-slide-count-max",title:this.cp.l10n.lastSlide,"aria-hidden":"true"}).appendTo(a),this.cp.$nextSlideButton=e("<div/>",{class:"h5p-footer-button h5p-footer-next-slide","aria-label":this.cp.l10n.nextSlide,role:"button",tabindex:"0"}).appendTo(s),H5P.Tooltip(this.cp.$nextSlideButton.get(0),{position:"right"}),f(this.cp.$nextSlideButton,(function(){return t.cp.nextSlide(void 0,!1)})),void 0===this.cp.editor&&(this.cp.$exitSolutionModeButton=e("<div/>",{role:"button",class:"h5p-footer-exit-solution-mode","aria-label":this.cp.l10n.solutionModeTitle,tabindex:"0"}).appendTo(o),H5P.Tooltip(this.cp.$exitSolutionModeButton.get(0)),f(this.cp.$exitSolutionModeButton,(function(){return i.cp.jumpToSlide(i.cp.slides.length-1)})),this.cp.enablePrintButton&&y.supported()&&(this.cp.$printButton=e("<div/>",{class:"h5p-footer-button h5p-footer-print","aria-label":this.cp.l10n.printTitle,role:"button",tabindex:"0"}).appendTo(o),H5P.Tooltip(this.cp.$printButton.get(0)),f(this.cp.$printButton,(function(){return i.openPrintDialog()}))),H5P.fullscreenSupported&&(this.cp.$fullScreenButton=e("<div/>",{class:"h5p-footer-button h5p-footer-toggle-full-screen","aria-label":this.cp.l10n.fullscreen,role:"button",tabindex:"0"}),H5P.Tooltip(this.cp.$fullScreenButton.get(0),{position:"left"}),f(this.cp.$fullScreenButton,(function(){return i.cp.toggleFullScreen()})),this.cp.$fullScreenButton.appendTo(o))),this.cp.$exitSolutionModeText=e("<div/>",{html:"",class:"h5p-footer-exit-solution-mode-text"}).appendTo(this.cp.$exitSolutionModeButton)},t.prototype.openPrintDialog=function(){var t=this,i=e(".h5p-wrapper");y.showDialog(this.cp.l10n,i,(function(e){y.print(t.cp,i,e)})).children('[role="dialog"]').focus()},t.prototype.updateProgressBar=function(e,t,i){var n,r=this;for(n=0;n<r.cp.progressbarParts.length;n+=1)e+1>n?r.cp.progressbarParts[n].addClass("h5p-progressbar-part-show"):r.cp.progressbarParts[n].removeClass("h5p-progressbar-part-show");r.progresbarKeyboardControls.setTabbableByIndex(e),r.cp.progressbarParts[e].addClass("h5p-progressbar-part-selected").attr("aria-selected",!0).siblings().removeClass("h5p-progressbar-part-selected").attr("aria-selected",!1),void 0!==t?!i&&r.cp.editor:r.cp.progressbarParts.forEach((function(e,t){r.setTaskAnswered(t,!1)}))},t.prototype.setTaskAnswered=function(e,t){this.cp.progressbarParts[e].find(".h5p-progressbar-part-has-task").toggleClass("h5p-answered",t),this.updateSlideTitle(e,{state:t?z:N})},t.prototype.updateSlideTitle=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},i=t.state;this.setSlideTitle(e,{state:p(i,this.getAnsweredState(e))})},t.prototype.setSlideTitle=function(e,t){var i=t.state,n=void 0===i?W:i,r=this.cp.progressbarParts[e].find(".h5p-progressbar-part-title"),s=this.answeredLabels[n].replace("@slideName",this.createSlideTitle(e));r.html("".concat(s))},t.prototype.getAnsweredState=function(e){var t=this.cp.progressbarParts[e],i=this.slideHasInteraction(e),n=this.cp.slideHasAnsweredTask(e);return i?t.find(".h5p-is-correct").length>0?R:t.find(".h5p-is-wrong").length>0?Q:n?z:N:W},t.prototype.slideHasInteraction=function(e){return this.cp.progressbarParts[e].find(".h5p-progressbar-part-has-task").length>0},t.prototype.updateFooter=function(e){this.cp.$footerCurrentSlide.html(e+1),this.cp.$footerMaxSlide.html(this.cp.slides.length),this.cp.$footerCounter.html(this.cp.l10n.slideCount.replace("@index",(e+1).toString()).replace("@total",this.cp.slides.length.toString())),this.cp.isSolutionMode&&e===this.cp.slides.length-1?this.cp.$footer.addClass("summary-slide"):this.cp.$footer.removeClass("summary-slide"),this.toggleNextAndPreviousButtonDisabled(e),this.updateFooterKeyword(e)},t.prototype.toggleNextAndPreviousButtonDisabled=function(e){var t=this.cp.slides.length-1;this.cp.$prevSlideButton.attr("aria-disabled",(0===e).toString()),this.cp.$nextSlideButton.attr("aria-disabled",(e===t).toString()),this.cp.$prevSlideButton.attr("tabindex",0===e?"-1":"0"),this.cp.$nextSlideButton.attr("tabindex",e===t?"-1":"0")},t.prototype.updateFooterKeyword=function(e){var t=this.cp.slides[e],i="";t&&t.keywords&&t.keywords[0]&&(i=t.keywords[0].main),!this.cp.isEditor()&&this.cp.showSummarySlide&&e>=this.cp.slides.length-1&&(i=this.cp.l10n.summary),this.cp.$keywordsButton.children(".current-slide-title").html(p(i,""))},t}(H5P.jQuery);const G=U;var q=function(e){var t=e.presentation;t=n.extend(!0,{globalBackgroundSelector:{fillGlobalBackground:"",imageGlobalBackground:{}},slides:[{slideBackgroundSelector:{fillSlideBackground:"",imageSlideBackground:{}}}]},t);var i,r=function(t,i,n){var r=e.$slidesWrapper.children().filter(":not(.h5p-summary-slide)");void 0!==n&&(r=r.eq(n)),t&&""!==t?r.addClass("has-background").css("background-image","").css("background-color",t):i&&i.path&&r.addClass("has-background").css("background-color","").css("background-image","url("+H5P.getPath(i.path,e.contentId)+")")};i=t.globalBackgroundSelector,r(i.fillGlobalBackground,i.imageGlobalBackground),t.slides.forEach((function(e,t){var i=e.slideBackgroundSelector;i&&r(i.fillSlideBackground,i.imageSlideBackground,t)}))},X=function(e){return parseInt(e.dataset.index)},J=function(){function e(e){var t=this,i=e.l10n,n=e.currentIndex;this.l10n=i,this.state={currentIndex:p(n,0)},this.eventDispatcher=new r,this.controls=new D([new K]),this.controls.on("select",(function(e){t.onMenuItemSelect(X(e.element))})),this.controls.on("close",(function(){return t.eventDispatcher.trigger("close")})),this.menuElement=this.createMenuElement(),this.currentSlideMarkerElement=this.createCurrentSlideMarkerElement()}var t=e.prototype;return t.init=function(e){var t=this;return this.menuItemElements=e.map((function(e){return t.createMenuItemElement(e)})),this.menuItemElements.forEach((function(e){return t.menuElement.appendChild(e)})),this.menuItemElements.forEach((function(e){return t.controls.addElement(e)})),this.setCurrentSlideIndex(this.state.currentIndex),this.menuItemElements},t.on=function(e,t){this.eventDispatcher.on(e,t)},t.getElement=function(){return this.menuElement},t.removeAllMenuItemElements=function(){var e=this;this.menuItemElements.forEach((function(t){e.controls.removeElement(t),e.menuElement.removeChild(t)})),this.menuItemElements=[]},t.createMenuElement=function(){var e=this.menuElement=document.createElement("ol");return e.setAttribute("role","menu"),e.classList.add("list-unstyled"),e},t.createMenuItemElement=function(e){var t=this,i=document.createElement("li");return i.setAttribute("role","menuitem"),i.addEventListener("click",(function(e){t.onMenuItemSelect(X(e.currentTarget))})),this.applyConfigToMenuItemElement(i,e),i},t.applyConfigToMenuItemElement=function(e,t){e.innerHTML='<div class="h5p-keyword-subtitle">'.concat(t.subtitle,'</div><span class="h5p-keyword-title">').concat(t.title,"</span>"),e.dataset.index=t.index},t.onMenuItemSelect=function(e){this.setCurrentSlideIndex(e),this.eventDispatcher.trigger("select",{index:e})},t.setCurrentSlideIndex=function(e){var t=this.getElementByIndex(this.menuItemElements,e);t&&(this.state.currentIndex=e,this.updateCurrentlySelected(this.menuItemElements,this.state),this.controls.setTabbable(t))},t.updateCurrentlySelected=function(e,t){var i=this;e.forEach((function(e){var n=t.currentIndex===X(e);e.classList.toggle("h5p-current",n),n&&e.appendChild(i.currentSlideMarkerElement)}))},t.scrollToKeywords=function(e){var t=this.getFirstElementAfter(e);if(t){var i=n(this.menuElement),r=i.scrollTop()+n(t).position().top-8;l?i.scrollTop(r):i.stop().animate({scrollTop:r},250)}},t.getFirstElementAfter=function(e){return this.menuItemElements.filter((function(t){return X(t)>=e}))[0]},t.getElementByIndex=function(e,t){return e.filter((function(e){return X(e)===t}))[0]},t.createCurrentSlideMarkerElement=function(){var e=document.createElement("div");return e.classList.add("hidden-but-read"),e.innerHTML=this.l10n.currentSlide,e},e}(),V="specified",Y="next",_="previous",Z=function(){function e(e,t){var i=this,s=e.title,o=e.goToSlide,a=void 0===o?1:o,l=e.invisible,d=e.goToSlideType,c=void 0===d?V:d,p=t.l10n,h=t.currentIndex;this.eventDispatcher=new r;var u="h5p-press-to-go",m=0;if(l)s=void 0,m=-1;else{if(!s)switch(c){case V:s=p.goToSlide.replace(":num",a.toString());break;case Y:s=p.goToSlide.replace(":num",p.nextSlide);break;case _:s=p.goToSlide.replace(":num",p.prevSlide)}u+=" h5p-visible"}var v=a-1;c===Y?v=h+1:c===_&&(v=h-1),this.$element=n("<a/>",{href:"#",class:u,tabindex:m,title:s}),f(this.$element,(function(e){i.eventDispatcher.trigger("navigate",v),e.preventDefault()}))}var t=e.prototype;return t.attach=function(e){e.html("").addClass("h5p-go-to-slide").append(this.$element)},t.on=function(e,t){this.eventDispatcher.on(e,t)},e}();const ee=function(e){var t=this;if(void 0===e.action)t.instance=new Z(e,{l10n:t.parent.parent.l10n,currentIndex:t.parent.index}),t.parent.parent.isEditor()||t.instance.on("navigate",(function(e){var i=e.data;t.parent.parent.jumpToSlide(i)}));else{var i;i=t.parent.parent.isEditor()?H5P.jQuery.extend(!0,{},e.action,t.parent.parent.elementsOverride):H5P.jQuery.extend(!0,e.action,t.parent.parent.elementsOverride);var n=t.parent.parent.elementInstances[t.parent.index]?t.parent.parent.elementInstances[t.parent.index].length:0;t.parent.parent.previousState&&t.parent.parent.previousState.answers&&t.parent.parent.previousState.answers[t.parent.index]&&t.parent.parent.previousState.answers[t.parent.index][n]&&(i.userDatas={state:t.parent.parent.previousState.answers[t.parent.index][n]}),i.params=i.params||{},t.instance=H5P.newRunnable(i,t.parent.parent.contentId,void 0,!0,{parent:t.parent.parent}),void 0!==t.instance.preventResize&&(t.instance.preventResize=!0)}void 0===t.parent.parent.elementInstances[t.parent.index]?t.parent.parent.elementInstances[t.parent.index]=[t.instance]:t.parent.parent.elementInstances[t.parent.index].push(t.instance),void 0!==t.instance.showCPComments||t.instance.isTask||void 0===t.instance.isTask&&void 0!==t.instance.showSolutions?(t.instance.coursePresentationIndexOnSlide=t.parent.parent.elementInstances[t.parent.index].length-1,void 0===t.parent.parent.slidesWithSolutions[t.parent.index]&&(t.parent.parent.slidesWithSolutions[t.parent.index]=[]),t.parent.parent.slidesWithSolutions[t.parent.index].push(t.instance)):e.solution&&(void 0===t.parent.parent.showCommentsAfterSolution[t.parent.index]&&(t.parent.parent.showCommentsAfterSolution[t.parent.index]=[]),t.parent.parent.showCommentsAfterSolution[t.parent.index].push(t.instance)),void 0!==t.instance.exportAnswers&&t.instance.exportAnswers&&(t.parent.parent.hasAnswerElements=!0),t.parent.parent.isTask||t.parent.parent.hideSummarySlide||(t.instance.isTask||void 0===t.instance.isTask&&void 0!==t.instance.showSolutions)&&(t.parent.parent.isTask=!0)};function te(e,t){var i=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),i.push.apply(i,n)}return i}function ie(e){for(var t=1;t<arguments.length;t++){var i=null!=arguments[t]?arguments[t]:{};t%2?te(Object(i),!0).forEach((function(t){ne(e,t,i[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(i)):te(Object(i)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(i,t))}))}return e}function ne(e,t,i){return t in e?Object.defineProperty(e,t,{value:i,enumerable:!0,configurable:!0,writable:!0}):e[t]=i,e}function re(e){var i,n=this;t().call(n,ee,e.elements),n.getElement=function(){return i||(i=H5P.jQuery(re.createHTML(ie(ie({},e),{},{index:n.index})))),i},n.setCurrent=function(){this.parent.$current=i.addClass("h5p-current")},n.appendElements=function(){for(var t=0;t<n.children.length;t++)n.parent.attachElement(e.elements[t],n.children[t].instance,i,n.index);n.parent.elementsAttached[n.index]=!0,n.parent.trigger("domChanged",{$target:i,library:"CoursePresentation",key:"newSlide"},{bubbles:!0,external:!0})}}re.createHTML=function(e){return'<div role="tabpanel" id="slide-'+e.index+'" aria-labelledby="progressbar-part-'+e.index+'" class="h5p-slide"> <div role="document" tabindex="0" '+(void 0!==e.background?' style="background:'+e.background+'"':"")+"></div></div>"};const se=re;const oe=function(e,t){var i=new H5P.ConfirmationDialog(e).appendTo(document.body);return i.getElement().classList.add("h5p-cp-confirmation-dialog"),i.show(),i};function ae(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){var i=null==e?null:"undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(null==i)return;var n,r,s=[],o=!0,a=!1;try{for(i=i.call(e);!(o=(n=i.next()).done)&&(s.push(n.value),!t||s.length!==t);o=!0);}catch(e){a=!0,r=e}finally{try{o||null==i.return||i.return()}finally{if(a)throw r}}return s}(e,t)||function(e,t){if(!e)return;if("string"==typeof e)return le(e,t);var i=Object.prototype.toString.call(e).slice(8,-1);"Object"===i&&e.constructor&&(i=e.constructor.name);if("Map"===i||"Set"===i)return Array.from(e);if("Arguments"===i||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(i))return le(e,t)}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function le(e,t){(null==t||t>e.length)&&(t=e.length);for(var i=0,n=new Array(t);i<t;i++)n[i]=e[i];return n}function de(e){return de="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},de(e)}var ce=function(e,i,r){var s=this;this.presentation=e.presentation,this.slides=this.presentation.slides,this.contentId=i,this.elementInstances=[],this.elementsAttached=[],this.slidesWithSolutions=[],this.showCommentsAfterSolution=[],this.hasAnswerElements=!1,this.ignoreResize=!1,this.isTask=!1,this.standalone=!0,this.isReportingEnabled=!1,this.popups={},r.cpEditor&&(this.editor=r.cpEditor),r&&(this.previousState=r.previousState,this.standalone=r.standalone,this.isReportingEnabled=r.isReportingEnabled||r.isScoringEnabled),this.currentSlideIndex=this.previousState&&this.previousState.progress?this.previousState.progress:0,this.presentation.keywordListEnabled=void 0===e.presentation.keywordListEnabled||e.presentation.keywordListEnabled,this.l10n=n.extend({slide:"Slide",score:"Score",yourScore:"Your score",maxScore:"Max score",total:"Total",totalScore:"Total Score",showSolutions:"Show solutions",summary:"summary",retry:"Retry",exportAnswers:"Export text",close:"Close",hideKeywords:"Hide sidebar navigation menu",showKeywords:"Show sidebar navigation menu",fullscreen:"Fullscreen",exitFullscreen:"Exit fullscreen",prevSlide:"Previous slide",nextSlide:"Next slide",currentSlide:"Current slide",lastSlide:"Last slide",solutionModeTitle:"Exit solution mode",solutionModeText:"Solution Mode",summaryMultipleTaskText:"Multiple tasks",scoreMessage:"You achieved:",shareFacebook:"Share on Facebook",shareTwitter:"Share on Twitter",shareGoogle:"Share on Google+",goToSlide:"Go to slide :num",solutionsButtonTitle:"Show comments",printTitle:"Print",printIngress:"How would you like to print this presentation?",printAllSlides:"Print all slides",printCurrentSlide:"Print current slide",noTitle:"No title",accessibilitySlideNavigationExplanation:"Use left and right arrow to change slide in that direction whenever canvas is selected.",accessibilityProgressBarLabel:"Choose slide to display",containsNotCompleted:"@slideName contains not completed interaction",containsCompleted:"@slideName contains completed interaction",slideCount:"Slide @index of @total",accessibilityCanvasLabel:"Presentation canvas. Use left and right arrow to move between slides.",containsOnlyCorrect:"@slideName only has correct answers",containsIncorrectAnswers:"@slideName has incorrect answers",shareResult:"Share Result",accessibilityTotalScore:"You got @score of @maxScore points in total",accessibilityEnteredFullscreen:"Entered fullscreen",accessibilityExitedFullscreen:"Exited fullscreen",confirmDialogHeader:"Submit your answers",confirmDialogText:"This will submit your results, do you want to continue?",confirmDialogConfirmText:"Submit and see results",slideshowNavigationLabel:"Slideshow navigation"},void 0!==e.l10n?e.l10n:{}),e.override&&(this.activeSurface=!!e.override.activeSurface,this.hideSummarySlide=!!e.override.hideSummarySlide,this.enablePrintButton=!!e.override.enablePrintButton,this.showSummarySlideSolutionButton=void 0===e.override.summarySlideSolutionButton||e.override.summarySlideSolutionButton,this.showSummarySlideRetryButton=void 0===e.override.summarySlideRetryButton||e.override.summarySlideRetryButton,e.override.social&&(this.enableTwitterShare=!!e.override.social.showTwitterShare,this.enableFacebookShare=!!e.override.social.showFacebookShare,this.enableGoogleShare=!!e.override.social.showGoogleShare,this.twitterShareStatement=e.override.social.twitterShare.statement,this.twitterShareHashtags=e.override.social.twitterShare.hashtags,this.twitterShareUrl=e.override.social.twitterShare.url,this.facebookShareUrl=e.override.social.facebookShare.url,this.facebookShareQuote=e.override.social.facebookShare.quote,this.googleShareUrl=e.override.social.googleShareUrl)),this.keywordMenu=new J({l10n:this.l10n,currentIndex:void 0!==this.previousState?this.previousState.progress:0}),this.setElementsOverride(e.override),t().call(this,se,e.presentation.slides),this.on("resize",this.resize,this),this.on("printing",(function(e){s.ignoreResize=!e.data.finished,e.data.finished?s.resize():e.data.allSlides&&s.attachAllElements()}))};(ce.prototype=Object.create(t().prototype)).constructor=ce,ce.prototype.getCurrentState=function(){var e=this,t=this.previousState?this.previousState:{};t.progress=this.getCurrentSlideIndex(),t.answers||(t.answers=[]),t.answered=this.elementInstances.map((function(t,i){return e.slideHasAnsweredTask(i)}));for(var i=0;i<this.elementInstances.length;i++)if(this.elementInstances[i])for(var n=0;n<this.elementInstances[i].length;n++){var r=this.elementInstances[i][n];(r.getCurrentState instanceof Function||"function"==typeof r.getCurrentState)&&(t.answers[i]||(t.answers[i]=[]),t.answers[i][n]=r.getCurrentState())}return t},ce.prototype.slideHasAnsweredTask=function(e){return(this.slidesWithSolutions[e]||[]).filter((function(e){return a(e.getAnswerGiven)})).some((function(e){return e.getAnswerGiven()}))},ce.prototype.attach=function(e){var t=this,i=this;void 0!==this.isRoot&&this.isRoot()&&this.setActivityStarted();var r='<div class="h5p-keymap-explanation hidden-but-read">'+this.l10n.accessibilitySlideNavigationExplanation+'</div><div class="h5p-fullscreen-announcer hidden-but-read" aria-live="polite"></div><div class="h5p-wrapper" tabindex="0" role="region" aria-roledescription="carousel" aria-label="'+this.l10n.accessibilityCanvasLabel+'">  <div class="h5p-current-slide-announcer hidden-but-read" aria-live="polite"></div>  <div tabindex="-1"></div>  <div class="h5p-box-wrapper">    <div class="h5p-presentation-wrapper">      <div class="h5p-keywords-wrapper"></div>     <div class="h5p-slides-wrapper"></div>    </div>  </div>  <nav class="h5p-cp-navigation" aria-label="'+this.l10n.slideshowNavigationLabel+'">    <div class="h5p-progressbar" role="tablist" aria-label="'+this.l10n.accessibilityProgressBarLabel+'"></div>  </nav>  <div class="h5p-footer"></div></div>';e.attr("role","application").addClass("h5p-course-presentation").html(r),this.$container=e,this.$slideAnnouncer=e.find(".h5p-current-slide-announcer"),this.$fullscreenAnnouncer=e.find(".h5p-fullscreen-announcer"),this.$slideTop=this.$slideAnnouncer.next(),this.$wrapper=e.children(".h5p-wrapper"),this.activeSurface&&this.$wrapper.addClass("h5p-course-presentation-active-surface"),this.$wrapper.focus((function(){i.initKeyEvents()})).blur((function(){void 0!==i.keydown&&(H5P.jQuery("body").unbind("keydown",i.keydown),delete i.keydown)})).click((function(e){var t=H5P.jQuery(e.target),n=i.belongsToTagName(e.target,["input","textarea","a","button"],e.currentTarget),r=-1!==e.target.tabIndex,s=t.closest(".h5p-popup-container"),o=0!==s.length;if(!n&&!r&&!i.editor)if(o){var a=t.closest("[tabindex]");1===a.closest(".h5p-popup-container").length?a.focus():s.find(".h5p-close-popup").focus()}else i.$wrapper.focus();i.presentation.keywordListEnabled&&!i.presentation.keywordListAlwaysShow&&i.presentation.keywordListAutoHide&&!t.is("textarea, .h5p-icon-pencil, span")&&i.hideKeywords()})),this.on("exitFullScreen",(function(){t.$footer.removeClass("footer-full-screen"),t.$fullScreenButton.attr("aria-label",t.l10n.fullscreen),t.$fullscreenAnnouncer.html(t.l10n.accessibilityExitedFullscreen)})),this.on("enterFullScreen",(function(){t.$fullscreenAnnouncer.html(t.l10n.accessibilityEnteredFullscreen)}));var s=parseInt(this.$wrapper.css("width"));this.width=0!==s?s:640;var o=parseInt(this.$wrapper.css("height"));this.height=0!==o?o:400,this.ratio=16/9,this.fontSize=16,this.$boxWrapper=this.$wrapper.children(".h5p-box-wrapper");var a,l=this.$boxWrapper.children(".h5p-presentation-wrapper");if(this.$slidesWrapper=l.children(".h5p-slides-wrapper"),this.$keywordsWrapper=l.children(".h5p-keywords-wrapper"),this.$progressbar=this.$wrapper.find(".h5p-progressbar"),this.$footer=this.$wrapper.children(".h5p-footer"),this.initKeywords=void 0===this.presentation.keywordListEnabled||!0===this.presentation.keywordListEnabled||void 0!==this.editor,this.activeSurface&&void 0===this.editor&&(this.initKeywords=!1,this.$boxWrapper.css("height","100%")),this.isSolutionMode=!1,this.createSlides(),this.elementsAttached[this.currentSlideIndex]=!0,this.showSummarySlide=!1,this.hideSummarySlide?this.showSummarySlide=!this.hideSummarySlide:this.slidesWithSolutions.forEach((function(e){i.showSummarySlide=e.length})),void 0===this.editor&&(this.showSummarySlide||this.hasAnswerElements)){var d={elements:[],keywords:[]};this.slides.push(d),(a=H5P.jQuery(se.createHTML(d)).appendTo(this.$slidesWrapper)).addClass("h5p-summary-slide"),this.isCurrentSlide(this.slides.length-1)&&(this.$current=a)}var c=this.getKeywordMenuConfig();c.length>0||this.isEditor()?(this.keywordMenu.init(c),this.keywordMenu.on("select",(function(e){return t.keywordClick(e.data.index)})),this.keywordMenu.on("close",(function(){return t.hideKeywords()})),this.keywordMenu.on("select",(function(){t.$currentKeyword=t.$keywords.children(".h5p-current")})),this.$keywords=n(this.keywordMenu.getElement()).appendTo(this.$keywordsWrapper),this.$currentKeyword=this.$keywords.children(".h5p-current"),void 0!==this.presentation.keywordListOpacity&&this.setKeywordsOpacity(this.presentation.keywordListOpacity),this.presentation.keywordListAlwaysShow&&this.showKeywords()):(this.$keywordsWrapper.remove(),this.initKeywords=!1),void 0===this.editor&&this.activeSurface?(this.$progressbar.add(this.$footer).remove(),H5P.fullscreenSupported&&(this.$fullScreenButton=H5P.jQuery("<div/>",{class:"h5p-toggle-full-screen","aria-label":this.l10n.fullscreen,role:"button",tabindex:0,appendTo:this.$wrapper}),H5P.Tooltip(this.$fullScreenButton.get(0),{position:"left"}),f(this.$fullScreenButton,(function(){return i.toggleFullScreen()})))):(this.initTouchEvents(),this.navigationLine=new G(this),this.previousState&&this.previousState.progress||this.setSlideNumberAnnouncer(0,!1),this.summarySlideObject=new g(this,a)),new q(this),this.previousState&&this.previousState.progress&&this.jumpToSlide(this.previousState.progress,!1,null,!1,!0)},ce.prototype.belongsToTagName=function(e,t,i){if(!e)return!1;i=i||document.body,"string"==typeof t&&(t=[t]),t=t.map((function(e){return e.toLowerCase()}));var n=e.tagName.toLowerCase();return-1!==t.indexOf(n)||i!==e&&this.belongsToTagName(e.parentNode,t,i)},ce.prototype.updateKeywordMenuFromSlides=function(){this.keywordMenu.removeAllMenuItemElements();var e=this.getKeywordMenuConfig();return n(this.keywordMenu.init(e))},ce.prototype.getKeywordMenuConfig=function(){var e=this;return this.slides.map((function(t,i){return{title:e.createSlideTitle(t),subtitle:"".concat(e.l10n.slide," ").concat(i+1),index:i}})).filter((function(e){return null!==e.title}))},ce.prototype.createSlideTitle=function(e){var t=this.isEditor()?this.l10n.noTitle:null;return this.hasKeywords(e)?e.keywords[0].main:t},ce.prototype.isEditor=function(){return void 0!==this.editor},ce.prototype.hasKeywords=function(e){return void 0!==e.keywords&&e.keywords.length>0},ce.prototype.createSlides=function(){for(var e=this,t=0;t<e.children.length;t++){var i=t===e.currentSlideIndex;e.children[t].getElement().appendTo(e.$slidesWrapper),i&&e.children[t].setCurrent(),(e.isEditor()||0===t||1===t||i)&&e.children[t].appendElements()}},ce.prototype.hasScoreData=function(e){return"undefined"!==de(e)&&"function"==typeof e.getScore&&"function"==typeof e.getMaxScore},ce.prototype.getScore=function(){var e=this;return o(e.slidesWithSolutions).reduce((function(t,i){return t+(e.hasScoreData(i)?i.getScore():0)}),0)},ce.prototype.getMaxScore=function(){var e=this;return o(e.slidesWithSolutions).reduce((function(t,i){return t+(e.hasScoreData(i)?i.getMaxScore():0)}),0)},ce.prototype.setProgressBarFeedback=function(e){var t=this;void 0!==e&&e?e.forEach((function(e){var i=t.progressbarParts[e.slide-1].find(".h5p-progressbar-part-has-task");if(i.hasClass("h5p-answered")){var n=e.score>=e.maxScore;i.addClass(n?"h5p-is-correct":"h5p-is-wrong"),t.navigationLine.updateSlideTitle(e.slide-1)}})):this.progressbarParts.forEach((function(e){e.find(".h5p-progressbar-part-has-task").removeClass("h5p-is-correct").removeClass("h5p-is-wrong")}))},ce.prototype.toggleKeywords=function(){this[this.$keywordsWrapper.hasClass("h5p-open")?"hideKeywords":"showKeywords"]()},ce.prototype.hideKeywords=function(){this.$keywordsWrapper.hasClass("h5p-open")&&(void 0!==this.$keywordsButton&&(this.$keywordsButton.attr("aria-label",this.l10n.showKeywords),this.$keywordsButton.attr("aria-expanded","false"),this.$keywordsButton.focus()),this.$keywordsWrapper.removeClass("h5p-open"))},ce.prototype.showKeywords=function(){this.$keywordsWrapper.hasClass("h5p-open")||(void 0!==this.$keywordsButton&&(this.$keywordsButton.attr("aria-label",this.l10n.hideKeywords),this.$keywordsButton.attr("aria-expanded","true")),this.$keywordsWrapper.addClass("h5p-open"),this.presentation.keywordListAlwaysShow||this.$keywordsWrapper.find('li[tabindex="0"]').focus())},ce.prototype.setKeywordsOpacity=function(e){if(""!==this.$keywordsWrapper.css("background-color")){var t=ae(this.$keywordsWrapper.css("background-color").match(/\d+/g),3),i=t[0],n=t[1],r=t[2];this.$keywordsWrapper.css("background-color","rgba(".concat(i,", ").concat(n,", ").concat(r,", ").concat(e/100,")"))}},ce.prototype.fitCT=function(){void 0===this.editor&&this.$current.find(".h5p-ct").each((function(){for(var e=100,t=H5P.jQuery(this),i=t.parent().height();t.outerHeight()>i&&(e--,t.css({fontSize:e+"%",lineHeight:e+65+"%"}),!(e<0)););}))},ce.prototype.resize=function(){var e=this.$container.hasClass("h5p-fullscreen")||this.$container.hasClass("h5p-semi-fullscreen");if(!this.ignoreResize){this.$wrapper.css("width","auto");var t=this.$container.width(),i={};if(e){var n=this.$container.height();t/n>this.ratio&&(t=n*this.ratio,i.width=t+"px")}var r=t/this.width;i.height=t/this.ratio+"px",i.fontSize=this.fontSize*r+"px",void 0!==this.editor&&this.editor.setContainerEm(this.fontSize*r*.75),this.$wrapper.css(i),this.swipeThreshold=100*r;var s=this.elementInstances[this.$current.index()];if(void 0!==s)for(var o=this.slides[this.$current.index()].elements,a=0;a<s.length;a++){var l=s[a];void 0!==l.preventResize&&!1!==l.preventResize||void 0===l.$||o[a].displayAsButton||H5P.trigger(l,"resize")}this.fitCT()}},ce.prototype.toggleFullScreen=function(){H5P.isFullscreen||this.$container.hasClass("h5p-fullscreen")||this.$container.hasClass("h5p-semi-fullscreen")?void 0!==H5P.exitFullScreen&&void 0!==H5P.fullScreenBrowserPrefix?H5P.exitFullScreen():void 0===H5P.fullScreenBrowserPrefix?H5P.jQuery(".h5p-disable-fullscreen").click():""===H5P.fullScreenBrowserPrefix?window.top.document.exitFullScreen():"ms"===H5P.fullScreenBrowserPrefix?window.top.document.msExitFullscreen():window.top.document[H5P.fullScreenBrowserPrefix+"CancelFullScreen"]():(this.$footer.addClass("footer-full-screen"),this.$fullScreenButton.attr("aria-label",this.l10n.exitFullscreen),H5P.fullScreen(this.$container,this),void 0===H5P.fullScreenBrowserPrefix&&H5P.jQuery(".h5p-disable-fullscreen").hide())},ce.prototype.focus=function(){this.$wrapper.focus()},ce.prototype.keywordClick=function(e){this.shouldHideKeywordsAfterSelect()&&this.hideKeywords(),this.jumpToSlide(e,!0)},ce.prototype.shouldHideKeywordsAfterSelect=function(){return this.presentation.keywordListEnabled&&!this.presentation.keywordListAlwaysShow&&this.presentation.keywordListAutoHide&&void 0===this.editor},ce.prototype.setElementsOverride=function(e){this.elementsOverride={params:{}},e&&(this.elementsOverride.params.behaviour={},e.showSolutionButton&&(this.elementsOverride.params.behaviour.enableSolutionsButton="on"===e.showSolutionButton),e.retryButton&&(this.elementsOverride.params.behaviour.enableRetry="on"===e.retryButton))},ce.prototype.attachElements=function(e,t){if(void 0===this.elementsAttached[t]){var i=this.slides[t],n=this.elementInstances[t];if(void 0!==i.elements)for(var r=0;r<i.elements.length;r++)this.attachElement(i.elements[r],n[r],e,t);this.trigger("domChanged",{$target:e,library:"CoursePresentation",key:"newSlide"},{bubbles:!0,external:!0}),this.elementsAttached[t]=!0}},ce.prototype.attachElement=function(e,t,i,n){var r=void 0!==e.displayAsButton&&e.displayAsButton,s=void 0!==e.buttonSize?"h5p-element-button-"+e.buttonSize:"",o="h5p-element"+(r?" h5p-element-button-wrapper":"")+(s.length?" "+s:""),a=H5P.jQuery("<div>",{class:o}).css({left:e.x+"%",top:e.y+"%",width:e.width+"%",height:e.height+"%"}).appendTo(i.children('[role="document"]').first()),l=void 0===e.backgroundOpacity||0===e.backgroundOpacity;if(a.toggleClass("h5p-transparent",l),r){this.createInteractionButton(e,t).appendTo(a)}else{var d=e.action&&e.action.library?this.getLibraryTypePmz(e.action.library):"other",c=H5P.jQuery("<div>",{class:"h5p-element-outer ".concat(d,"-outer-element")}).css({background:"rgba(255,255,255,"+(void 0===e.backgroundOpacity?0:e.backgroundOpacity/100)+")"}).appendTo(a),p=H5P.jQuery("<div>",{class:"h5p-element-inner"}).appendTo(c);if(t.on("set-size",(function(e){for(var t in e.data)a.get(0).style[t]=e.data[t]})),t.attach(p),void 0!==e.action&&"H5P.InteractiveVideo"===e.action.library.substr(0,20)){var h=function(){t.$container.addClass("h5p-fullscreen"),t.controls.$fullscreen&&t.controls.$fullscreen.remove(),t.hasFullScreen=!0,t.controls.$play.hasClass("h5p-pause")?t.$controls.addClass("h5p-autohide"):t.enableAutoHide()};void 0!==t.controls?h():t.on("controls",h)}this.setOverflowTabIndex()}return void 0!==this.editor?this.editor.processElement(e,a,n,t):(e.solution&&this.addElementSolutionButton(e,t,a),this.hasAnswerElements=this.hasAnswerElements||void 0!==t.exportAnswers),a},ce.prototype.disableTabIndexes=function(){var e=this.$container.find(".h5p-popup-container");this.$tabbables=this.$container.find("a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable]").filter((function(){var t=n(this),i=n.contains(e.get(0),t.get(0));if(t.data("tabindex"))return!0;if(!i){var r=t.attr("tabindex");return t.data("tabindex",r),t.attr("tabindex","-1"),!0}return!1}))},ce.prototype.restoreTabIndexes=function(){this.$tabbables&&this.$tabbables.each((function(){var e=n(this),t=e.data("tabindex");e.hasClass("ui-slider-handle")?(e.attr("tabindex",0),e.removeData("tabindex")):void 0!==t?(e.attr("tabindex",t),e.removeData("tabindex")):e.removeAttr("tabindex")}))},ce.prototype.createInteractionButton=function(e,t){var i=this,r=e.action.metadata?e.action.metadata.title:"";""===r&&(r=e.action.params&&e.action.params.contentName||e.action.library.split(" ")[0].split(".")[1]);var s=this.getLibraryTypePmz(e.action.library),o=n("<div>",{role:"button",tabindex:0,"aria-label":r,"aria-popup":!0,"aria-expanded":!1,class:"h5p-element-button h5p-element-button-".concat(e.buttonSize," ").concat(s,"-button")}),a=n('<div class="h5p-button-element"></div>');t.attach(a);var l="h5p-advancedtext"===s?{x:e.x,y:e.y}:null;return f(o,(function(){var e;o.attr("aria-expanded","true"),i.showInteractionPopup(t,o,a,s,(e=o,function(){return e.attr("aria-expanded","false")}),l)})),void 0!==e.action&&"H5P.InteractiveVideo"===e.action.library.substr(0,20)&&t.on("controls",(function(){t.controls.$fullscreen&&t.controls.$fullscreen.remove()})),o},ce.prototype.showInteractionPopup=function(e,t,i,n,r){var s=this,o=arguments.length>5&&void 0!==arguments[5]?arguments[5]:null,l=function(){e.trigger("resize")};this.isEditor()||(this.on("exitFullScreen",l),this.showPopup({popupContent:i,$focusOnClose:t,parentPosition:o,remove:function(){var e=arguments.length>0&&void 0!==arguments[0]&&arguments[0];e||i.detach(),s.off("exitFullScreen",l),r()},classes:n,instance:e,keepInDOM:"h5p-interactivevideo"===n}),H5P.trigger(e,"resize"),"h5p-image"===n&&this.resizePopupImage(i),setTimeout((function(){var e=i.find(":input").add(i.find("[tabindex]"));e.length?e[0].focus():(i.attr("tabindex",0),i.focus())}),200),a(e.setActivityStarted)&&a(e.getScore)&&e.setActivityStarted())},ce.prototype.getLibraryTypePmz=function(e){return(t=e.split(" ")[0],t.replace(/[\W]/g,"-")).toLowerCase();var t},ce.prototype.resizePopupImage=function(e){var t=Number(e.css("fontSize").replace("px","")),i=e.find("img"),n=function(i,n){if(!(n/t<18.5)){var r=i/n;n=18.5*t,e.css({width:n*r,height:n})}};i.height()?n(i.width(),i.height()):i.one("load",(function(){n(this.width,this.height)}))},ce.prototype.addElementSolutionButton=function(e,t,i){var r=this;t.showCPComments=function(){if(0===i.children(".h5p-element-solution").length&&(o=e.solution,v.html(o).text().trim()).length>0){var t=n("<div/>",{role:"button",tabindex:0,title:r.l10n.solutionsButtonTitle,"aria-haspopup":"dialog","aria-expanded":!1,class:"h5p-element-solution"}).append('<span class="joubel-icon-comment-normal"><span class="h5p-icon-shadow"></span><span class="h5p-icon-speech-bubble"></span><span class="h5p-icon-question"></span></span>').appendTo(i),s={x:e.x,y:e.y};e.displayAsButton||(s.x+=e.width-4,s.y+=e.height-12),f(t,(function(i){r.showPopup({popupContent:e.solution,$focusOnClose:t,parentPosition:s,updateAriaExpanded:!0}),t.attr("aria-expanded",!0),i.stopPropagation()}))}var o},void 0!==e.alwaysDisplayComments&&e.alwaysDisplayComments&&t.showCPComments()},ce.prototype.showPopup=function(e){var t,i=this,r=e.popupContent,s=e.$focusOnClose,o=e.parentPosition,a=void 0===o?null:o,l=e.remove,d=e.classes,c=void 0===d?"h5p-popup-comment-field":d,p=e.instance,h=e.keepInDOM,m=void 0!==h&&h,v=e.updateAriaExpanded,g=this;this.popupId=void 0===this.popupId?0:this.popupId+1;var b,y=function(e){t?t=!1:(g.restoreTabIndexes(),s.focus(),v&&s.attr("aria-expanded",!1),void 0!==l&&setTimeout((function(){l(m)}),100),e.preventDefault(),b.addClass("h5p-animate"),b.find(".h5p-popup-container").addClass("h5p-animate"),setTimeout((function(){m?b.hide():b.remove()}),100))};if(m&&p&&g.popups[p.subContentId]&&(b=g.popups[p.subContentId]),void 0===b){var S=(b=n('<div class="h5p-popup-overlay '+c+'"><div class="h5p-popup-container" role="dialog"aria-modal="true" aria-live="true" aria-labelledby="popup-title-'+this.popupId+'"> <div role="button" tabindex="0" class="h5p-close-popup" title="'+this.l10n.close+'"></div><div class="h5p-popup-wrapper" role="document"></div></div></div>')).find(".h5p-popup-wrapper");r instanceof H5P.jQuery?S.append(r):S.html(r);var w="";S.children().each((function(e,t){t.setAttribute("id","popup-content-"+i.popupId+"-"+e),w+="popup-content-"+i.popupId+"-"+e+" "})),b.find(".h5p-popup-container").attr("aria-describedby",w),p&&p.subContentId&&(g.popups[p.subContentId]=b)}var x=b.find(".h5p-popup-container");return function(e,t,n){if(n){t.css({visibility:"hidden"}),e.prependTo(i.$wrapper);var r=t.height(),s=t.width(),o=e.height(),a=s*(100/e.width()),l=r*(100/o);if(a>50&&l>50)e.detach();else{a>l&&l<45&&(a=Math.sqrt(a*l),t.css({width:a+"%"}));a>90?a=90:a<22&&(a=22);var d=100-a-5,c=n.x;n.x>d?c=d:n.x<5&&(c=5);var p=100-(l=t.height()*(100/o))-10,h=n.y;n.y>p?h=p:n.y<10&&(h=10),e.detach(),t.css({left:c+"%",top:h+"%"})}}}(b,x,a),b.addClass("h5p-animate"),x.css({visibility:""}).addClass("h5p-animate"),0===b.parent().length?b.prependTo(this.$wrapper):b.show(),b.removeClass("h5p-animate").click(y).find(".h5p-popup-container").removeClass("h5p-animate").click((function(){t=!0})).keydown((function(e){e.which===u&&y(e)})).find(".h5p-close-popup").focus(),this.disableTabIndexes(),f(b.find(".h5p-close-popup"),(function(e){return y(e)})),b},ce.prototype.checkForSolutions=function(e){return void 0!==e.showSolutions||void 0!==e.showCPComments},ce.prototype.initKeyEvents=function(){if(void 0===this.keydown&&!this.activeSurface){var e=this,t=!1;this.keydown=function(i){t||((37!==i.keyCode&&33!==i.keyCode||!e.previousSlide(void 0,!1))&&(39!==i.keyCode&&34!==i.keyCode||!e.nextSlide(void 0,!1))||(i.preventDefault(),t=!0),t&&setTimeout((function(){t=!1}),300))},H5P.jQuery("body").keydown(this.keydown)}},ce.prototype.initTouchEvents=function(){var e,t,i,n,r,s,o=this,a=!1,l=!1,d=function(e){return{"-webkit-transform":e,"-moz-transform":e,"-ms-transform":e,transform:e}},c=d("");this.$slidesWrapper.bind("touchstart",(function(d){l=!1,i=e=d.originalEvent.touches[0].pageX,t=d.originalEvent.touches[0].pageY;var c=o.$slidesWrapper.width();n=0===o.currentSlideIndex?0:-c,r=o.currentSlideIndex+1>=o.slides.length?0:c,s=null,a=!0})).bind("touchmove",(function(c){var p=c.originalEvent.touches;a&&(o.$current.prev().addClass("h5p-touch-move"),o.$current.next().addClass("h5p-touch-move"),a=!1),i=p[0].pageX;var h=e-i;null===s&&(s=Math.abs(t-c.originalEvent.touches[0].pageY)>Math.abs(h)),1!==p.length||s||(c.preventDefault(),l||(h<0?o.$current.prev().css(d("translateX("+(n-h)+"px")):o.$current.next().css(d("translateX("+(r-h)+"px)")),o.$current.css(d("translateX("+-h+"px)"))))})).bind("touchend",(function(){if(!s){var t=e-i;if(t>o.swipeThreshold&&o.nextSlide(void 0,!1)||t<-o.swipeThreshold&&o.previousSlide(void 0,!1))return}o.$slidesWrapper.children().css(c).removeClass("h5p-touch-move")}))},ce.prototype.updateTouchPopup=function(e,t,i,n){if(arguments.length<=0)void 0!==this.touchPopup&&this.touchPopup.remove();else{var r="",s=.15;if(void 0!==this.$keywords&&void 0!==this.$keywords.children(":eq("+t+")").find("span").html())r+=this.$keywords.children(":eq("+t+")").find("span").html();else{var o=t+1;r+=this.l10n.slide+" "+o}void 0===this.editor&&t>=this.slides.length-1&&(r=this.l10n.showSolutions),void 0===this.touchPopup?this.touchPopup=H5P.jQuery("<div/>",{class:"h5p-touch-popup"}).insertAfter(e):this.touchPopup.insertAfter(e),n-e.parent().height()*s<0?n=0:n-=e.parent().height()*s,this.touchPopup.css({"max-width":e.width()-i,left:i,top:n}),this.touchPopup.html(r)}},ce.prototype.previousSlide=function(e){var t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1],i=this.$current.prev();return!!i.length&&(t?this.processJumpToSlide(i.index(),e,!1):this.jumpToSlide(i.index(),e,null,!1))},ce.prototype.nextSlide=function(e){var t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1],i=this.$current.next();return!!i.length&&(t?this.processJumpToSlide(i.index(),e,!1):this.jumpToSlide(i.index(),e,null,!1))},ce.prototype.isCurrentSlide=function(e){return this.currentSlideIndex===e},ce.prototype.getCurrentSlideIndex=function(){return this.currentSlideIndex},ce.prototype.attachAllElements=function(){for(var e=this.$slidesWrapper.children(),t=0;t<this.slides.length;t++)this.attachElements(e.eq(t),t);void 0!==this.summarySlideObject&&this.summarySlideObject.updateSummarySlide(this.slides.length-1,!0)},ce.prototype.processJumpToSlide=function(e,t,i){var n=this;if(void 0===this.editor&&this.contentId){var r=this.createXAPIEventTemplate("progressed");r.data.statement.object.definition.extensions["http://id.tincanapi.com/extension/ending-point"]=e+1,this.trigger(r)}if(!this.$current.hasClass("h5p-animate")){var s=this.$current.addClass("h5p-animate"),o=n.$slidesWrapper.children(),a=o.filter(":lt("+e+")");this.$current=o.eq(e).addClass("h5p-animate");var l=this.currentSlideIndex;this.currentSlideIndex=e,this.attachElements(this.$current,e);var d=this.$current.next();return d.length&&this.attachElements(d,e+1),this.setOverflowTabIndex(),setTimeout((function(){s.removeClass("h5p-current"),o.css({"-webkit-transform":"","-moz-transform":"","-ms-transform":"",transform:""}).removeClass("h5p-touch-move").removeClass("h5p-previous"),a.addClass("h5p-previous"),n.$current.addClass("h5p-current"),n.trigger("changedSlide",n.$current.index())}),1),setTimeout((function(){if(n.$slidesWrapper.children().removeClass("h5p-animate"),void 0===n.editor){var e=n.elementInstances[n.currentSlideIndex],t=n.slides[n.currentSlideIndex].elements;if(void 0!==e)for(var i=0;i<e.length;i++)t[i].displayAsButton||"function"!=typeof e[i].setActivityStarted||"function"!=typeof e[i].getScore||e[i].setActivityStarted()}}),250),void 0!==this.$keywords&&(this.keywordMenu.setCurrentSlideIndex(e),this.$currentKeyword=this.$keywords.find(".h5p-current"),t||this.keywordMenu.scrollToKeywords(e)),n.presentation.keywordListEnabled&&n.presentation.keywordListAlwaysShow&&n.showKeywords(),n.navigationLine&&(n.navigationLine.updateProgressBar(e,l,this.isSolutionMode),n.navigationLine.updateFooter(e),this.setSlideNumberAnnouncer(e,i)),n.summarySlideObject&&n.summarySlideObject.updateSummarySlide(e,!0),void 0!==this.editor&&void 0!==this.editor.dnb&&(this.editor.dnb.setContainer(this.$current),this.editor.dnb.blurAll()),this.trigger("resize"),this.fitCT(),!0}},ce.prototype.jumpToSlide=function(e){var t=this,i=arguments.length>1&&void 0!==arguments[1]&&arguments[1],n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null,r=arguments.length>3&&void 0!==arguments[3]&&arguments[3],s=arguments.length>4&&void 0!==arguments[4]&&arguments[4];if(this.standalone&&this.showSummarySlide&&e===this.slides.length-1&&!this.isSolutionMode&&this.isReportingEnabled&&!s){if(this.currentSlideIndex===this.slides.length-1)return!1;var o=oe({headerText:this.l10n.confirmDialogHeader,dialogText:this.l10n.confirmDialogText,confirmText:this.l10n.confirmDialogConfirmationText});o.on("canceled",(function(){return!1})),o.on("confirmed",(function(){t.processJumpToSlide(e,i,r),n&&n()}))}else this.processJumpToSlide(e,i,r),n&&n()},ce.prototype.setOverflowTabIndex=function(){void 0!==this.$current&&this.$current.find(".h5p-element-inner").each((function(){var e,t=n(this);this.classList.contains("h5p-table")&&(e=t.find(".h5p-table").outerHeight());var i=t.closest(".h5p-element-outer").innerHeight();void 0!==e&&null!==i&&e>i&&t.attr("tabindex",0)}))},ce.prototype.setSlideNumberAnnouncer=function(e){var t=arguments.length>1&&void 0!==arguments[1]&&arguments[1],i="";if(!this.navigationLine)return i;var n=this.slides[e],r=n.keywords&&n.keywords.length>0;r&&!this.navigationLine.isSummarySlide(e)&&(i+=this.l10n.slide+" "+(e+1)+": "),i+=this.navigationLine.createSlideTitle(e),this.$slideAnnouncer.html(i),t&&this.$slideTop.focus()},ce.prototype.resetTask=function(){this.summarySlideObject.toggleSolutionMode(!1);for(var e=0;e<this.slidesWithSolutions.length;e++)if(void 0!==this.slidesWithSolutions[e])for(var t=0;t<this.slidesWithSolutions[e].length;t++){var i=this.slidesWithSolutions[e][t];i.resetTask&&i.resetTask()}this.navigationLine.updateProgressBar(0),this.jumpToSlide(0,!1),this.$container.find(".h5p-popup-overlay").remove()},ce.prototype.showSolutions=function(){for(var e=!1,t=[],i=!1,n=0;n<this.slidesWithSolutions.length;n++){if(void 0!==this.slidesWithSolutions[n]){this.elementsAttached[n]||this.attachElements(this.$slidesWrapper.children(":eq("+n+")"),n),e||(this.jumpToSlide(n,!1),e=!0);for(var r=0,s=0,o=[],a=0;a<this.slidesWithSolutions[n].length;a++){var l=this.slidesWithSolutions[n][a];void 0!==l.addSolutionButton&&l.addSolutionButton(),l.showSolutions&&l.showSolutions(),l.showCPComments&&l.showCPComments(),void 0!==l.getMaxScore&&(s+=l.getMaxScore(),r+=l.getScore(),i=!0,o.push(l.coursePresentationIndexOnSlide))}t.push({indexes:o,slide:n+1,score:r,maxScore:s})}if(this.showCommentsAfterSolution[n])for(var d=0;d<this.showCommentsAfterSolution[n].length;d++)"function"==typeof this.showCommentsAfterSolution[n][d].showCPComments&&this.showCommentsAfterSolution[n][d].showCPComments()}if(i)return t},ce.prototype.getSlideScores=function(e){for(var t=!0===e,i=[],n=!1,r=0;r<this.slidesWithSolutions.length;r++)if(void 0!==this.slidesWithSolutions[r]){this.elementsAttached[r]||this.attachElements(this.$slidesWrapper.children(":eq("+r+")"),r),t||(this.jumpToSlide(r,!1),t=!0);for(var s=0,o=0,a=[],l=0;l<this.slidesWithSolutions[r].length;l++){var d=this.slidesWithSolutions[r][l];void 0!==d.getMaxScore&&(o+=d.getMaxScore(),s+=d.getScore(),n=!0,a.push(d.coursePresentationIndexOnSlide))}i.push({indexes:a,slide:r+1,score:s,maxScore:o})}if(n)return i},ce.prototype.getCopyrights=function(){var e,t=new H5P.ContentCopyrights;if(this.presentation&&this.presentation.globalBackgroundSelector&&this.presentation.globalBackgroundSelector.imageGlobalBackground){var i=this.presentation.globalBackgroundSelector.imageGlobalBackground,n=new H5P.MediaCopyright(i.copyright);n.setThumbnail(new H5P.Thumbnail(H5P.getPath(i.path,this.contentId),i.width,i.height)),t.addMedia(n)}for(var r=0;r<this.slides.length;r++){var s=new H5P.ContentCopyrights;if(s.setLabel(this.l10n.slide+" "+(r+1)),this.slides[r]&&this.slides[r].slideBackgroundSelector&&this.slides[r].slideBackgroundSelector.imageSlideBackground){var o=this.slides[r].slideBackgroundSelector.imageSlideBackground,a=new H5P.MediaCopyright(o.copyright);a.setThumbnail(new H5P.Thumbnail(H5P.getPath(o.path,this.contentId),o.width,o.height)),s.addMedia(a)}if(void 0!==this.elementInstances[r])for(var l=0;l<this.elementInstances[r].length;l++){var d=this.elementInstances[r][l];if(this.slides[r].elements[l].action){var c=this.slides[r].elements[l].action.params,p=this.slides[r].elements[l].action.metadata;e=void 0,void 0!==d.getCopyrights&&(e=d.getCopyrights()),void 0===e&&(e=new H5P.ContentCopyrights,H5P.findCopyrights(e,c,this.contentId,{metadata:p,machineName:d.libraryInfo.machineName}));var h=l+1;void 0!==c.contentName?h+=": "+c.contentName:void 0!==d.getTitle?h+=": "+d.getTitle():c.l10n&&c.l10n.name&&(h+=": "+c.l10n.name),e.setLabel(h),s.addContent(e)}}t.addContent(s)}return t},ce.prototype.getXAPIData=function(){var e=this.createXAPIEventTemplate("answered"),t=e.getVerifiedStatementValue(["object","definition"]);H5P.jQuery.extend(t,{interactionType:"compound",type:"http://adlnet.gov/expapi/activities/cmi.interaction"});var i=this.getScore(),n=this.getMaxScore();e.setScoredResult(i,n,this,!0,i===n);var r=o(this.slidesWithSolutions).map((function(e){if(e&&e.getXAPIData)return e.getXAPIData()})).filter((function(e){return!!e}));return{statement:e.data.statement,children:r}},ce.prototype.getContext=function(){return{type:"slide",value:this.currentSlideIndex+1}};const pe=ce;H5P=H5P||{},H5P.Tooltip=H5P.Tooltip||function(){},H5P.CoursePresentation=pe})()})();;

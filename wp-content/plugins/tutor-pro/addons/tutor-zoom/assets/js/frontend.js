!function(a){"use strict";a(document).ready(function(){var n=wp.i18n,o=n.__;n._x,n._n,n._nx;a(".tutor-zoom-meeting-countdown").each(function(){var n=a(this).data("timer"),t=a(this).data("timezone"),n=moment.tz(n,t);a(this).countdown(n.toDate(),function(n){a(this).html(n.strftime("<div>\n                        <h3>%D</h3>\n                        <p>".concat(o("Days","tutor-pro"),"</p>\n                    </div>\n                    <div>\n                        <h3>%H</h3>\n                        <p>").concat(o("Hours","tutor-pro"),"</p>\n                    </div>\n                    <div>\n                        <h3>%M</h3>\n                        <p>").concat(o("Minutes","tutor-pro"),"</p>\n                    </div>\n                    <div>\n                        <h3>%S</h3>\n                        <p>").concat(o("Seconds","tutor-pro"),"</p>\n                    </div>")))})}),a(".tutor-zoom-lesson-countdown").each(function(){var n=a(this).data("timer"),t=a(this).data("timezone"),n=moment.tz(n,t);a(this).countdown(n.toDate(),function(n){a(this).html(n.strftime("<span>%D <span>d</span></span> <span>%H <span>h</span></span> <span>%M <span>m</span></span> <span>%S <span>s</span></span>"))})})})}(jQuery);
(()=>{"use strict";window.tutor_get_nonce_data||(window.tutor_get_nonce_data=function(t){var e=window._tutorobject||{},r=e.nonce_key||"",e=e[r]||"";return t?{key:r,value:e}:{[r]:e}});const w=function(t=[]){const n=new FormData;return t.forEach(t=>{for(var[e,r]of Object.entries(t))n.set(e,r)}),n.set(window.tutor_get_nonce_data(!0).key,window.tutor_get_nonce_data(!0).value),n};function E(t){return(E="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function j(){j=function(){return a};var a={},t=Object.prototype,c=t.hasOwnProperty,s=Object.defineProperty||function(t,e,r){t[e]=r.value},e="function"==typeof Symbol?Symbol:{},n=e.iterator||"@@iterator",r=e.asyncIterator||"@@asyncIterator",o=e.toStringTag||"@@toStringTag";function i(t,e,r){return Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{i({},"")}catch(t){i=function(t,e,r){return t[e]=r}}function u(t,e,r,n){var o,i,a,u,e=e&&e.prototype instanceof h?e:h,e=Object.create(e.prototype),n=new _(n||[]);return s(e,"_invoke",{value:(o=t,i=r,a=n,u="suspendedStart",function(t,e){if("executing"===u)throw new Error("Generator is already running");if("completed"===u){if("throw"===t)throw e;return x()}for(a.method=t,a.arg=e;;){var r=a.delegate;if(r){r=function t(e,r){var n=r.method,o=e.iterator[n];if(void 0===o)return r.delegate=null,"throw"===n&&e.iterator.return&&(r.method="return",r.arg=void 0,t(e,r),"throw"===r.method)||"return"!==n&&(r.method="throw",r.arg=new TypeError("The iterator does not provide a '"+n+"' method")),f;n=l(o,e.iterator,r.arg);if("throw"===n.type)return r.method="throw",r.arg=n.arg,r.delegate=null,f;o=n.arg;return o?o.done?(r[e.resultName]=o.value,r.next=e.nextLoc,"return"!==r.method&&(r.method="next",r.arg=void 0),r.delegate=null,f):o:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,f)}(r,a);if(r){if(r===f)continue;return r}}if("next"===a.method)a.sent=a._sent=a.arg;else if("throw"===a.method){if("suspendedStart"===u)throw u="completed",a.arg;a.dispatchException(a.arg)}else"return"===a.method&&a.abrupt("return",a.arg);u="executing";r=l(o,i,a);if("normal"===r.type){if(u=a.done?"completed":"suspendedYield",r.arg===f)continue;return{value:r.arg,done:a.done}}"throw"===r.type&&(u="completed",a.method="throw",a.arg=r.arg)}})}),e}function l(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(t){return{type:"throw",arg:t}}}a.wrap=u;var f={};function h(){}function d(){}function p(){}var e={},y=(i(e,n,function(){return this}),Object.getPrototypeOf),y=y&&y(y(L([]))),v=(y&&y!==t&&c.call(y,n)&&(e=y),p.prototype=h.prototype=Object.create(e));function m(t){["next","throw","return"].forEach(function(e){i(t,e,function(t){return this._invoke(e,t)})})}function g(a,u){var e;s(this,"_invoke",{value:function(r,n){function t(){return new u(function(t,e){!function e(t,r,n,o){var i,t=l(a[t],a,r);if("throw"!==t.type)return(r=(i=t.arg).value)&&"object"==E(r)&&c.call(r,"__await")?u.resolve(r.__await).then(function(t){e("next",t,n,o)},function(t){e("throw",t,n,o)}):u.resolve(r).then(function(t){i.value=t,n(i)},function(t){return e("throw",t,n,o)});o(t.arg)}(r,n,t,e)})}return e=e?e.then(t,t):t()}})}function w(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function b(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function _(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(w,this),this.reset(!0)}function L(e){if(e){var r,t=e[n];if(t)return t.call(e);if("function"==typeof e.next)return e;if(!isNaN(e.length))return r=-1,(t=function t(){for(;++r<e.length;)if(c.call(e,r))return t.value=e[r],t.done=!1,t;return t.value=void 0,t.done=!0,t}).next=t}return{next:x}}function x(){return{value:void 0,done:!0}}return s(v,"constructor",{value:d.prototype=p,configurable:!0}),s(p,"constructor",{value:d,configurable:!0}),d.displayName=i(p,o,"GeneratorFunction"),a.isGeneratorFunction=function(t){t="function"==typeof t&&t.constructor;return!!t&&(t===d||"GeneratorFunction"===(t.displayName||t.name))},a.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,p):(t.__proto__=p,i(t,o,"GeneratorFunction")),t.prototype=Object.create(v),t},a.awrap=function(t){return{__await:t}},m(g.prototype),i(g.prototype,r,function(){return this}),a.AsyncIterator=g,a.async=function(t,e,r,n,o){void 0===o&&(o=Promise);var i=new g(u(t,e,r,n),o);return a.isGeneratorFunction(e)?i:i.next().then(function(t){return t.done?t.value:i.next()})},m(v),i(v,o,"Generator"),i(v,n,function(){return this}),i(v,"toString",function(){return"[object Generator]"}),a.keys=function(t){var e,r=Object(t),n=[];for(e in r)n.push(e);return n.reverse(),function t(){for(;n.length;){var e=n.pop();if(e in r)return t.value=e,t.done=!1,t}return t.done=!0,t}},a.values=L,_.prototype={constructor:_,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(b),!t)for(var e in this)"t"===e.charAt(0)&&c.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(r){if(this.done)throw r;var n=this;function t(t,e){return i.type="throw",i.arg=r,n.next=t,e&&(n.method="next",n.arg=void 0),!!e}for(var e=this.tryEntries.length-1;0<=e;--e){var o=this.tryEntries[e],i=o.completion;if("root"===o.tryLoc)return t("end");if(o.tryLoc<=this.prev){var a=c.call(o,"catchLoc"),u=c.call(o,"finallyLoc");if(a&&u){if(this.prev<o.catchLoc)return t(o.catchLoc,!0);if(this.prev<o.finallyLoc)return t(o.finallyLoc)}else if(a){if(this.prev<o.catchLoc)return t(o.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return t(o.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;0<=r;--r){var n=this.tryEntries[r];if(n.tryLoc<=this.prev&&c.call(n,"finallyLoc")&&this.prev<n.finallyLoc){var o=n;break}}var i=(o=o&&("break"===t||"continue"===t)&&o.tryLoc<=e&&e<=o.finallyLoc?null:o)?o.completion:{};return i.type=t,i.arg=e,o?(this.method="next",this.next=o.finallyLoc,f):this.complete(i)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),f},finish:function(t){for(var e=this.tryEntries.length-1;0<=e;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),b(r),f}},catch:function(t){for(var e=this.tryEntries.length-1;0<=e;--e){var r,n,o=this.tryEntries[e];if(o.tryLoc===t)return"throw"===(r=o.completion).type&&(n=r.arg,b(o)),n}throw new Error("illegal catch attempt")},delegateYield:function(t,e,r){return this.delegate={iterator:L(t),resultName:e,nextLoc:r},"next"===this.method&&(this.arg=void 0),f}},a}function c(t,e,r,n,o,i,a){try{var u=t[i](a),c=u.value}catch(t){return void r(t)}u.done?e(c):Promise.resolve(c).then(n,o)}function b(){return t.apply(this,arguments)}function t(){var u;return u=j().mark(function t(e){var r;return j().wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,fetch(window._tutorobject.ajaxurl,{method:"POST",body:e});case 3:return r=t.sent,t.abrupt("return",r);case 7:t.prev=7,t.t0=t.catch(0),tutor_toast(__("Operation failed","tutor"),t.t0,"error");case 10:case"end":return t.stop()}},t,null,[[0,7]])}),(t=function(){var t=this,a=arguments;return new Promise(function(e,r){var n=u.apply(t,a);function o(t){c(n,e,r,o,i,"next",t)}function i(t){c(n,e,r,o,i,"throw",t)}o(void 0)})}).apply(this,arguments)}function k(t){return(k="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function O(){O=function(){return a};var a={},t=Object.prototype,c=t.hasOwnProperty,s=Object.defineProperty||function(t,e,r){t[e]=r.value},e="function"==typeof Symbol?Symbol:{},n=e.iterator||"@@iterator",r=e.asyncIterator||"@@asyncIterator",o=e.toStringTag||"@@toStringTag";function i(t,e,r){return Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{i({},"")}catch(t){i=function(t,e,r){return t[e]=r}}function u(t,e,r,n){var o,i,a,u,e=e&&e.prototype instanceof h?e:h,e=Object.create(e.prototype),n=new _(n||[]);return s(e,"_invoke",{value:(o=t,i=r,a=n,u="suspendedStart",function(t,e){if("executing"===u)throw new Error("Generator is already running");if("completed"===u){if("throw"===t)throw e;return x()}for(a.method=t,a.arg=e;;){var r=a.delegate;if(r){r=function t(e,r){var n=r.method,o=e.iterator[n];if(void 0===o)return r.delegate=null,"throw"===n&&e.iterator.return&&(r.method="return",r.arg=void 0,t(e,r),"throw"===r.method)||"return"!==n&&(r.method="throw",r.arg=new TypeError("The iterator does not provide a '"+n+"' method")),f;n=l(o,e.iterator,r.arg);if("throw"===n.type)return r.method="throw",r.arg=n.arg,r.delegate=null,f;o=n.arg;return o?o.done?(r[e.resultName]=o.value,r.next=e.nextLoc,"return"!==r.method&&(r.method="next",r.arg=void 0),r.delegate=null,f):o:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,f)}(r,a);if(r){if(r===f)continue;return r}}if("next"===a.method)a.sent=a._sent=a.arg;else if("throw"===a.method){if("suspendedStart"===u)throw u="completed",a.arg;a.dispatchException(a.arg)}else"return"===a.method&&a.abrupt("return",a.arg);u="executing";r=l(o,i,a);if("normal"===r.type){if(u=a.done?"completed":"suspendedYield",r.arg===f)continue;return{value:r.arg,done:a.done}}"throw"===r.type&&(u="completed",a.method="throw",a.arg=r.arg)}})}),e}function l(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(t){return{type:"throw",arg:t}}}a.wrap=u;var f={};function h(){}function d(){}function p(){}var e={},y=(i(e,n,function(){return this}),Object.getPrototypeOf),y=y&&y(y(L([]))),v=(y&&y!==t&&c.call(y,n)&&(e=y),p.prototype=h.prototype=Object.create(e));function m(t){["next","throw","return"].forEach(function(e){i(t,e,function(t){return this._invoke(e,t)})})}function g(a,u){var e;s(this,"_invoke",{value:function(r,n){function t(){return new u(function(t,e){!function e(t,r,n,o){var i,t=l(a[t],a,r);if("throw"!==t.type)return(r=(i=t.arg).value)&&"object"==k(r)&&c.call(r,"__await")?u.resolve(r.__await).then(function(t){e("next",t,n,o)},function(t){e("throw",t,n,o)}):u.resolve(r).then(function(t){i.value=t,n(i)},function(t){return e("throw",t,n,o)});o(t.arg)}(r,n,t,e)})}return e=e?e.then(t,t):t()}})}function w(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function b(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function _(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(w,this),this.reset(!0)}function L(e){if(e){var r,t=e[n];if(t)return t.call(e);if("function"==typeof e.next)return e;if(!isNaN(e.length))return r=-1,(t=function t(){for(;++r<e.length;)if(c.call(e,r))return t.value=e[r],t.done=!1,t;return t.value=void 0,t.done=!0,t}).next=t}return{next:x}}function x(){return{value:void 0,done:!0}}return s(v,"constructor",{value:d.prototype=p,configurable:!0}),s(p,"constructor",{value:d,configurable:!0}),d.displayName=i(p,o,"GeneratorFunction"),a.isGeneratorFunction=function(t){t="function"==typeof t&&t.constructor;return!!t&&(t===d||"GeneratorFunction"===(t.displayName||t.name))},a.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,p):(t.__proto__=p,i(t,o,"GeneratorFunction")),t.prototype=Object.create(v),t},a.awrap=function(t){return{__await:t}},m(g.prototype),i(g.prototype,r,function(){return this}),a.AsyncIterator=g,a.async=function(t,e,r,n,o){void 0===o&&(o=Promise);var i=new g(u(t,e,r,n),o);return a.isGeneratorFunction(e)?i:i.next().then(function(t){return t.done?t.value:i.next()})},m(v),i(v,o,"Generator"),i(v,n,function(){return this}),i(v,"toString",function(){return"[object Generator]"}),a.keys=function(t){var e,r=Object(t),n=[];for(e in r)n.push(e);return n.reverse(),function t(){for(;n.length;){var e=n.pop();if(e in r)return t.value=e,t.done=!1,t}return t.done=!0,t}},a.values=L,_.prototype={constructor:_,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(b),!t)for(var e in this)"t"===e.charAt(0)&&c.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(r){if(this.done)throw r;var n=this;function t(t,e){return i.type="throw",i.arg=r,n.next=t,e&&(n.method="next",n.arg=void 0),!!e}for(var e=this.tryEntries.length-1;0<=e;--e){var o=this.tryEntries[e],i=o.completion;if("root"===o.tryLoc)return t("end");if(o.tryLoc<=this.prev){var a=c.call(o,"catchLoc"),u=c.call(o,"finallyLoc");if(a&&u){if(this.prev<o.catchLoc)return t(o.catchLoc,!0);if(this.prev<o.finallyLoc)return t(o.finallyLoc)}else if(a){if(this.prev<o.catchLoc)return t(o.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return t(o.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;0<=r;--r){var n=this.tryEntries[r];if(n.tryLoc<=this.prev&&c.call(n,"finallyLoc")&&this.prev<n.finallyLoc){var o=n;break}}var i=(o=o&&("break"===t||"continue"===t)&&o.tryLoc<=e&&e<=o.finallyLoc?null:o)?o.completion:{};return i.type=t,i.arg=e,o?(this.method="next",this.next=o.finallyLoc,f):this.complete(i)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),f},finish:function(t){for(var e=this.tryEntries.length-1;0<=e;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),b(r),f}},catch:function(t){for(var e=this.tryEntries.length-1;0<=e;--e){var r,n,o=this.tryEntries[e];if(o.tryLoc===t)return"throw"===(r=o.completion).type&&(n=r.arg,b(o)),n}throw new Error("illegal catch attempt")},delegateYield:function(t,e,r){return this.delegate={iterator:L(t),resultName:e,nextLoc:r},"next"===this.method&&(this.arg=void 0),f}},a}function s(t,e,r,n,o,i,a){try{var u=t[i](a),c=u.value}catch(t){return void r(t)}u.done?e(c):Promise.resolve(c).then(n,o)}function _(u){return function(){var t=this,a=arguments;return new Promise(function(e,r){var n=u.apply(t,a);function o(t){s(n,e,r,o,i,"next",t)}function i(t){s(n,e,r,o,i,"throw",t)}o(void 0)})}}var L=wp.i18n.__;document.addEventListener("DOMContentLoaded",_(O().mark(function t(){var a,u,c,s,r,n,o,l,f,h,e,i,d,p,y,v,m,g;return O().wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(g=function(t){var e=t.id,t=t.hide,r=void 0===t||t;null!=o&&o.forEach(function(t){t.getAttribute("data-key")==e&&(r?t.classList.add("tutor-d-none"):t.classList.remove("tutor-d-none"))})},m=function(t){var e=t.success,t=t.data;e?(u.innerHTML=t.overview,c.innerHTML=t.authors,s.innerHTML=t.course_list,r.innerHTML=t.subtotal_price,n.setAttribute("data-regular-price",t.subtotal_raw_price),t.subtotal_raw_price&&n.setAttribute("max",t.subtotal_raw_price-1)):(u.innerHTML=l,c.innerHTML=f,s.innerHTML=h,tutor_toast(t.error_title,t.error_msg,"error"))},y=function(){return(y=_(O().mark(function t(){var e,r,n,o,i=arguments;return O().wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return r=0<i.length&&void 0!==i[0]?i[0]:0,e=1<i.length?i[1]:void 0,n=2<i.length&&void 0!==i[2]?i[2]:"",o=document.getElementById("tutor-course-bundle-id").value,r=[{action:"tutor_get_course_bundle_data"},{course_id:r},{bundle_id:o},{user_action:n}],o=w(r),l=u.innerHTML,f=c.innerHTML,h=s.innerHTML,t.prev=9,(e=document.querySelectorAll(".tutor-bundle-loader"))&&null!=(n=e)&&n.forEach(function(t){t.classList.add("is-loading")}),t.next=14,b(o);case 14:return r=t.sent,t.next=17,r.json();case 17:return n=t.sent,t.abrupt("return",n);case 21:t.prev=21,t.t0=t.catch(9),tutor_toast(L("Failed","tutor-pro"),a,"error");case 24:return t.prev=24,e&&null!=(o=e)&&o.forEach(function(t){t.classList.remove("is-loading")}),t.finish(24);case 27:case"end":return t.stop()}},t,null,[[9,21,24,27]])}))).apply(this,arguments)},p=function(){return y.apply(this,arguments)},a=L("Something went wrong, please try again after refreshing page","tutor-pro"),e=tutorProCourseBundle,e=e.is_course_bundle_editor,u=document.getElementById("tutor-course-bundle-overview-wrapper"),c=document.getElementById("tutor-course-bundle-authors-wrapper"),s=document.getElementById("tutor-bundle-course-list-wrapper"),r=document.getElementById("tutor-bundle-subtotal-price"),n=document.getElementById("tutor-pro-bundle-price"),o=document.querySelectorAll(".tutor-course-bundle-builder-components .tutor-form-select-option>span[tutor-dropdown-item]"),e&&u)return t.next=16,p(0,[u,c,s]);t.next=20;break;case 16:e=t.sent,m(e),d=e.success,i=e.data,d&&i.course_ids&&i.course_ids.forEach(function(t){g({id:t,hide:!0})});case 20:(d=document.getElementById("tutor-bundle-course-selection"))&&d.addEventListener("change",function(){var e=_(O().mark(function t(e){var r;return O().wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return r=e.target,r=r.value,g({id:r,hide:!0}),t.next=5,p(r,[u,c,s]);case 5:r=t.sent,m(r);case 7:case"end":return t.stop()}},t)}));return function(t){return e.apply(this,arguments)}}()),s&&s.addEventListener("click",function(){var e=_(O().mark(function t(e){var r,n,o;return O().wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(!(r=e.target).classList.contains("tutor-remove-bundle-course")){t.next=11;break}if(n=r.dataset.courseId){t.next=5;break}return t.abrupt("return");case 5:return g({id:n,hide:!1}),r.setAttribute("disabled",!0),t.next=9,p(n,[u,c,s],"remove_course");case 9:o=t.sent,m(o);case 11:case"end":return t.stop()}},t)}));return function(t){return e.apply(this,arguments)}}()),(v=document.querySelector(".tutor-add-new-course-bundle"))&&v.addEventListener("click",function(){var e=_(O().mark(function t(e){var r,n;return O().wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e.preventDefault(),r=e.target.dataset.source,r=[{action:"tutor_add_new_draft_bundle",source:r}],r=w(r),t.prev=4,v.classList.add("is-loading"),v.setAttribute("disabled","disabled"),t.next=9,b(r);case 9:return r=t.sent,t.next=12,r.json();case 12:(n=t.sent).success?window.location.href=n.data.url:tutor_toast(L("Bundle creation failed","tutor-pro"),n.data,"error"),t.next=19;break;case 16:t.prev=16,t.t0=t.catch(4),tutor_toast(a,"error");case 19:return t.prev=19,v.classList.remove("is-loading"),v.removeAttribute("disabled"),t.finish(19);case 23:case"end":return t.stop()}},t,null,[[4,16,19,23]])}));return function(t){return e.apply(this,arguments)}}());case 25:case"end":return t.stop()}},t)})))})();
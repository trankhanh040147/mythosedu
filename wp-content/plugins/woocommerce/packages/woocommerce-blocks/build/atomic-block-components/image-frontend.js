(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[5,8],{184:function(e,t,r){"use strict";r.d(t,"a",(function(){return n}));var n=function(e,t){var r=[];return Object.keys(e).forEach((function(n){if(void 0!==t[n])switch(e[n].type){case"boolean":r[n]="false"!==t[n]&&!1!==t[n];break;case"number":r[n]=parseInt(t[n],10);break;case"array":case"object":r[n]=JSON.parse(t[n]);break;default:r[n]=t[n]}else r[n]=e[n].default})),r}},318:function(e,t,r){"use strict";var n=r(12),a=r.n(n),c=r(184);t.a=function(e){return function(t){return function(r){var n=Object(c.a)(e,r);return React.createElement(t,a()({},r,n))}}}},319:function(e,t){},320:function(e,t,r){"use strict";r.r(t);var n=r(5),a=r.n(n),c=(r(8),r(1)),o=r(3),l=r.n(o),i=r(40),s=r(98),u=r(244);r(319),t.default=Object(u.withProductDataContext)((function(e){var t=e.className,r=e.align,n=Object(s.useInnerBlockLayoutContext)().parentClassName,o=Object(s.useProductDataContext)().product;if(!o.id||!o.on_sale)return null;var u="string"==typeof r?"wc-block-components-product-sale-badge--align-".concat(r):"";return React.createElement("div",{className:l()("wc-block-components-product-sale-badge",t,u,a()({},"".concat(n,"__product-onsale"),n))},React.createElement(i.a,{label:Object(c.__)("Sale",'woocommerce'),screenReaderLabel:Object(c.__)("Product on sale",'woocommerce')}))}))},322:function(e,t){},345:function(e,t,r){"use strict";r.r(t);var n=r(318),a=r(12),c=r.n(a),o=r(5),l=r.n(o),i=r(6),s=r.n(i),u=(r(8),r(0)),p=r(1),d=r(3),b=r.n(d),f=r(2),m=r(98),g=r(244),O=r(55),j=r(320);function w(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function y(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?w(Object(r),!0).forEach((function(t){l()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):w(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}r(322);var v=function(){return React.createElement("img",{src:f.PLACEHOLDER_IMG_SRC,alt:"",width:500,height:500})},h=function(e){var t=e.image,r=e.onLoad,n=e.loaded,a=e.showFullSize,o=e.fallbackAlt,l=t||{},i=l.thumbnail,s=l.src,u=l.srcset,p=l.sizes,d=y({alt:l.alt||o,onLoad:r,hidden:!n,src:i},a&&{src:s,srcSet:u,sizes:p});return React.createElement(React.Fragment,null,d.src&&React.createElement("img",c()({"data-testid":"product-image"},d)),!n&&React.createElement(v,null))},k=Object(g.withProductDataContext)((function(e){var t=e.className,r=e.imageSizing,n=void 0===r?"full-size":r,a=e.productLink,c=void 0===a||a,o=e.showSaleBadge,i=e.saleBadgeAlign,d=void 0===i?"right":i,f=Object(m.useInnerBlockLayoutContext)().parentClassName,g=Object(m.useProductDataContext)().product,w=Object(u.useState)(!1),k=s()(w,2),E=k[0],P=k[1],R=Object(O.a)().dispatchStoreEvent;if(!g.id)return React.createElement("div",{className:b()(t,"wc-block-components-product-image","wc-block-components-product-image--placeholder",l()({},"".concat(f,"__product-image"),f))},React.createElement(v,null));var S=!!g.images.length,_=S?g.images[0]:null,D=c?"a":u.Fragment,L=Object(p.sprintf)(
/* translators: %s is referring to the product name */
Object(p.__)("Link to %s",'woocommerce'),g.name),C=y(y({href:g.permalink,rel:"nofollow"},!S&&{"aria-label":L}),{},{onClick:function(){R("product-view-link",{product:g})}});return React.createElement("div",{className:b()(t,"wc-block-components-product-image",l()({},"".concat(f,"__product-image"),f))},React.createElement(D,c&&C,!!o&&React.createElement(j.default,{align:d,product:g}),React.createElement(h,{fallbackAlt:g.name,image:_,onLoad:function(){return P(!0)},loaded:E,showFullSize:"cropped"!==n})))}));t.default=Object(n.a)({productLink:{type:"boolean",default:!0},showSaleBadge:{type:"boolean",default:!0},saleBadgeAlign:{type:"string",default:"right"},imageSizing:{type:"string",default:"full-size"},productId:{type:"number",default:0}})(k)},40:function(e,t,r){"use strict";var n=r(5),a=r.n(n),c=r(0),o=r(3),l=r.n(o);function i(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function s(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?i(Object(r),!0).forEach((function(t){a()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):i(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}t.a=function(e){var t,r=e.label,n=e.screenReaderLabel,a=e.wrapperElement,o=e.wrapperProps,i=void 0===o?{}:o,u=null!=r,p=null!=n;return!u&&p?(t=a||"span",i=s(s({},i),{},{className:l()(i.className,"screen-reader-text")}),React.createElement(t,i,n)):(t=a||c.Fragment,u&&p&&r!==n?React.createElement(t,i,React.createElement("span",{"aria-hidden":"true"},r),React.createElement("span",{className:"screen-reader-text"},n)):React.createElement(t,i,r))}}}]);
(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[6],{146:function(e,r,c){"use strict";var t=c(5),a=c.n(t),n=c(1),o=c(64),l=c(3),i=c.n(l),s=(c(8),c(51)),u=c(0),p=(c(187),function(e){var r=e.currency,c=e.maxPrice,t=e.minPrice,a=e.priceClassName,l=e.priceStyle;return React.createElement(React.Fragment,null,React.createElement("span",{className:"screen-reader-text"},Object(n.sprintf)(
/* translators: %1$s min price, %2$s max price */
Object(n.__)("Price between %1$s and %2$s",'woocommerce'),Object(s.formatPrice)(t),Object(s.formatPrice)(c))),React.createElement("span",{"aria-hidden":!0},React.createElement(o.a,{className:i()("wc-block-components-product-price__value",a),currency:r,value:t,style:l})," — ",React.createElement(o.a,{className:i()("wc-block-components-product-price__value",a),currency:r,value:c,style:l})))}),m=function(e){var r=e.currency,c=e.regularPriceClassName,t=e.regularPriceStyle,a=e.regularPrice,l=e.priceClassName,s=e.priceStyle,u=e.price;return React.createElement(React.Fragment,null,React.createElement("span",{className:"screen-reader-text"},Object(n.__)("Previous price:",'woocommerce')),React.createElement(o.a,{currency:r,renderText:function(e){return React.createElement("del",{className:i()("wc-block-components-product-price__regular",c),style:t},e)},value:a}),React.createElement("span",{className:"screen-reader-text"},Object(n.__)("Discounted price:",'woocommerce')),React.createElement(o.a,{currency:r,renderText:function(e){return React.createElement("ins",{className:i()("wc-block-components-product-price__value","is-discounted",l),style:s},e)},value:u}))};r.a=function(e){var r=e.align,c=e.className,t=e.currency,n=e.format,l=void 0===n?"<price/>":n,s=e.maxPrice,d=void 0===s?null:s,b=e.minPrice,f=void 0===b?null:b,y=e.price,g=void 0===y?null:y,v=e.priceClassName,_=e.priceStyle,O=e.regularPrice,P=e.regularPriceClassName,N=e.regularPriceStyle,j=i()(c,"price","wc-block-components-product-price",a()({},"wc-block-components-product-price--align-".concat(r),r));l.includes("<price/>")||(l="<price/>",console.error("Price formats need to include the `<price/>` tag."));var w=O&&g!==O,S=React.createElement("span",{className:i()("wc-block-components-product-price__value",v)});return w?S=React.createElement(m,{currency:t,price:g,priceClassName:v,priceStyle:_,regularPrice:O,regularPriceClassName:P,regularPriceStyle:N}):null!==f&&null!==d?S=React.createElement(p,{currency:t,maxPrice:d,minPrice:f,priceClassName:v,priceStyle:_}):null!==g&&(S=React.createElement(o.a,{className:i()("wc-block-components-product-price__value",v),currency:t,value:g,style:_})),React.createElement("span",{className:j},Object(u.createInterpolateElement)(l,{price:S}))}},157:function(e,r){},187:function(e,r){},334:function(e,r,c){"use strict";c.r(r);var t=c(5),a=c.n(t),n=(c(8),c(3)),o=c.n(n),l=c(146),i=c(51),s=c(98),u=c(245),p=c(14),m=c(244);r.default=Object(m.withProductDataContext)((function(e){var r,c,t,n,m,d,b,f=e.className,y=e.align,g=e.fontSize,v=e.customFontSize,_=e.saleFontSize,O=e.customSaleFontSize,P=e.color,N=e.customColor,j=e.saleColor,w=e.customSaleColor,S=Object(s.useInnerBlockLayoutContext)().parentClassName,C=Object(s.useProductDataContext)().product,E=o()(f,a()({},"".concat(S,"__product-price"),S));if(!C.id)return React.createElement(l.a,{align:y,className:E});var R=Object(u.getColorClassName)("color",P),x=Object(u.getFontSizeClass)(g),h=Object(u.getColorClassName)("color",j),k=Object(u.getFontSizeClass)(_),z=o()((r={"has-text-color":P||N,"has-font-size":g||v},a()(r,R,R),a()(r,x,x),r)),F=o()((c={"has-text-color":j||w,"has-font-size":_||O},a()(c,h,h),a()(c,k,k),c)),D={color:N,fontSize:v},T={color:w,fontSize:O},V=C.prices,B=Object(i.getCurrencyFromPriceResponse)(V),I=V.price!==V.regular_price,U=I?o()((t={},a()(t,"".concat(S,"__product-price__value"),S),a()(t,F,Object(p.p)()),t)):o()((n={},a()(n,"".concat(S,"__product-price__value"),S),a()(n,z,Object(p.p)()),n)),J=I?T:D;return React.createElement(l.a,{align:y,className:E,currency:B,price:V.price,priceClassName:U,priceStyle:Object(p.p)()?J:{},minPrice:null==V||null===(m=V.price_range)||void 0===m?void 0:m.min_amount,maxPrice:null==V||null===(d=V.price_range)||void 0===d?void 0:d.max_amount,regularPrice:V.regular_price,regularPriceClassName:o()((b={},a()(b,"".concat(S,"__product-price__regular"),S),a()(b,z,Object(p.p)()),b)),regularPriceStyle:Object(p.p)()?D:{}})}))},64:function(e,r,c){"use strict";var t=c(12),a=c.n(t),n=c(5),o=c.n(n),l=c(17),i=c.n(l),s=c(133),u=c(3),p=c.n(u),m=(c(157),["className","value","currency","onValueChange","displayType"]);function d(e,r){var c=Object.keys(e);if(Object.getOwnPropertySymbols){var t=Object.getOwnPropertySymbols(e);r&&(t=t.filter((function(r){return Object.getOwnPropertyDescriptor(e,r).enumerable}))),c.push.apply(c,t)}return c}function b(e){for(var r=1;r<arguments.length;r++){var c=null!=arguments[r]?arguments[r]:{};r%2?d(Object(c),!0).forEach((function(r){o()(e,r,c[r])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(c)):d(Object(c)).forEach((function(r){Object.defineProperty(e,r,Object.getOwnPropertyDescriptor(c,r))}))}return e}r.a=function(e){var r=e.className,c=e.value,t=e.currency,n=e.onValueChange,o=e.displayType,l=void 0===o?"text":o,u=i()(e,m),d="string"==typeof c?parseInt(c,10):c;if(!Number.isFinite(d))return null;var f=d/Math.pow(10,t.minorUnit);if(!Number.isFinite(f))return null;var y=p()("wc-block-formatted-money-amount","wc-block-components-formatted-money-amount",r),g=b(b(b({},u),function(e){return{thousandSeparator:e.thousandSeparator,decimalSeparator:e.decimalSeparator,decimalScale:e.minorUnit,fixedDecimalScale:!0,prefix:e.prefix,suffix:e.suffix,isNumericString:!0}}(t)),{},{value:void 0,currency:void 0,onValueChange:void 0}),v=n?function(e){var r=e.value*Math.pow(10,t.minorUnit);n(r)}:function(){};return React.createElement(s.a,a()({className:y,displayType:l},g,{value:f,onValueChange:v}))}}}]);
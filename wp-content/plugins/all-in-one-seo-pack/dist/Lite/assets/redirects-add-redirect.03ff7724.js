import{_}from"./js/_plugin-vue_export-helper.8a32e791.js";import{r as d,c as f,b as c,w as l,f as i,o as a,D as g,z as y,a as R,E as C}from"./js/vue.runtime.esm-bundler.c297bd08.js";import{l as A}from"./js/index.10ab01e4.js";import{l as k}from"./js/index.6d5de07f.js";import{u as w,s as S,l as v}from"./js/links.da3be5e7.js";/* empty css                */import{a as E}from"./js/addons.1640e0f5.js";import{C as L}from"./js/Portal.765460a1.js";import{C as b}from"./js/Index.2b28d5a5.js";import{i as x}from"./js/isEmpty.9b8981f6.js";import"./js/translations.6e7b2383.js";import"./js/default-i18n.3881921e.js";import"./js/constants.44daa6bb.js";import"./js/Caret.8cc4e863.js";import"./js/isArrayLikeObject.10b615a9.js";import"./js/upperFirst.d65414ba.js";import"./js/_stringToArray.a4422725.js";import"./js/Index.e21839d7.js";/* empty css                                                 *//* empty css                                               *//* empty css                                                 */import"./js/JsonValues.870a4901.js";import"./js/TruSeoHighlighter.271256b4.js";import"./js/postContent.d84eb650.js";import"./js/cleanForSlug.a67f7e84.js";import"./js/Ellipse.404f2a7a.js";import"./js/toFinite.c2274946.js";import"./js/strings.01407ca7.js";import"./js/isString.395b35ce.js";import"./js/ProBadge.55f2290c.js";import"./js/External.e7677bf7.js";import"./js/Exclamation.a9500c7c.js";import"./js/Checkbox.1f4414d4.js";import"./js/Checkmark.dcb95692.js";import"./js/Row.b4141467.js";import"./js/Gear.5638ce0a.js";import"./js/Slide.d2bcb99c.js";import"./js/Tooltip.42b4f815.js";import"./js/Plus.8f11b575.js";import"./js/_getTag.4ca3d6f0.js";const H={setup(){return{rootStore:w()}},components:{CoreModalPortal:L,CoreAddRedirection:b},data(){return{addons:E,urls:[],display:!1,target:null,loading:!1,strings:{modalHeader:this.$t.__("Add a Redirect",this.$td),redirectAdded:this.$t.sprintf(this.$t.__('%2$sYour redirect was added and you may edit it <a href="%1$s" target="_blank">here</a>.%3$s',this.$td),this.rootStore.aioseo.urls.aio.redirects,"<strong>","</strong>")},watchClasses:["aioseo-redirects-slug-changed","aioseo-redirects-trashed-post"]}},computed:{classSelectors(){return"."+this.watchClasses.join(", .")}},methods:{reload(){var e,o;this.display=!1;const t=(o=(e=this.target)==null?void 0:e.parentElement)==null?void 0:o.parentElement;if(t&&(t.classList.contains("components-notice__content")||t.classList.contains("notice"))){t.innerHTML="<p>"+this.strings.redirectAdded+"</p>";return}this.target.outerHTML=this.strings.redirectAdded},loadRedirect(t){this.loading=!0,S.get(this.$links.restUrl("redirects/manual-redirects/"+t)).then(e=>{this.urls=e.body.redirects,this.loading=!1}).catch(e=>console.error("Redirect modal failed to load the redirect data.",e))},preloadRedirect(){const t=document.querySelector(this.classSelectors);if(t){const e=this.getElementRedirectHash(t);if(!e)return;this.loadRedirect(e)}},watchClicks(){document.body.onclick=t=>{var o;if(!((o=t.target)!=null&&o.classList))return;let e=!1;this.watchClasses.forEach(n=>{t.target.classList.contains(n)&&(e=!0)}),e&&(t.preventDefault(),this.target=t.target,this.display=!0,x(this.url)&&this.loadRedirect(this.getElementRedirectHash(this.target)))}},getElementRedirectHash(t){return new URLSearchParams(t.href).get("aioseo-manual-urls")}},async created(){this.preloadRedirect(),this.watchClicks(),window.aioseoBus.$on("wp-core-notice-created",()=>{this.preloadRedirect()})}},$={key:0,class:"aioseo-redirects-add-redirect-standalone"},B={class:"bd"};function P(t,e,o,n,r,m){const u=d("core-add-redirection"),h=d("core-modal-portal");return r.addons.isActive("aioseo-redirects")?(a(),f("div",$,[r.display?(a(),c(h,{key:0,classes:["aioseo-redirects","modal"],onClose:e[0]||(e[0]=T=>r.display=!1)},{headerTitle:l(()=>[g(y(r.strings.modalHeader),1)]),body:l(()=>[R("div",B,[r.loading?i("",!0):(a(),c(u,{key:0,urls:r.urls,target:r.urls[0].target?r.urls[0].target:"/",disableSource:!0,onAddedRedirect:m.reload},null,8,["urls","target","onAddedRedirect"]))])]),_:1})):i("",!0)])):i("",!0)}const D=_(H,[["render",P]]),p=document.createElement("div");p.id="aioseo-redirects-add-redirect-standalone";document.body.appendChild(p);let s=C({...D,name:"Standalone/Redirects/AddRedirect"});s=A(s);s=k(s);v(s);s.mount("#aioseo-redirects-add-redirect-standalone");

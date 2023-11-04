import{S as m}from"./Profile.870d95a3.js";import{r as o,o as r,c as h,b as u,w as a,D as c,z as l,d as g}from"./vue.runtime.esm-bundler.c297bd08.js";import{_}from"./_plugin-vue_export-helper.8a32e791.js";import{e as v}from"./links.da3be5e7.js";import{C as y}from"./Index.7d0ce25e.js";import{R as $}from"./RequiredPlans.eed634df.js";const x={components:{SvgDannieProfile:m},props:{src:String,size:{required:!0,type:Number}}},S=["src","width","height"];function k(s,p,e,i,t,d){const n=o("svg-dannie-profile");return e.src?(r(),h("img",{key:0,src:e.src,width:e.size,height:e.size,alt:"avatar",loading:"lazy",decoding:"async",class:"aioseo-user-avatar"},null,8,S)):(r(),u(n,{key:1,width:e.size,height:e.size,class:"aioseo-user-avatar aioseo-user-avatar--dannie"},null,8,["width","height"]))}const P=_(x,[["render",k],["__scopeId","data-v-4705aae0"]]),U={setup(){return{licenseStore:v()}},components:{Cta:y,RequiredPlans:$},props:{parentComponentContext:String},data(){return{strings:{ctaHeader:this.$t.sprintf(this.$t.__("SEO Revisions is a %1$s Feature",this.$td),"PRO"),ctaDescription:this.$t.__("Our powerful revisions feature provides a valuable record of SEO updates, allowing you to monitor the effectiveness of your SEO efforts and make informed decisions.",this.$td),ctaFeatures:[this.$t.__("Improved SEO strategy",this.$td),this.$t.__("Easy to manage revisions",this.$td),this.$t.__("Greater transparency and accountability",this.$td),this.$t.__("Historical record of optimization efforts",this.$td)],ctaButtonText:this.$t.__("Unlock SEO Revisions",this.$td)}}}};function C(s,p,e,i,t,d){const n=o("required-plans"),f=o("cta");return r(),u(f,{"cta-link":s.$links.getPricingUrl("seo-revisions","seo-revisions",e.parentComponentContext),"button-text":t.strings.ctaButtonText,"learn-more-link":s.$links.getUpsellUrl("seo-revisions",e.parentComponentContext,s.$isPro?"pricing":"liteUpgrade"),"feature-list":t.strings.ctaFeatures,"hide-bonus":!i.licenseStore.isUnlicensed},{"header-text":a(()=>[c(l(t.strings.ctaHeader),1)]),description:a(()=>[g(n,{"core-feature":["seo-revisions"]}),c(" "+l(t.strings.ctaDescription),1)]),_:1},8,["cta-link","button-text","learn-more-link","feature-list","hide-bonus"])}const A=_(U,[["render",C]]);export{A as S,P as U};

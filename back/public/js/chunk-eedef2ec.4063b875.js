(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-eedef2ec"],{"3a66":function(t,i,e){"use strict";e.d(i,"a",(function(){return n}));var s=e("fe6c"),a=e("58df");function n(t,i=[]){return Object(a["a"])(Object(s["b"])(["absolute","fixed"])).extend({name:"applicationable",props:{app:Boolean},computed:{applicationProperty(){return t}},watch:{app(t,i){i?this.removeApplication(!0):this.callUpdate()},applicationProperty(t,i){this.$vuetify.application.unregister(this._uid,i)}},activated(){this.callUpdate()},created(){for(let t=0,e=i.length;t<e;t++)this.$watch(i[t],this.callUpdate);this.callUpdate()},mounted(){this.callUpdate()},deactivated(){this.removeApplication()},destroyed(){this.removeApplication()},methods:{callUpdate(){this.app&&this.$vuetify.application.register(this._uid,this.applicationProperty,this.updateApplication())},removeApplication(t=!1){(t||this.app)&&this.$vuetify.application.unregister(this._uid,this.applicationProperty)},updateApplication:()=>0}})}},"41c0":function(t,i,e){"use strict";e.r(i);var s=function(){var t=this,i=t.$createElement,s=t._self._c||i;return t.$auth.isAuthenticated()?s("v-navigation-drawer",{attrs:{id:"app-drawer",src:t.image,app:"",color:"grey darken-2",dark:"",floating:"","mobile-break-point":"991",persistent:"",width:"275"},scopedSlots:t._u([{key:"img",fn:function(i){return[s("v-img",t._b({attrs:{gradient:"to top, rgba(0, 0, 0, .7), rgba(0, 0, 0, .7)"}},"v-img",i,!1))]}}],null,!1,559326512),model:{value:t.inputValue,callback:function(i){t.inputValue=i},expression:"inputValue"}},[s("v-list-item",{attrs:{"two-line":""}},[s("v-list-item-avatar",{attrs:{color:"white"}},[s("v-img",{attrs:{src:e("cf05"),height:"47",contain:""}})],1),s("v-list-item-title",{staticClass:"title"},[t._v("\n            Info biro\n        ")])],1),s("v-divider",{staticClass:"mx-3 mb-3"}),s("div"),s("v-list",t._l(t.computedMenu,(function(i){return s("div",[void 0===i.sub_pages?s("v-list-item",{key:i.text,attrs:{"prepend-icon":i.icon,to:i.to,"active-class":"primary white--text"}},[s("v-list-item-icon",[s("v-icon",[t._v(t._s(i.icon))])],1),s("v-list-item-title",[t._v(t._s(i.text))])],1):s("v-list-group",{key:i.text,staticClass:"lighten-3",attrs:{"prepend-icon":i.icon,"active-class":"white--text","no-action":""},scopedSlots:t._u([{key:"activator",fn:function(){return[s("v-list-item-content",[s("v-list-item-title",{domProps:{textContent:t._s(i.text)}})],1)]},proxy:!0}],null,!0)},t._l(i.sub_pages,(function(i){return s("v-list-item",{key:i.text,staticStyle:{"padding-left":"50px !important"},attrs:{"prepend-icon":i.icon,to:i.to,"active-class":"primary white--text"}},[s("v-list-item-icon",[s("v-icon",[t._v(t._s(i.icon))])],1),s("v-list-item-title",[t._v(t._s(i.text))])],1)})),1)],1)})),0)],1):t._e()},a=[],n=(e("8e6e"),e("456d"),e("ac6a"),e("55dd"),e("bd86")),r=e("2f62"),o=(e("bc3a"),e("8f9d"));function c(t,i){var e=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);i&&(s=s.filter((function(i){return Object.getOwnPropertyDescriptor(t,i).enumerable}))),e.push.apply(e,s)}return e}function h(t){for(var i=1;i<arguments.length;i++){var e=null!=arguments[i]?arguments[i]:{};i%2?c(Object(e),!0).forEach((function(i){Object(n["a"])(t,i,e[i])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(e)):c(Object(e)).forEach((function(i){Object.defineProperty(t,i,Object.getOwnPropertyDescriptor(e,i))}))}return t}var l={props:{opened:{type:Boolean,default:!1}},data:function(){return{notifications:localStorage.getItem("notifications")}},watch:{$route:function(t,i){this.readNotifications()}},computed:h({computedMenu:function(){return isNaN(localStorage.getItem("partner_id"))?[{to:"/",icon:"mdi-view-dashboard",text:"Dashboard"},{to:"",icon:"mdi-settings-outline",text:this.$t("drawer.management"),sub_pages:[{to:"/bank",icon:"mdi-cash-100",text:this.$t("drawer.banks")},{to:"/items",icon:"mdi-ballot-outline",text:this.$t("drawer.items")},{to:"/worker",icon:"mdi-worker",text:this.$t("drawer.workers")},{to:"/cities",icon:"mdi-home-city-outline",text:this.$t("drawer.cities")},{to:"/contactTypes",icon:"mdi-contact-phone-outline",text:this.$t("drawer.contact_types")},{to:"/countries",icon:"mdi-earth",text:this.$t("drawer.countries")},{to:"/partnerType",icon:"mdi-account-tie",text:this.$t("drawer.partner_types")},{to:"/partners",icon:"mdi-briefcase-account",text:this.$t("drawer.partners")},{to:"/users",icon:"mdi-account-supervisor",text:this.$t("drawer.users")},{to:"/vehicles",icon:"mdi-car",text:this.$t("drawer.vehicles")},{to:"/workerTypes",icon:"mdi-account-multiple",text:this.$t("drawer.worker_types")}]},{to:"/evidention",icon:"mdi-newspaper-variant-multiple-outline",text:"Radna zona"},{to:"/evidentions",icon:"mdi-clipboard-check-multiple-outline",text:"Evidencije"},{to:"/reports",icon:"mdi-clipboard-outline",text:"Izvještaji"}]:[{to:"/",icon:"mdi-view-dashboard",text:"Dashboard"},{to:"/contracts",icon:"mdi-file-account-outline",text:this.$t("drawer.contracts")},{to:"/partner-evidentions",icon:"mdi-newspaper-variant-multiple-outline",text:this.$t("drawer.evidentions")}]}},Object(r["c"])("app",["image","color"]),{inputValue:{get:function(){return this.$store.state.app.drawer},set:function(t){this.setDrawer(t)}}}),methods:h({readNotifications:o["n"],sortSubPages:function(t){return t.sort((function(t,i){i.text,t.text}))},logout:function(){this.$auth.destroyToken(),this.$router.push("/login")}},Object(r["b"])("app",["setDrawer","toggleDrawer"])),created:function(){this.computedMenu.forEach((function(t){void 0!=t.sub_pages&&t.sub_pages.sort((function(t,i){return t.text>i.text?1:-1}))}))}},p=l,u=(e("ff57"),e("2877")),d=e("6544"),v=e.n(d),m=e("ce7e"),g=e("132d"),f=e("adda"),b=e("8860"),w=e("56b0"),y=e("da13"),x=e("8270"),$=e("5d23"),A=e("34c3"),O=(e("7958"),e("3a66")),_=e("a9ad"),M=e("b848"),k=e("e707"),j=e("d10f"),V=e("7560"),B=e("a293"),C=e("dc22"),P=e("c3f0"),T=e("80d2"),I=e("58df");const R=Object(I["a"])(Object(O["a"])("left",["isActive","isMobile","miniVariant","expandOnHover","permanent","right","temporary","width"]),_["a"],M["a"],k["a"],j["a"],V["a"]);var S=R.extend({name:"v-navigation-drawer",provide(){return{isInNav:"nav"===this.tag}},directives:{ClickOutside:B["a"],Resize:C["a"],Touch:P["a"]},props:{bottom:Boolean,clipped:Boolean,disableResizeWatcher:Boolean,disableRouteWatcher:Boolean,expandOnHover:Boolean,floating:Boolean,height:{type:[Number,String],default(){return this.app?"100vh":"100%"}},miniVariant:Boolean,miniVariantWidth:{type:[Number,String],default:56},mobileBreakPoint:{type:[Number,String],default:1264},permanent:Boolean,right:Boolean,src:{type:[String,Object],default:""},stateless:Boolean,tag:{type:String,default(){return this.app?"nav":"aside"}},temporary:Boolean,touchless:Boolean,width:{type:[Number,String],default:256},value:null},data:()=>({isMouseover:!1,touchArea:{left:0,right:0},stackMinZIndex:6}),computed:{applicationProperty(){return this.right?"right":"left"},classes(){return{"v-navigation-drawer":!0,"v-navigation-drawer--absolute":this.absolute,"v-navigation-drawer--bottom":this.bottom,"v-navigation-drawer--clipped":this.clipped,"v-navigation-drawer--close":!this.isActive,"v-navigation-drawer--fixed":!this.absolute&&(this.app||this.fixed),"v-navigation-drawer--floating":this.floating,"v-navigation-drawer--is-mobile":this.isMobile,"v-navigation-drawer--is-mouseover":this.isMouseover,"v-navigation-drawer--mini-variant":this.isMiniVariant,"v-navigation-drawer--custom-mini-variant":56!==Number(this.miniVariantWidth),"v-navigation-drawer--open":this.isActive,"v-navigation-drawer--open-on-hover":this.expandOnHover,"v-navigation-drawer--right":this.right,"v-navigation-drawer--temporary":this.temporary,...this.themeClasses}},computedMaxHeight(){if(!this.hasApp)return null;const t=this.$vuetify.application.bottom+this.$vuetify.application.footer+this.$vuetify.application.bar;return this.clipped?t+this.$vuetify.application.top:t},computedTop(){if(!this.hasApp)return 0;let t=this.$vuetify.application.bar;return t+=this.clipped?this.$vuetify.application.top:0,t},computedTransform(){return this.isActive?0:this.isBottom?100:this.right?100:-100},computedWidth(){return this.isMiniVariant?this.miniVariantWidth:this.width},hasApp(){return this.app&&!this.isMobile&&!this.temporary},isBottom(){return this.bottom&&this.isMobile},isMiniVariant(){return!this.expandOnHover&&this.miniVariant||this.expandOnHover&&!this.isMouseover},isMobile(){return!this.stateless&&!this.permanent&&this.$vuetify.breakpoint.width<parseInt(this.mobileBreakPoint,10)},reactsToClick(){return!this.stateless&&!this.permanent&&(this.isMobile||this.temporary)},reactsToMobile(){return this.app&&!this.disableResizeWatcher&&!this.permanent&&!this.stateless&&!this.temporary},reactsToResize(){return!this.disableResizeWatcher&&!this.stateless},reactsToRoute(){return!this.disableRouteWatcher&&!this.stateless&&(this.temporary||this.isMobile)},showOverlay(){return this.isActive&&(this.isMobile||this.temporary)},styles(){const t=this.isBottom?"translateY":"translateX",i={height:Object(T["h"])(this.height),top:this.isBottom?"auto":Object(T["h"])(this.computedTop),maxHeight:null!=this.computedMaxHeight?`calc(100% - ${Object(T["h"])(this.computedMaxHeight)})`:void 0,transform:`${t}(${Object(T["h"])(this.computedTransform,"%")})`,width:Object(T["h"])(this.computedWidth)};return i}},watch:{$route:"onRouteChange",isActive(t){this.$emit("input",t)},isMobile(t,i){!t&&this.isActive&&!this.temporary&&this.removeOverlay(),null!=i&&this.reactsToResize&&this.reactsToMobile&&(this.isActive=!t)},permanent(t){t&&(this.isActive=!0)},showOverlay(t){t?this.genOverlay():this.removeOverlay()},value(t){this.permanent||(null!=t?t!==this.isActive&&(this.isActive=t):this.init())},expandOnHover:"updateMiniVariant",isMouseover(t){this.updateMiniVariant(!t)}},beforeMount(){this.init()},methods:{calculateTouchArea(){const t=this.$el.parentNode;if(!t)return;const i=t.getBoundingClientRect();this.touchArea={left:i.left+50,right:i.right-50}},closeConditional(){return this.isActive&&!this._isDestroyed&&this.reactsToClick},genAppend(){return this.genPosition("append")},genBackground(){const t={height:"100%",width:"100%",src:this.src},i=this.$scopedSlots.img?this.$scopedSlots.img(t):this.$createElement(f["a"],{props:t});return this.$createElement("div",{staticClass:"v-navigation-drawer__image"},[i])},genDirectives(){const t=[{name:"click-outside",value:()=>this.isActive=!1,args:{closeConditional:this.closeConditional,include:this.getOpenDependentElements}}];return this.touchless||this.stateless||t.push({name:"touch",value:{parent:!0,left:this.swipeLeft,right:this.swipeRight}}),t},genListeners(){const t={transitionend:t=>{if(t.target!==t.currentTarget)return;this.$emit("transitionend",t);const i=document.createEvent("UIEvents");i.initUIEvent("resize",!0,!1,window,0),window.dispatchEvent(i)}};return this.miniVariant&&(t.click=()=>this.$emit("update:mini-variant",!1)),this.expandOnHover&&(t.mouseenter=()=>this.isMouseover=!0,t.mouseleave=()=>this.isMouseover=!1),t},genPosition(t){const i=Object(T["r"])(this,t);return i?this.$createElement("div",{staticClass:`v-navigation-drawer__${t}`},i):i},genPrepend(){return this.genPosition("prepend")},genContent(){return this.$createElement("div",{staticClass:"v-navigation-drawer__content"},this.$slots.default)},genBorder(){return this.$createElement("div",{staticClass:"v-navigation-drawer__border"})},init(){this.permanent?this.isActive=!0:this.stateless||null!=this.value?this.isActive=this.value:this.temporary||(this.isActive=!this.isMobile)},onRouteChange(){this.reactsToRoute&&this.closeConditional()&&(this.isActive=!1)},swipeLeft(t){this.isActive&&this.right||(this.calculateTouchArea(),Math.abs(t.touchendX-t.touchstartX)<100||(this.right&&t.touchstartX>=this.touchArea.right?this.isActive=!0:!this.right&&this.isActive&&(this.isActive=!1)))},swipeRight(t){this.isActive&&!this.right||(this.calculateTouchArea(),Math.abs(t.touchendX-t.touchstartX)<100||(!this.right&&t.touchstartX<=this.touchArea.left?this.isActive=!0:this.right&&this.isActive&&(this.isActive=!1)))},updateApplication(){if(!this.isActive||this.isMobile||this.temporary||!this.$el)return 0;const t=Number(this.computedWidth);return isNaN(t)?this.$el.clientWidth:t},updateMiniVariant(t){this.miniVariant!==t&&this.$emit("update:mini-variant",t)}},render(t){const i=[this.genPrepend(),this.genContent(),this.genAppend(),this.genBorder()];return(this.src||Object(T["r"])(this,"img"))&&i.unshift(this.genBackground()),t(this.tag,this.setBackgroundColor(this.color,{class:this.classes,style:this.styles,directives:this.genDirectives(),on:this.genListeners()}),i)}}),D=Object(u["a"])(p,s,a,!1,null,null,null);i["default"]=D.exports;v()(D,{VDivider:m["a"],VIcon:g["a"],VImg:f["a"],VList:b["a"],VListGroup:w["a"],VListItem:y["a"],VListItemAvatar:x["a"],VListItemContent:$["a"],VListItemIcon:A["a"],VListItemTitle:$["c"],VNavigationDrawer:S})},"58c3":function(t,i,e){},7958:function(t,i,e){},ff57:function(t,i,e){"use strict";var s=e("58c3"),a=e.n(s);a.a}}]);
//# sourceMappingURL=chunk-eedef2ec.4063b875.js.map
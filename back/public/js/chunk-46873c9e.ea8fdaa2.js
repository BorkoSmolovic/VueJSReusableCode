(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-46873c9e"],{"386b":function(t,e,i){var o=i("5ca1"),n=i("79e5"),s=i("be13"),l=/"/g,r=function(t,e,i,o){var n=String(s(t)),r="<"+e;return""!==i&&(r+=" "+i+'="'+String(o).replace(l,"&quot;")+'"'),r+">"+n+"</"+e+">"};t.exports=function(t,e){var i={};i[t]=e(r),o(o.P+o.F*n((function(){var e=""[t]('"');return e!==e.toLowerCase()||e.split('"').length>3})),"String",i)}},"3a66":function(t,e,i){"use strict";i.d(e,"a",(function(){return s}));var o=i("fe6c"),n=i("58df");function s(t,e=[]){return Object(n["a"])(Object(o["b"])(["absolute","fixed"])).extend({name:"applicationable",props:{app:Boolean},computed:{applicationProperty(){return t}},watch:{app(t,e){e?this.removeApplication(!0):this.callUpdate()},applicationProperty(t,e){this.$vuetify.application.unregister(this._uid,e)}},activated(){this.callUpdate()},created(){for(let t=0,i=e.length;t<i;t++)this.$watch(e[t],this.callUpdate);this.callUpdate()},mounted(){this.callUpdate()},deactivated(){this.removeApplication()},destroyed(){this.removeApplication()},methods:{callUpdate(){this.app&&this.$vuetify.application.register(this._uid,this.applicationProperty,this.updateApplication())},removeApplication(t=!1){(t||this.app)&&this.$vuetify.application.unregister(this._uid,this.applicationProperty)},updateApplication:()=>0}})}},"8b0d":function(t,e,i){},b54a:function(t,e,i){"use strict";i("386b")("link",(function(t){return function(e){return t(this,"a","href",e)}}))},c53f:function(t,e,i){},d7e1:function(t,e,i){"use strict";var o=i("c53f"),n=i.n(o);n.a},dc21:function(t,e,i){"use strict";i.r(e);var o=function(){var t=this,e=t.$createElement,i=t._self._c||e;return t.$auth.isAuthenticated()?i("v-app-bar",{key:t.notifications.comments.length+t.notifications.evidentions.length,attrs:{id:"core-app-bar",absolute:"",app:"",color:"transparent",flat:"",height:"88"}},[i("v-toolbar-title",{staticClass:"tertiary--text font-weight-light align-self-center"},[t.responsive?i("v-btn",{attrs:{icon:""},on:{click:function(e){return e.stopPropagation(),t.onClick(e)}}},[i("v-icon",[t._v("mdi-view-list")])],1):t._e()],1),i("v-row",[t.show?i("v-menu",{attrs:{disabled:t.disabled,absolute:t.absolute,"open-on-hover":t.openOnHover,"close-on-click":t.closeOnClick,"close-on-content-click":t.closeOnContentClick,"offset-x":t.offsetX,"offset-y":t.offsetY},scopedSlots:t._u([{key:"activator",fn:function(e){var o=e.on;return[i("v-btn",t._g({staticClass:"ml-10",attrs:{dark:"",outlined:"",color:"success"}},o),[t._v("Preuzmite uputstvo")])]}}],null,!1,2225276823),model:{value:t.downloadMenu,callback:function(e){t.downloadMenu=e},expression:"downloadMenu"}},[i("v-list",[i("v-list-item",{on:{click:t.downloadManual}},[i("v-list-item-title",[t._v("Za Radnike")])],1)],1),i("v-list",[i("v-list-item",{on:{click:t.downloadUserManual}},[i("v-list-item-title",[t._v("Za Korisnike")])],1)],1)],1):t._e(),t.show?t._e():i("v-btn",{staticClass:"ml-10",attrs:{dark:"",outlined:"",color:"success"},on:{click:t.downloadUserManual}},[t._v("Preuzmite uputstvo")]),i("div",{staticClass:"flex-grow-1"})],1),i("v-spacer"),i("v-toolbar-items",[i("v-row",{staticClass:"mx-0",attrs:{align:"center"}},[i("v-menu",{attrs:{bottom:"",left:"","offset-y":"",transition:"slide-y-transition"}}),i("v-menu",{attrs:{disabled:t.disabled,absolute:t.absolute,"open-on-hover":t.openOnHover,"close-on-click":t.closeOnClick,"close-on-content-click":t.closeOnContentClick,"offset-x":t.offsetX,"offset-y":t.offsetY},scopedSlots:t._u([{key:"activator",fn:function(e){var o=e.on;return[i("v-btn",t._g({staticClass:"mr-5",attrs:{icon:"",dark:"",color:"success"},on:{mouseenter:t.rerenderAppBar}},o),[i("v-badge",{staticClass:"align-self-center",attrs:{bottom:!1,color:"warning",left:!1,overlap:!1},scopedSlots:t._u([t.notifications.comments.length+t.notifications.evidentions.length>=0&&t.showNotifications?{key:"badge",fn:function(){return[i("span",[t._v(t._s(t.notifications.comments.length+t.notifications.evidentions.length))])]},proxy:!0}:null],null,!0)},[i("v-icon",[t._v("\n                mdi-chat-processing\n              ")])],1)],1)]}}],null,!1,3990327929),model:{value:t.notificationsMenu,callback:function(e){t.notificationsMenu=e},expression:"notificationsMenu"}},[t.notifications.comments.length>0?i("v-list",{attrs:{dense:""}},[i("v-subheader",[t._v("Novi komentari:")]),t._l(t.notifications.comments,(function(e,o){return i("v-list-item",[i("v-list-item-content",[i("v-list-item-title",{staticClass:"grey--text"},[t._v(" "+t._s("(ID:"+e.id+")")+" ")]),i("v-list-item-subtitle",{staticClass:"black--text"},[t._v(t._s("Evidencija: "+e.event_name+", korisnik: "+e.name))])],1)],1)}))],2):t._e(),t.notifications.evidentions.length>0?i("v-list",{attrs:{dense:""}},[i("v-subheader",[t._v("Nove evidencije:")]),t._l(t.notifications.evidentions,(function(e,o){return i("v-list-item",[i("v-list-item-content",[i("v-list-item-title",{staticClass:"grey--text"},[t._v(" "+t._s("(ID:"+e.id+")")+" ")]),i("v-list-item-subtitle",{staticClass:"black--text"},[t._v(t._s("Evidencija: "+e.event_name+", korisnik: "+e.name))])],1)],1)}))],2):t._e(),0===t.notifications.comments.length&&0===t.notifications.evidentions.length?i("v-list",[i("v-list-item",[i("v-list-item-title",[t._v(" Nema novih notifikacija ")])],1)],1):t._e()],1),i("v-menu",{attrs:{disabled:t.disabled,absolute:t.absolute,"open-on-hover":t.openOnHover,"close-on-click":t.closeOnClick,"close-on-content-click":t.closeOnContentClick,"offset-x":t.offsetX,"offset-y":t.offsetY},scopedSlots:t._u([{key:"activator",fn:function(e){var o=e.on;return[i("v-btn",t._g({attrs:{dark:"",outlined:"",color:"success"}},o),[t._v("Dobrodošli, "+t._s(t.username)+"  \n            "),i("v-icon",[t._v("\n              mdi-account\n            ")])],1)]}}],null,!1,2112224209),model:{value:t.value,callback:function(e){t.value=e},expression:"value"}},[i("v-list",t._l(t.items,(function(e,o){return i("v-list-item",{key:o,on:{click:function(e){return t.goTo(o)}}},[i("v-list-item-icon",[i("v-icon",[t._v(t._s(e.icon))])],1),i("v-list-item-title",[t._v(t._s(e.title))])],1)})),1)],1)],1)],1)],1):t._e()},n=[],s=(i("8e6e"),i("ac6a"),i("456d"),i("b54a"),i("bd86")),l=i("2f62"),r=i("8f9d"),a=i("abf4"),c=i("bc3a"),d=i.n(c);function h(t,e){var i=Object.keys(t);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(t);e&&(o=o.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),i.push.apply(i,o)}return i}function u(t){for(var e=1;e<arguments.length;e++){var i=null!=arguments[e]?arguments[e]:{};e%2?h(Object(i),!0).forEach((function(e){Object(s["a"])(t,e,i[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(i)):h(Object(i)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(i,e))}))}return t}var p={data:function(){return{show:isNaN(localStorage.getItem("partner_id")),downloadMenu:!1,showNotifications:!1,notifications:JSON.parse(localStorage.getItem("notifications")),username:localStorage.getItem("username"),disabled:!1,absolute:!1,openOnHover:!1,value:!1,notificationsMenu:!1,closeOnClick:!0,closeOnContentClick:!0,offsetX:!1,offsetY:!0,items:[{title:"Podešavanja profila",link:"/user-profile",icon:"mdi-account-card-details-outline"},{title:"Logout",link:"logout",icon:"mdi-exit-to-app"}],languages:[{flag:"gb",language:"en",title:"English"},{flag:"me",language:"me",title:"Crnogorski"}],title:null,responsive:!0}},mounted:function(){this.onResponsiveInverted(),window.addEventListener("resize",this.onResponsiveInverted)},beforeDestroy:function(){window.removeEventListener("resize",this.onResponsiveInverted)},methods:u({readNotifications:r["n"],rerenderAppBar:function(){this.readNotifications(),this.$forceUpdate(),this.notifications=JSON.parse(localStorage.getItem("notifications")),this.showNotifications=!0},downloadUserManual:function(){var t=this,e=i("19de");d()({url:"api/instructionClient",method:"GET",responseType:"blob"}).then((function(t){e(t.data,"uputstvo.pdf")})).catch((function(e){401==e.response.status?(t.loading=!1,t.$swal.fire({type:"info",title:"Info",text:t.$t("validation.session")}),t.$router.push("/login")):t.$swal.fire({type:"error",title:t.$t("validation.error"),text:t.$t("validation.error")})}))},downloadManual:function(){var t=this,e=i("19de");d()({url:"api/instruction",method:"GET",responseType:"blob"}).then((function(t){e(t.data,"uputstvo.pdf")})).catch((function(e){401==e.response.status?(t.loading=!1,t.$swal.fire({type:"info",title:"Info",text:t.$t("validation.session")}),t.$router.push("/login")):t.$swal.fire({type:"error",title:t.$t("validation.error"),text:t.$t("validation.error")})}))},goTo:function(t){0==t?this.$router.push(this.items[t].link):this.logout()},logout:function(){this.$auth.destroyToken(),this.$router.push("/login")},changeLocale:function(t){a["a"].locale=t}},Object(l["b"])("app",["setDrawer","toggleDrawer"]),{onClick:function(){this.setDrawer(!this.$store.state.app.drawer)},onResponsiveInverted:function(){}})},v=p,f=(i("d7e1"),i("2877")),m=i("6544"),g=i.n(m),b=(i("8b0d"),i("71d9"));function S(t,e){const i=e.value,o=e.options||{passive:!0},n=e.arg?document.querySelector(e.arg):window;n&&(n.addEventListener("scroll",i,o),t._onScroll={callback:i,options:o,target:n})}function O(t){if(!t._onScroll)return;const{callback:e,options:i,target:o}=t._onScroll;o.removeEventListener("scroll",e,i),delete t._onScroll}const k={inserted:S,unbind:O};var w=k,y=i("3a66"),_=i("d9bd"),T=i("2b0e"),C=T["a"].extend({name:"scrollable",directives:{Scroll:k},props:{scrollTarget:String,scrollThreshold:[String,Number]},data:()=>({currentScroll:0,currentThreshold:0,isActive:!1,isScrollingUp:!1,previousScroll:0,savedScroll:0,target:null}),computed:{canScroll(){return"undefined"!==typeof window},computedScrollThreshold(){return this.scrollThreshold?Number(this.scrollThreshold):300}},watch:{isScrollingUp(){this.savedScroll=this.savedScroll||this.currentScroll},isActive(){this.savedScroll=0}},mounted(){this.scrollTarget&&(this.target=document.querySelector(this.scrollTarget),this.target||Object(_["c"])(`Unable to locate element with identifier ${this.scrollTarget}`,this))},methods:{onScroll(){this.canScroll&&(this.previousScroll=this.currentScroll,this.currentScroll=this.target?this.target.scrollTop:window.pageYOffset,this.isScrollingUp=this.currentScroll<this.previousScroll,this.currentThreshold=Math.abs(this.currentScroll-this.computedScrollThreshold),this.$nextTick(()=>{Math.abs(this.currentScroll-this.savedScroll)>this.computedScrollThreshold&&this.thresholdMet()}))},thresholdMet(){}}}),x=i("d10f"),$=i("f2e7"),j=i("80d2"),I=i("58df");const M=Object(I["a"])(b["a"],C,x["a"],$["a"],Object(y["a"])("top",["clippedLeft","clippedRight","computedHeight","invertedScroll","isExtended","isProminent","value"]));var P=M.extend({name:"v-app-bar",directives:{Scroll:w},props:{clippedLeft:Boolean,clippedRight:Boolean,collapseOnScroll:Boolean,elevateOnScroll:Boolean,fadeImgOnScroll:Boolean,hideOnScroll:Boolean,invertedScroll:Boolean,scrollOffScreen:Boolean,shrinkOnScroll:Boolean,value:{type:Boolean,default:!0}},data(){return{isActive:this.value}},computed:{applicationProperty(){return this.bottom?"bottom":"top"},canScroll(){return C.options.computed.canScroll.call(this)&&(this.invertedScroll||this.elevateOnScroll||this.hideOnScroll||this.collapseOnScroll||this.isBooted||!this.value)},classes(){return{...b["a"].options.computed.classes.call(this),"v-toolbar--collapse":this.collapse||this.collapseOnScroll,"v-app-bar":!0,"v-app-bar--clipped":this.clippedLeft||this.clippedRight,"v-app-bar--fade-img-on-scroll":this.fadeImgOnScroll,"v-app-bar--elevate-on-scroll":this.elevateOnScroll,"v-app-bar--fixed":!this.absolute&&(this.app||this.fixed),"v-app-bar--hide-shadow":this.hideShadow,"v-app-bar--is-scrolled":this.currentScroll>0,"v-app-bar--shrink-on-scroll":this.shrinkOnScroll}},computedContentHeight(){if(!this.shrinkOnScroll)return b["a"].options.computed.computedContentHeight.call(this);const t=this.computedOriginalHeight,e=this.dense?48:56,i=t,o=i-e,n=o/this.computedScrollThreshold,s=this.currentScroll*n;return Math.max(e,i-s)},computedFontSize(){if(!this.isProminent)return;const t=this.dense?96:128,e=t-this.computedContentHeight,i=.00347;return Number((1.5-e*i).toFixed(2))},computedLeft(){return!this.app||this.clippedLeft?0:this.$vuetify.application.left},computedMarginTop(){return this.app?this.$vuetify.application.bar:0},computedOpacity(){if(!this.fadeImgOnScroll)return;const t=Math.max((this.computedScrollThreshold-this.currentScroll)/this.computedScrollThreshold,0);return Number(parseFloat(t).toFixed(2))},computedOriginalHeight(){let t=b["a"].options.computed.computedContentHeight.call(this);return this.isExtended&&(t+=parseInt(this.extensionHeight)),t},computedRight(){return!this.app||this.clippedRight?0:this.$vuetify.application.right},computedScrollThreshold(){return this.scrollThreshold?Number(this.scrollThreshold):this.computedOriginalHeight-(this.dense?48:56)},computedTransform(){if(!this.canScroll||this.elevateOnScroll&&0===this.currentScroll&&this.isActive)return 0;if(this.isActive)return 0;const t=this.scrollOffScreen?this.computedHeight:this.computedContentHeight;return this.bottom?t:-t},hideShadow(){return this.elevateOnScroll&&this.isExtended?this.currentScroll<this.computedScrollThreshold:this.elevateOnScroll?0===this.currentScroll||this.computedTransform<0:(!this.isExtended||this.scrollOffScreen)&&0!==this.computedTransform},isCollapsed(){return this.collapseOnScroll?this.currentScroll>0:b["a"].options.computed.isCollapsed.call(this)},isProminent(){return b["a"].options.computed.isProminent.call(this)||this.shrinkOnScroll},styles(){return{...b["a"].options.computed.styles.call(this),fontSize:Object(j["h"])(this.computedFontSize,"rem"),marginTop:Object(j["h"])(this.computedMarginTop),transform:`translateY(${Object(j["h"])(this.computedTransform)})`,left:Object(j["h"])(this.computedLeft),right:Object(j["h"])(this.computedRight)}}},watch:{canScroll:"onScroll",computedTransform(){this.canScroll&&(this.clippedLeft||this.clippedRight)&&this.callUpdate()},invertedScroll(t){this.isActive=!t}},created(){this.invertedScroll&&(this.isActive=!1)},methods:{genBackground(){const t=b["a"].options.methods.genBackground.call(this);return t.data=this._b(t.data||{},t.tag,{style:{opacity:this.computedOpacity}}),t},updateApplication(){return this.invertedScroll?0:this.computedHeight+this.computedTransform},thresholdMet(){this.invertedScroll?this.isActive=this.currentScroll>this.computedScrollThreshold:this.currentThreshold<this.computedScrollThreshold||(this.hideOnScroll&&(this.isActive=this.isScrollingUp),this.savedScroll=this.currentScroll)}},render(t){const e=b["a"].options.render.call(this,t);return e.data=e.data||{},this.canScroll&&(e.data.directives=e.data.directives||[],e.data.directives.push({arg:this.scrollTarget,name:"scroll",value:this.onScroll})),e}}),A=(i("ff44"),i("a9ad")),B=i("fe6c"),L=i("f40d"),N=Object(I["a"])(A["a"],$["a"],Object(B["b"])(["left","bottom"]),L["a"]).extend({name:"v-badge",props:{color:{type:String,default:"primary"},overlap:Boolean,transition:{type:String,default:"fab-transition"},value:{default:!0}},computed:{classes(){return{"v-badge--bottom":this.bottom,"v-badge--left":this.left,"v-badge--overlap":this.overlap}}},render(t){const e=this.$slots.badge&&[t("span",this.setBackgroundColor(this.color,{staticClass:"v-badge__badge",attrs:this.$attrs,directives:[{name:"show",value:this.isActive}]}),this.$slots.badge)];return t("span",{staticClass:"v-badge",class:this.classes},[this.$slots.default,this.transition?t("transition",{props:{name:this.transition,origin:this.origin,mode:this.mode}},e):e])}}),E=i("8336"),H=i("132d"),U=i("8860"),V=i("da13"),R=i("5d23"),D=i("34c3"),z=i("e449"),F=i("0fd9"),Y=i("2fa4"),J=i("e0c7"),X=i("2a7f"),q=Object(f["a"])(v,o,n,!1,null,null,null);e["default"]=q.exports;g()(q,{VAppBar:P,VBadge:N,VBtn:E["a"],VIcon:H["a"],VList:U["a"],VListItem:V["a"],VListItemContent:R["a"],VListItemIcon:D["a"],VListItemSubtitle:R["b"],VListItemTitle:R["c"],VMenu:z["a"],VRow:F["a"],VSpacer:Y["a"],VSubheader:J["a"],VToolbarItems:X["a"],VToolbarTitle:X["b"]})},ff44:function(t,e,i){}}]);
//# sourceMappingURL=chunk-46873c9e.ea8fdaa2.js.map
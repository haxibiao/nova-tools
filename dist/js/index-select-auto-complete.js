(window.wpJsonpSelectAutoComplete=window.wpJsonpSelectAutoComplete||[]).push([[3],{4:function(e,t,n){"use strict";n.r(t);var i={props:["resourceName","field"],computed:{selectedValue:function(){var e=this;if(void 0!==this.field.displayUsingLabels&&!0===this.field.displayUsingLabels){var t=this.field.options.find((function(t){return Number(t.value)===Number(e.field.value)}));return t?String(t.label):""}return String(this.field.value)}}},s=n(6),o=Object(s.a)(i,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return e.field.asHtml?n("div",{domProps:{innerHTML:e._s(e.selectedValue)}}):n("span",{staticClass:"whitespace-no-wrap"},[e._v(e._s(e.selectedValue))])}),[],!1,null,null,null);t.default=o.exports},6:function(e,t,n){"use strict";function i(e,t,n,i,s,o,r,l){var a,u="function"==typeof e?e.options:e;if(t&&(u.render=t,u.staticRenderFns=n,u._compiled=!0),i&&(u.functional=!0),o&&(u._scopeId="data-v-"+o),r?(a=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),s&&s.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(r)},u._ssrRegister=a):s&&(a=l?function(){s.call(this,(u.functional?this.parent:this).$root.$options.shadowRoot)}:s),a)if(u.functional){u._injectStyles=a;var d=u.render;u.render=function(e,t){return a.call(t),d(e,t)}}else{var c=u.beforeCreate;u.beforeCreate=c?[].concat(c,a):[a]}return{exports:e,options:u}}n.d(t,"a",(function(){return i}))}}]);
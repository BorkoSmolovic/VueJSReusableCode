import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './plugins'
import vuetify from './plugins/vuetify'
import {sync} from 'vuex-router-sync'
import axios from 'axios'
import money from 'v-money'
import i18n from '@/lang/lang';
import FlagIcon from 'vue-flag-icon'
import Auth from './settings/auth/Auth'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueApexCharts from 'vue-apexcharts'


sync(store, router)
Vue.use(i18n)
Vue.use(Auth)
Vue.use(VueSweetalert2)
Vue.use(FlagIcon)
Vue.use(VueApexCharts)
Vue.use(money, {precision: 4})

Vue.component('apexchart', VueApexCharts)

Vue.config.productionTip = false

// Request interceptor for adding token to every request
axios.interceptors.request.use(request => {
  request.headers.common['Authorization'] = 'Bearer ' + Vue.auth.getToken()
  return request
})



new Vue({
  router,
  store,
  vuetify,
  i18n,
  render: h => h(App),
}).$mount('#app')

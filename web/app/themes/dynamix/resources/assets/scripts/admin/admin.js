// import $ from 'jquery';
// import axios from 'axios';
// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import 'bootstrap';
import VueApexCharts from 'vue-apexcharts'
import {VueMasonryPlugin} from 'vue-masonry';
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en';
Vue.use(VueApexCharts)
Vue.use(ElementUI, { locale });
Vue.use(VueMasonryPlugin);
import App from './vue/app.vue';
// const App = {name:'app', template: '<div id="app"><router-view></router-view></div>'};
import router from './router';

import { store } from './store';
Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#appadmin',
  store,
  router,
  template: '<App/>',
  components: { App },
})
// make sure to call Vue.use(Vuex) if using a module system


// export const store = new Vuex.Store({
//   state: {
//     token: currentToken,
//     userId: currentUserId,
//     userInfo: userInfo
//   },
//   mutations: {
//     login(state, payload) {
//       state.token = payload;
//       localStorage.setItem('token', payload);
//     },
//     logout(state) {
//       stateToLocalStorage(null);
//     },
//     setUserId(state, payload) {
//       state.userId = payload;
//       localStorage.setItem('userId', payload);
//     },
//     setUserInfo(state, payload) {
//       // Serialize Object 
//       state.userInfo = payload;
//       stateToLocalStorage(state.userInfo);
//     }
//   },
//   getters: {
//     isLoggedIn: (state) => {
//       return state.token != null;
//     }
//   }
// });
// $.ajax({
//   url: ajax_object.ajax_url,
//   method: 'POST',
//   data: { action: 'get_sliders' },
// }).done(function (data) {
//   // console.warn("FILL THE DATA IN THE MODAL WITH what you got from ajax");
//   console.log(data); // this way I get a modal template; now I  can fill it with the data provided by a previous ajax to the REST API :) 
// });
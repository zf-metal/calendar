// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import store from './store/store';
import App from './App'
import Tippy from 'v-tippy'
import 'v-tippy/dist/tippy.css'
import 'v-tippy/'
Vue.use(Tippy)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  store,
  components: {App},
  template: '<App/>'
})

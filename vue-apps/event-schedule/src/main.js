import Vue from 'vue'
import App from './App.vue'
import store from './store/store';
Vue.config.productionTip = false
import './assets/main.css'

import Vuetify from 'vuetify'
Vue.use(Vuetify)
import 'vuetify/dist/vuetify.min.css'

import 'material-design-icons-iconfont/dist/material-design-icons.css'

import Tippy from 'v-tippy'
import 'v-tippy/dist/tippy.css'
import 'v-tippy/'

Vue.use(Tippy);

import * as VueGoogleMaps from 'vue2-google-maps';

Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyANmeM_tDpt9aV7q7tzDRpb5QelEAMh--o',
    libraries: 'places', // This is required if you use the Autocomplete plugin
  },

  //// If you want to manually install components, e.g.
  //// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
  //// Vue.component('GmapMarker', GmapMarker)
  //// then disable the following:
  // installComponents: true,
});



new Vue({
  render: h => h(App),
  store,
}).$mount('#app')

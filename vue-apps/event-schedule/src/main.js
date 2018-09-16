// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import store from './store/store';
import App from './App'


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

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
    el: '#app',
    store,
    components: {App},
    template: '<App/>'
})

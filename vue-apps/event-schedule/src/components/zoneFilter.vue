<template>
    <div class="zoneFilter">
        <p>Seleccionar las zonas que se desean ocultar</p>
        <div v-for="(zone,index) in getZones" :key="zone.name">
            <div class="col-lg-3">
           <check-zone :name="zone.name" :id="zone.id" :index="index"></check-zone>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
import checkZone from './checkZone.vue'

    export default {
        name: 'zoneFilter',
        props:[],
        components: {checkZone},
        methods: {},
        computed: {
            ...mapGetters([
                'getZones'
            ]),
        },
    }
</script>

<style scoped>

</style>

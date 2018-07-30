<template>
    <div class="zoneFilter">
        <div v-for="(zone,index) in getZones" :key="zone.name">

           <check-zone :name="zone.name" :id="zone.id" :index="index"></check-zone>

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

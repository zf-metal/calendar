<template>
    <div class="zoneFilter">
        <div v-for="zone in getZones" :key="zone.name">
            <div class="col-lg-3">
            <label>{{zone.name}}</label>
            <input type="checkbox" :name="zone.name" />
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: 'zoneFilter',
        props:[],
        components: {},
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

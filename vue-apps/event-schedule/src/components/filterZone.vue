<template>
    <div>
        <select class="form-control" id="filterZone"   v-on:change="changeFilterZone" v-model="zoneId">
            <option value="">Filtrar por Zona</option>
            <template v-for="zone in getZones">
                <option v-if="getPreEventsByZone(zone.id).length" :value="zone.id"  :key="zone.id">
                    {{zone.name}} ({{getPreEventsByZone(zone.id).length}})
                </option>
            </template>


        </select>

    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex';

    export default {
        name: 'filterZone',
        props:[],
        components: {},
        data() {
            return {
                zoneId: ""
            }
        },
        created: function () {
        },
        methods: {
            changeFilterZone: function(){
                this.$store.commit("SET_FILTER_ZONE",this.zoneId);
            }
        },
        computed: {
            ...mapGetters([
                'getZones',
                'getPreEventsByZone'
            ]),
        },
    }
</script>

<style scoped>

</style>

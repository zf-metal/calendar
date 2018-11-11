<template>

    <v-select class="pa-0"
              v-model="zoneId"
              v-on:change="changeFilterZone"
              :items="getItemZones"
              hide-details
              clearable
              placeholder="Filtro por zona"
              @click:clear="updateFilterOnClear"
    prepend-icon="filter_list"
    >
    </v-select>

</template>

<script>
    import {mapGetters, mapState} from 'vuex';

    export default {
        name: 'filterZone',
        props: [],
        components: {},
        data() {
            return {
                zoneId: null
            }
        },
        created: function () {
        },
        methods: {
            updateFilterOnClear: function(){
                this.$store.commit("SET_FILTER_ZONE",null);
            },
            changeFilterZone: function () {
                this.$store.commit("SET_FILTER_ZONE", this.zoneId);
            }
        },
        computed: {
            ...mapGetters([
                'getZones',
                'getPreEventsByZone'
            ]),
            getItemZones: function () {
                let items = []
                for (var key in this.getZones) {
                    var zone = this.getZones[key];
                    items.push({value: zone.id, text: zone.name + " (" + this.getPreEventsByZone(zone.id).length + ")"})
                }
                return items
            }
        },
    }
</script>

<style scoped>

</style>

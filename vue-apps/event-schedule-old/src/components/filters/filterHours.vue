<template>
    <v-layout row wrap class="mt-2">
        <v-flex xs6>
        <v-select
                  class="pa-0"
                  v-model="from"
                  v-on:change="changeFilterHours"
                  :items="hours"
                  hide-details
                  placeholder="Desde"
                  prepend-icon="watch"
                  clearable
                  @click:clear="updateFilterOnClear"
        >
        </v-select>
        </v-flex>
        <v-flex xs6>
        <v-select
                  class="pa-0"
                  v-model="to"
                  v-on:change="changeFilterHours"
                  :items="hours"
                  hide-details
                  placeholder="Hasta"
                  prepend-icon="watch"
                  clearable
                  @click:clear="updateFilterOnClear"
        >
        </v-select>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters, mapState} from 'vuex';

    export default {
        name: 'filterHours',
        props: [],
        components: {},
        data() {
            return {
                hours: [
                    {value: "00:00", text: "00:00"},
                    {value: "01:00", text: "01:00"},
                    {value: "02:00", text: "02:00"},
                    {value: "03:00", text: "03:00"},
                    {value: "04:00", text: "04:00"},
                    {value: "05:00", text: "05:00"},
                    {value: "06:00", text: "06:00"},
                    {value: "07:00", text: "07:00"},
                    {value: "08:00", text: "08:00"},
                    {value: "09:00", text: "09:00"},
                    {value: "10:00", text: "10:00"},
                    {value: "11:00", text: "11:00"},
                    {value: "12:00", text: "12:00"},
                    {value: "13:00", text: "13:00"},
                    {value: "14:00", text: "14:00"},
                    {value: "15:00", text: "15:00"},
                    {value: "16:00", text: "16:00"},
                    {value: "17:00", text: "17:00"},
                    {value: "18:00", text: "18:00"},
                    {value: "19:00", text: "19:00"},
                    {value: "20:00", text: "20:00"},
                    {value: "21:00", text: "21:00"},
                    {value: "22:00", text: "22:00"},
                    {value: "23:00", text: "23:00"},
                    {value: "24:00", text: "24:00"},
                ],
                from: null,
                to: null
            }
        },
        created: function () {
        },
        methods: {
            updateFilterOnClear: function(){
                this.$store.commit("SET_FILTER_HOURS", {from: null, to: null});
            },
            changeFilterHours: function () {
                this.$store.commit("SET_FILTER_HOURS", {from: this.from, to: this.to});
            }
        },
        computed: {
            ...mapGetters([]),
        },
    }
</script>

<style scoped>

</style>

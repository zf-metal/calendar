<template>
    <div>
            <select class="form-control" style="width: auto" id="hoursFrom" v-on:change="changeFilterHours" v-model="from">
                <option value="" selected="selected">D</option>
                <template v-for="hour in hours">
                    <option :value="hour" :key="hour">
                        {{hour}}
                    </option>
                </template>
            </select>

            <select class="form-control" style="width: auto" id="hoursTo" v-on:change="changeFilterHours" v-model="to">
                <option value="" selected="selected">H</option>
                <template v-for="hour in hours">
                    <option :value="hour" :key="hour">
                        {{hour}}
                    </option>
                </template>
            </select>

    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex';

    export default {
        name: 'filterHours',
        props: [],
        components: {},
        data() {
            return {
                hours: [ "00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"],
                from: "",
                to: ""
            }
        },
        created: function () {
        },
        methods: {
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

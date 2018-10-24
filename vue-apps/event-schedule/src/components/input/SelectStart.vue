<template>
    <v-select style="width:70px" class="pl-1" v-model="start" v-on:change="changeCalendarStart" :items="items">
    </v-select>

</template>

<script>

    export default {
        name: 'SelectSize',
        props:[],
        components: {},
        data() {
            return {
                start: '06:00',
                items: [
                    "00:00",
                    "01:00",
                    "02:00",
                    "03:00",
                    "04:00",
                    "05:00",
                    "06:00",
                    "07:00",
                    "08:00",
                    "09:00",
                    "10:00",
                    "11:00",
                    "12:00",
                    "13:00",
                    "14:00",
                    "15:00",
                    "16:00",
                    "17:00",
                    "18:00",
                    "19:00",
                    "20:00",
                    "21:00",
                    "22:00",
                    "23:00"
                ]
            }
        },
        methods: {
            changeCalendarStart: function () {
                this.$store.commit('SET_CALENDAR_START', this.start);
            },
        }
    }
</script>

<style scoped>

</style>

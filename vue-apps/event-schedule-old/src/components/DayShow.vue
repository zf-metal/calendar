<template>

    <v-toolbar-title>

        <span class="navbar-brand" :class="{holiday: isHoliday}">{{getNumberOfDayInMonthOrdinal}}</span>
        <span class="navbar-brand" :class="{holiday: isHoliday}">{{getDayName}}</span>
        <span class="navbar-brand" :class="{holiday: isHoliday}">{{getMonthName}}</span>
        <span class="navbar-brand"><holiday :enable="isHoliday"></holiday></span>
    </v-toolbar-title>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import holiday from './signals/holiday.vue'
    import moment from 'moment'
    import momenttz from 'moment-timezone'
    import 'moment/locale/es';

    export default {
        name: 'DayShow',
        props: ['value'],
        components: {holiday},
        computed: {
            ...mapGetters([
                'getMonthName',
                'getDayName',
                'getNumberOfDayInMonthOrdinal',
                'isHoliday'
            ])
        }
    }
</script>

<style scoped>
    .holiday {
        color: darkred;
    }

</style>
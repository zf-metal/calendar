<template>
    <Drag :transfer-data="{event: event, index: index, op: 'update'}"
    >

        <div>
            <v-card class="cursorPointer indigo dark pa-1 white--text pa-0">

                <v-card-text v-if="hasCalendar" class="pa-0">
                    <v-layout justify-space-around class="caption">
                        <v-flex class="text-xs-left">{{since}}-{{until}}</v-flex>
                        <v-flex class="text-xs-right"> {{calendarName}}</v-flex>
                    </v-layout>

                </v-card-text>

                <v-card-text v-else class="">
                    {{event.id}}. {{event.title}}
                </v-card-text>

            </v-card>
        </div>
    </Drag>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';

    import 'moment/locale/es';
    import {Drag, Drop} from 'vue-drag-drop';
    import formatStringDate from './../helpers/formatStringDate'

    import availabilityDay from './availabilityDay.vue';
    import availabilityTime from './availabilityTime.vue';
    import coop from './signals/coop.vue'
    import keep from './signals/keep.vue'
    import fav from './signals/fav.vue'

    export default {
        name:
            'MiniEvent',
        props: {
            index: Number,
            event: Object
        },
        components: {Drag, availabilityDay, availabilityTime, coop, keep, fav},
        data() {
            return {
                active: false,
            }
        },
        methods: {},
        computed: {
            ...mapGetters([
                'getCalendarById'
            ]),
            calendarName: function () {
                console.log(this.event)
                let calendar = this.getCalendarById(this.event.calendar)
                console.log(calendar)
                return calendar.name
            },
            since: function () {
                return formatStringDate(this.event.start, "HH:mm")
            },
            until: function () {
                return formatStringDate(this.event.end, "HH:mm")
            },
            hasCalendar: function () {
                if (this.event.calendar) {
                    return true
                }
                return false
            }
        }
    }
</script>


<style scoped>


</style>

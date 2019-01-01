<template>
    <Drag :transfer-data="{event: event, index: index, op: 'update'}"
    >

        <div>
            <v-card class="cursorPointer pa-1 white--text pa-0" :style="getStateStyle">

                <v-card-text v-if="hasCalendar" class="pa-0">
                    <v-layout justify-space-around wrap class="caption">
                        <v-flex class="text-xs-left" @click="editCalendarEvent">{{event.id}}</v-flex>
                        <v-flex  class="text-xs-right"> {{calendarName}}</v-flex>
                        <v-flex xs12 class="text-xs-left">{{since}}-{{until}}</v-flex>
                    </v-layout>

                </v-card-text>

                <v-card-text v-else class="pa-0">
                    {{event.id}}.    {{event.duration}} Min - <availability-time :data="getAvailability"></availability-time>
                </v-card-text>

            </v-card>
        </div>
    </Drag>
</template>

<script>
    import { mapGetters,mapActions} from 'vuex';

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
        methods: {
            ...mapActions([
                'setCalendarEventSelected',
                'setShowCalendarEventModal'
            ]),
            editCalendarEvent: function(){
                this.setCalendarEventSelected(this.event)
                this.setShowCalendarEventModal(true)
            }
        },
        computed: {
            ...mapGetters([
                'getCalendarById',
                'getEventStateBgColor',
                'getEventStateColor'
            ]),
            getStateStyle: function () {
                return 'background-color:' + this.getEventStateBgColor(this.event.state) + "; color: " + this.getEventStateColor(this.event.state);
            },
            calendarName: function () {
                let calendar = this.getCalendarById(this.event.calendar)
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
            },
            getAvailability: function () {
                if (this.event.config && this.event.config.availability) {
                    return this.event.config.availability
                }
                return null
            },
        }
    }
</script>


<style scoped>


</style>

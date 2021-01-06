<template>
    <Drag :transfer-data="{event: event, index: index, op: 'update'}"
    >

        <div>
            <v-card class="cursorPointer pa-1 white--text pa-0" :style="getStateStyle">

                <v-card-text class="pa-0">
                    <v-layout justify-space-around wrap class="caption">
                        <v-flex class="text-xs-left" @click="editCalendarEvent">{{event.id}}</v-flex>
                        <v-flex class="text-xs-right"> {{calendarName}}</v-flex>
                        <v-flex xs12 class="text-xs-left">
                            <v-layout row wrap>

                                <v-flex class="text-xs-left">{{since}}-{{until}}</v-flex>
                                <v-flex class="text-xs-right">
                                    <v-icon color="white" style="font-size: 15px" @click="copyData">file_copy</v-icon>
                                </v-flex>
                            </v-layout>


                        </v-flex>
                    </v-layout>

                </v-card-text>


            </v-card>
        </div>
    </Drag>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    import 'moment/locale/es';
    import {Drag} from 'vue-drag-drop';
    import formatStringDate from './../helpers/formatStringDate'


    export default {
        name:
            'MiniEvent',
        props: {
            index: Number,
            event: Object
        },
        components: {Drag},
        data() {
            return {
                active: false,
            }
        },
        methods: {
            ...mapActions([
                'setCalendarEventSelected',
                'setShowCalendarEventModal',
                'setCalendarSelected',
                'setHourSelected'
            ]),
            editCalendarEvent: function () {
                this.setCalendarEventSelected(this.event)
                this.setShowCalendarEventModal(true)
            },
            copyData: function () {

                if (this.event && this.event.calendar) {
                    this.setCalendarSelected(this.event.calendar);
                }

                if (this.event && this.event.hour) {
                    this.setHourSelected(this.event.hour);
                }
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
                if (this.event.calendar) {
                    let calendar = this.getCalendarById(this.event.calendar)
                    return calendar.name
                }
                return "-";
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

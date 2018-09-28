<template>
    <td class="zfc-column-calendar" :class="getTdClass" :id="ki" :style="getCalendarTdStyle">
        <drop @drop="handleDrop" class="zfc-dropcell">
            <event v-for="(event,index) in getEventByTd(calendarId,start,end)" :key="index"
                   :index="index" :event="event">
            </event>
        </drop>
        <dialog-alert v-if="needConfirm"
                      :dialog="needConfirm"
                      :title="cTitle"
                      :description="cDesc"
                      v-on:ok="onOk"
                      v-on:cancel="onCancel"

        ></dialog-alert>
    </td>
</template>

<script>
    import Vue from 'vue'
    import {mapGetters, mapActions} from 'vuex';
    import {Drag, Drop} from 'vue-drag-drop';
    import {calculateEnd} from './../utils/helpers'
    import event from './event.vue'
    import dialogAlert from './helpers/dialogAlert.vue'


    import moment from 'moment'
    import tz from 'moment-timezone'
    import 'moment/locale/es';

    export default {
        name: 'calnedarTd',
        props: ['calendarId', 'name', 'user', 'outOfService', 'ki', 'date', 'hour', 'cellHeight', 'isNextDay', 'day'],
        components: {Drag, Drop, event, dialogAlert},
        data() {
            return {
                top: 0,
                left: 0,
                upHere: false,
                start: null,
                end: null,
                needConfirm: false,
                cTitle: "",
                cDesc: ""
            }
        },
        mounted: function () {
            this.start = this.date + " " + this.hour;
            var end = moment(this.start, "YYYY-MM-DD HH:mm");
            end.add(30, "minutes");
            this.end = end.format("YYYY-MM-DD HH:mm");
        },
        computed: {
            ...mapGetters([
                'getCalendarSchedule',
                'getPreEventById',
                'getEventByTd',
                'getEventIndexById'
            ]),
            getCalendarTdStyle: function () {
                return "height:" + this.cellHeight + "px";
            },
            getTdClass: function () {
                var schedule = this.getCalendarSchedule(this.calendarId, this.day);

                if(this.outOfService){
                    return 'tdOutOfService'
                }

                if (!schedule || (!schedule.start && !schedule.end)) {
                    return this.isNextDay == true ? 'zfc-hour-inactive-nd' : 'zfc-hour-inactive';
                }

                if ((this.hour >= schedule.start && this.hour < schedule.end) || (this.hour >= schedule.start2 && this.hour < schedule.end2)) {
                    return this.isNextDay == true ? 'zfc-hour-active-nd' : 'zfc-hour-active';
                }
                return this.isNextDay == true ? 'zfc-hour-inactive-nd' : 'zfc-hour-inactive';

            }
        },
        methods: {
            ...mapActions([
                'removePreEvent',
                'updateEvent',
                'pushEvent',
            ]),
            handleDrop: function (data) {
                var event = data.event;
                event.calendar = this.calendarId;
                event.start = this.date + " " + this.hour;
                event.end = calculateEnd(event.start, event.duration);
                event.hour = this.hour;


                if (this.isOutOfRange(event) && !this.isFav(event)) {
                    this.alertFavAndHours()
                } else if (this.isOutOfRange(event)) {
                    this.alertHours()
                } else if (!this.isFav(event)) {
                    this.alertFav()
                }


                if (data.op != undefined && data.op == 'push') {
                    this.$store.commit('REMOVE_PRE_EVENTS', this.getPreEventById(event.id));
                    this.pushEvent(event);
                }
                if (data.op != undefined && data.op == 'update') {
                    this.updateEvent({index: this.getEventIndexById(event.id), event: event});
                }
            },
            hasFav: function (event) {
                if (event.config && event.config.preference && (event.config.preference.pref1 || event.config.preference.pref2 || event.config.preference.pref3)) {
                    return true
                }
                return false
            },
            isFav: function (event) {
                //Si el evento tiene preferencias de favorito
                if (this.hasFav(event)) {

                    if (
                        (event.config.preference.pref1 && event.config.preference.pref1.id == this.user)
                        || (event.config.preference.pref2 && event.config.preference.pref2.id == this.user)
                        || (event.config.preference.pref3 && event.config.preference.pref3.id == this.user)
                    ) {
                        //Si coincide con favortiso devuelvo true
                        return true
                    }
                    //Si no coincide con ningun favorito devuelvo false
                    return false
                }
                //Si no tiene favoritos devuelvo siempre true
                return true
            },
            isOutOfRange: function (event) {
                if (event.config && event.config.availability) {
                    if (
                        (event.config.availability.timeRange.from && event.hour < event.config.availability.timeRange.from)
                        ||
                        (
                        (event.config.availability.timeRange && event.hour > event.config.availability.timeRange.to) ||
                        (event.config.availability.timeRange2 && event.hour > event.config.availability.timeRange2.to)
                        )
                    )
                    {
                        return true
                    }
                }
                return false
            },
            alertFavAndHours: function () {
                this.cTitle = "Alerta Horario y Tecnico"
                this.cDesc = "El horario y tecnico destino no concuerda con la configuración de servicio"
                this.needConfirm = true
            },
            alertFav: function () {
                this.cTitle = "Alerta de Tecnico"
                this.cDesc = "El tecnico destino no concuerda con la configuración de servicio"
                this.needConfirm = true
            },
            alertHours: function () {
                this.cTitle = "Alerta de Horario"
                this.cDesc = "El horario destino no concuerda con la configuración de servicio"
                this.needConfirm = true
            },
            onOk: function () {
                this.needConfirm = false
            },
            onCancel: function () {
                this.needConfirm = false
            }


        },

    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

    .tdOutOfService{
        background-color: #ef9a9a;
    }

    .zfc-column-calendar {
        width: 260px !important;
        min-width: 260px !important;
        max-width: 260px !important;
        position: relative;
    }

    .zfc-dropcell {
        height: 100%;
    }

    .zfc-hour-active {
        background-color: #fcfaee;
    }

    .zfc-hour-inactive {
        background-color: #a5a0a0;
    }

    .zfc-hour-active-nd {
        background-color: #faf5dd;
    }

    .zfc-hour-inactive-nd {
        background-color: #7c7878;
    }
</style>

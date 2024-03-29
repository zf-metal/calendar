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
    import {mapGetters, mapActions} from 'vuex';
    import {Drop} from 'vue-drag-drop';
    import {calculateEnd} from './../utils/helpers'
    import event from './Event.vue'
    import dialogAlert from './helpers/dialogAlert.vue'


    import moment from 'moment'
    import 'moment/locale/es';

    export default {
        name: 'calnedarTd',
        props: ['calendarId', 'name', 'user', 'outOfService', 'ki', 'date', 'hour', 'cellHeight', 'isNextDay', 'day'],
        components: { Drop, event, dialogAlert},
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

                if (this.outOfService) {
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


                if (!this.inTime(event) && !this.isFav(event)) {
                    this.alertFavAndHours()
                } else if (!this.inTime(event)) {
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
            inTime: function (event) {
                //TRUE == En Horario
                //FALSE == Fuera de Rango
                let result = false
                if (event.config && event.config.availability) {

                    //TIME RANGE 1
                    if (event.config.availability.timeRange) {


                        if (event.config.availability.timeRange.from && event.config.availability.timeRange.to) {

                            //Si "from" y "to" estan definidos TimeRange, reviso si el horaio esta entre ese rango
                            if (event.hour >= event.config.availability.timeRange.from &&
                                event.hour <= event.config.availability.timeRange.to
                            ) {
                                result = true;
                            }

                            //Compruebo de otra manera Si el "from" es mayor al "to". Ex: From: 23:30 To: 00:30. {Errores #57}
                            if (event.config.availability.timeRange.from > event.config.availability.timeRange.to
                                &&
                                event.hour >= event.config.availability.timeRange.from
                            ) {
                                result = true;
                            }

                        }

                    }

                    //TIME RANGE 2
                    if (event.config.availability.timeRange2) {
                        //Si "from" y "to" estan definidos en TimeRange2, reviso si el horaio esta entre ese rango
                        if (event.config.availability.timeRange2.from && event.config.availability.timeRange2.to
                            &&
                            event.hour >= event.config.availability.timeRange2.from && event.hour <= event.config.availability.timeRange2.to
                        ) {
                            result = true;
                        }

                    }


                }
                return result
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

    .tdOutOfService {
        background-color: #FFAB91;
    }

    .zfc-column-calendar {
        width: 300px !important;
        min-width: 300px !important;
        max-width: 300px !important;
        position: relative;
    }

    .zfc-dropcell {
        height: 100%;
    }

    .zfc-hour-active {
        background-color: #ffffff;
    }

    .zfc-hour-inactive {
        background-color: rgba(0, 0, 0, 0.04);
        border-right: #e0e0e0 1px solid;
    }

    .zfc-hour-active-nd {
        background-color: #faf5dd;
    }

    .zfc-hour-inactive-nd {
        background-color: rgba(0, 0, 0, 0.04);
        border-right: #e0e0e0 1px solid;
    }
</style>

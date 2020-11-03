<template>
    <Drag :transfer-data="{event: event, index: index, op: 'update'}" class="drago elevation-2"
          :class="getMainClass" :style="getDragStyle">

        <div @click="selectEvent(event)">
            <v-card :style="getDragStyle">

                <v-card-title :style="getStateStyle" class="pa-0">
                    <v-layout fluid wrap>
                        <v-btn small dark icon
                               class="ma-0 pl-1"
                               @click="edit"
                               @mouseover="mouseOver"
                               @mouseout="mouseOut"
                               v-tippy="{dynamicTitle:true, arrow:true, performance:true,
                                 placement:'top', flip:true, interactive: true, animation: 'scale'}"
                               title="ID"
                        >
                            {{event.id}}
                        </v-btn>

                        <v-spacer></v-spacer>
                        <!--Distance-->
                        <span
                                class="pt-1"
                                style="padding:1px"
                        >
                            {{getDistance}}
                        </span>

                        <v-spacer></v-spacer>
                        <!--Signals-->
                        <comment v-if="!!event.finalComment" :comment="event.finalComment"></comment>
                        <keep :enable="getKeep"></keep>
                        <coop :enable="coopEnable" :link="coopLink" :count="coopCount"></coop>
                        <fav :preference="getFav"></fav>
                        <!--Menu-->
                        <event-menu @edit="edit" @showServiceEvents="showServiceEvents"></event-menu>

                    </v-layout>
                </v-card-title>
                <div
                        class="cursorPointer"
                        :title="event.serviceDescription"
                        v-tippy="{
                                     allowTitleHTML: true,
                                     dynamicTitle:true,
                                     arrow:true,
                                     placement:'right',
                                     performance:true,
                                     flip:false,
                                     followCursor: false,
                                     hideOnClick: true,
                                     trigger: 'click',
                                     animateFill: false,
                                     theme : 'gradient',
                                     popperOptions: { modifiers: { hide: { enabled: false }, preventOverflow: { enabled: false}}}
                                   }"
                >
                    <v-card-title :style="getStateStyle" class="pa-0 ma-0">
                        <span class="pl-2">{{getCliente}}</span>
                    </v-card-title>
                    <v-card-title :style="getStateStyle" class="pa-0 ma-0">
                        <span class="pl-2  font-weight-thin ">{{getBranchOffice}}</span>
                    </v-card-title>
                </div>

                <v-card-text class="pa-0">
                    <table class="table table-hover white">
                        <tbody
                        >


                        <tr>
                            <td class="pa-1">
                                <v-icon small
                                        v-tippy="{
                                                dynamicTitle:true,
                                                arrow:true,
                                                performance:true,
                                                placement:'top'
                                              }"
                                        title="Dirección"
                                >my_location</v-icon>
                            </td>
                            <td class="caption pa-1">{{getLocation}}</td>
                        </tr>
                        <tr>
                            <td :style="getSucColor" class="pa-1 pr-0">
                                <v-icon small :style="getSucColor"
                                        v-tippy="{
                                                dynamicTitle:true,
                                                arrow:true,
                                                performance:true,
                                                placement:'top'
                                              }"
                                        title="Zona"
                                >location_on</v-icon>
                            </td>
                            <td class="pa-1">{{getZone}}</td>
                        </tr>


                        <tr>
                            <td class="pa-1">
                                <v-icon
                                        small
                                        v-tippy="{
                                                dynamicTitle:true,
                                                arrow:true,
                                                performance:true,
                                                placement:'top'
                                              }"
                                        title="Rango de fechas para asignación"
                                >date_range</v-icon>
                            </td>
                            <td class="caption pa-1">
                                {{event.dateFrom}} - {{event.dateTo}}
                            </td>
                        </tr>

                        <tr>
                            <td class="pa-1">
                                <v-icon small
                                        v-tippy="{
                                                dynamicTitle:true,
                                                arrow:true,
                                                performance:true,
                                                placement:'top'
                                              }"
                                        title="Días habilitados de asignación"
                                >today</v-icon>
                            </td>
                            <td class="caption pa-1">
                                <availabilityDay :data="getAvailability"></availabilityDay>
                            </td>
                        </tr>

                        <tr>
                            <td class="pa-1">
                                <v-icon small
                                        v-tippy="{
                                                dynamicTitle:true,
                                                arrow:true,
                                                performance:true,
                                                placement:'top'
                                              }"
                                        title="Duración y horarios habilitados de asignación"
                                >hourglass_full</v-icon>
                            </td>
                            <td class="caption pa-1">
                                <span>{{event.duration}} Min - </span>
                                [
                                <availabilityTime :data="getAvailability"></availabilityTime>
                                ]
                            </td>
                        </tr>

                        </tbody>
                    </table>

                </v-card-text>


            </v-card>
        </div>
    </Drag>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';

    import 'moment/locale/es';
    import {Drag} from 'vue-drag-drop';
    import availabilityDay from './availabilityDay.vue';
    import availabilityTime from './availabilityTime.vue';
    import coop from './signals/coop.vue'
    import keep from './signals/keep.vue'
    import fav from './signals/fav.vue'
    import comment from './signals/comment.vue'
    import EventMenu from './EventMenu'

    export default {
        name:
            'event',
        props: [
            'index',
            'event',
        ],
        components: {Drag, availabilityDay, availabilityTime, coop, keep, fav, EventMenu, comment},
        data() {
            return {
                active: false,
            }
        },
        methods: {
            mouseOver: function () {
                this.active = !this.active;
            },
            mouseOut: function () {
                this.active = false;
            },
            edit: function () {
                this.selectEvent(this.event);
                this.$store.commit('SET_SHOW_MODAL_FORM', true);
            },
            showServiceEvents: function () {

                this.selectService(this.event.service);

                if (this.event && this.event.calendar) {
                    this.setCalendarSelected(this.event.calendar);
                }

                if (this.event && this.event.hour) {
                    this.setHourSelected(this.event.hour);
                }

                this.$store.commit('SET_SHOW_MODAL_SERVICE', true);
            },
            ...mapActions([
                'selectService',
                'selectEvent',
                'setCalendarSelected',
                'setHourSelected'
            ])
        },
        computed: {
            ...mapState([
                'eventIdSelected',
                'cellHeight'
            ]),
            ...mapGetters([
                'getEventIndexById',
                'getZoneBgColor',
                'getZoneColor',
                'getEventStateBgColor',
                'getEventStateColor',
                'getEventTypeIcon',
                'getDistanceFromEventSelected',
                'getCoordinate'
            ]),
            getDistance: function () {
                let d = this.getDistanceFromEventSelected(this.event.lat, this.event.lng)
                if (d && this.eventIdSelected != this.event.id) {
                    return d + "Km"
                }
                return ""
            },
            getFrecuencia: function () {
                return "Mensual"
            },
            getAvailability: function () {
                if (this.event.config && this.event.config.availability) {
                    return this.event.config.availability
                }
                return null
            },
            getKeep: function () {
                if (this.event.config && this.event.config.preference && this.event.config.preference.keep) {
                    return this.event.config.preference.keep;
                }
                return false
            },
            getFav: function () {
                if (this.event.config && this.event.config.preference) {
                    return this.event.config.preference;
                }
                return false
            },
            coopEnable: function () {
                return (this.event.link) ? true : false
            },
            coopLink: function () {
                return (this.event.link) ? this.event.link : null
            },
            coopCount: function () {
                //TODO
                return null
            },
            getCliente: function () {
                if (this.event.client != undefined) {
                    return this.event.client;
                }
                return "";
            },
            getLocation: function () {
                if (this.event.location != undefined) {
                    return this.event.location;
                }
                return "";
            },
            getBranchOffice: function () {
                if (this.event.branchOffice != undefined) {
                    return this.event.branchOffice;
                }
                return "";
            },
            getZone: function () {
                if (this.event.zone != undefined) {
                    return this.event.zone.name;
                }
                return "";
            },
            getSucColor: function () {
                if (this.event.zone != undefined && this.event.zone.id != undefined) {
                    return "background-color:" + this.getZoneBgColor(this.event.zone.id) + "; color: " + this.getZoneColor(this.event.zone.id);
                }
                return "";
            },
            getMainClass: function () {
                if (this.eventIdSelected == this.event.id) {
                    return 'zfc-event zfc-event-selected elevation-12';
                } else {
                    return 'zfc-event';
                }
            },
            getDragStyle: function () {
                if (this.active && this.getHeight < 185) {
                    return "height:185px; z-index:15; top:" + this.getTop;
                }
                return 'height:' + this.getHeight + "px; top:" + this.getTop + "px";
            },
            getStateStyle: function () {
                return 'background-color:' + this.getEventStateBgColor(this.event.state) + "; color: " + this.getEventStateColor(this.event.state);
            },
            getTop: function () {
                let sh = this.event.hour.split(":");
                let min = parseInt(sh[1])
                if (sh[1] >= 30) {
                    min = parseInt(sh[1]) - 30
                }

                return Math.ceil(min * this.cellHeight / 30)
            },
            getHeight: function () {
                let height = this.cellHeight;
                let resultado = Math.floor(this.event.duration / 30);
                let resto = this.event.duration % 30;
                if (this.event.duration > 30) {
                    height = (resultado * this.cellHeight) + Math.ceil(resto * this.cellHeight / 30);
                }

                return height
            }
        }
    }
</script>


<style scoped>


    .table {
        margin: 0;
        border-spacing: 0;
        width: 100%;
    }

    .table td {
        vertical-align: middle;
        border-top: 0;
        border-left: 0;
        border-bottom: 1px solid #d9d9d9;
        border-right: 0;
    }

    .zfc-event {
        position: absolute;
        overflow: hidden;
        line-height: 1.3;
        border-radius: 3px;
        background-color: #ffffff;
        color: #0c0c0c;
        z-index: 1;
        min-width: 296px;
        width: 296px;
        min-height: 30px;
        padding: 0;
        -webkit-box-shadow: 2px 2px 3px 0px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 2px 2px 3px 0px rgba(0, 0, 0, 0.75);
        box-shadow: 2px 2px 3px 0px rgba(0, 0, 0, 0.75);
    }

    .zfc-event-selected {
        border: 1px solid blueviolet;
    }

    .cursorPointer {
        cursor: pointer;
    }

    .cursorHelp {
        cursor: help;
    }


</style>

<style>
    .tooltipTable{
        background-color: #f8ffba;
        color: #0c0c0c;
    }

    .tooltipTable th{
        vertical-align: middle;
        border-top: 0;
        border-left: 0;
        border-bottom: 1px solid #d9d9d9;
        border-right: 0;
    }

    .tooltipTable td{
        vertical-align: middle;
        border-top: 0;
        border-left: 0;
        border-bottom: 1px solid #d9d9d9;
        border-right: 0;
    }
</style>

<template>
    <Drag :transfer-data="{event: event, index: index, op: 'update'}" class="drago elevation-2"
          :class="getMainClass" :style="getDragStyle">

        <div @click="selectEvent">
            <v-card class="cursorPointer">

                <v-card-title :style="getStateStyle" class="pa-0">
                    <v-layout fluid wrap>


                        <v-flex xs8>
                            <v-card-title class="pa-0 ma-0">
                                <span>{{getCliente}}</span>
                                <br>
                                <span class="caption font-weight-thin font-italic text-truncate">{{getBranchOffice}}</span>
                            </v-card-title>
                        </v-flex>

                        <!--HELPs Icons-->
                        <v-flex>
                            <v-btn small dark icon
                                   class="ma-0"
                                   @click="edit"
                                   @mouseover="mouseOver"
                                   @mouseout="mouseOut">
                                <v-icon
                                        v-tippy="{dynamicTitle:true, arrow:true, performance:true,
                                 placement:'top', flip:true, interactive: true, animation: 'scale'}"
                                        title="Editar">
                                    edit
                                </v-icon>
                            </v-btn>
                            <keep :enable="getKeep"></keep>
                            <coop :enable="coopEnable" :link="coopLink" :count="coopCount"></coop>
                            <fav :preference="getFav"></fav>

                            <v-btn small dark icon
                                   class="ma-1"
                                   @click="showServiceEvents"
                                   @mouseover="mouseOver"
                                   @mouseout="mouseOut"
                            >
                                <v-icon>more_vert</v-icon>
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-card-title>

                <v-card-title :style="getStateStyle" class="pa-0">
                    <!--                    <span class="text-xs-left ml-1">{{event.id}}</span>-->

                    <v-btn small dark icon
                           class="ma-0"
                           @click="edit"
                           @mouseover="mouseOver"
                           @mouseout="mouseOut"
                           v-tippy="{dynamicTitle:true, arrow:true, performance:true,
                                 placement:'top', flip:true, interactive: true, animation: 'scale'}"
                           title="ID"
                    >
                        {{event.id}}
                    </v-btn>


                    <v-card-title class="pa-0 ma-0 text-truncate caption font-weight-thin font-italic">{{getBranchOffice}}</v-card-title>
                    <v-spacer></v-spacer>
                    <!--Distance-->
                    <span style="padding:1px">{{getDistanceFromEventSelected(event.lat, event.lng)}} Km</span>
                    <!--    <v-btn
                                absolute
                                dark
                                fab
                                bottom
                                left
                                :style="getStateStyle"
                                @click="edit"
                                @mouseover="mouseOver"
                                @mouseout="mouseOut"
                                small
                        >
                            <v-icon>edit</v-icon>
                        </v-btn>-->

                </v-card-title>

            </v-card>

            <v-card class="cursorPointer">
                <v-card-text class="pe-card-text pa-0 pt-1">

                    <v-list :title="event.serviceDescription" v-tippy="{
             allowTitleHTML: true,
             dynamicTitle:true,
             arrow:true,
             placement:'right',
             performance:true,
             flip:true,
             followCursor: false,
             hideOnClick: true,
             trigger: 'click',
        }">
                        <v-list-tile>
                            <v-list-tile-action>
                                <v-icon>account_box</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title>{{getCliente}}</v-list-tile-title>
                                <v-list-tile-sub-title>{{getBranchOffice}}</v-list-tile-sub-title>
                            </v-list-tile-content>

                        </v-list-tile>

                        <v-list-tile>
                            <v-list-tile-action>
                                <v-icon>location_on</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title :style="getSucColor">{{getZone}}</v-list-tile-title>
                                <v-list-tile-sub-title>{{getLocation}}</v-list-tile-sub-title>
                            </v-list-tile-content>

                        </v-list-tile>

                        <v-list-tile>
                            <v-list-tile-action>
                                <v-icon>today</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title>
                                    <availabilityDay :data="getAvailability"></availabilityDay>

                                </v-list-tile-title>
                                <v-list-tile-sub-title>
                                    <span>{{event.duration}} Min - </span>
                                    <availabilityTime :data="getAvailability"></availabilityTime>
                                </v-list-tile-sub-title>
                            </v-list-tile-content>

                        </v-list-tile>

                    </v-list>

                </v-card-text>

            </v-card>
        </div>
    </Drag>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import axios from "axios"
    import moment from 'moment'
    import 'moment/locale/es';
    import {Drag, Drop} from 'vue-drag-drop';
    import availabilityDay from './availabilityDay.vue';
    import availabilityTime from './availabilityTime.vue';
    import coop from './signals/coop.vue'
    import keep from './signals/keep.vue'
    import fav from './signals/fav.vue'

    export default {
        name:
            'event',
        props: [
            'index',
            'event',
        ],
        components: {Drag, availabilityDay, availabilityTime, coop, keep, fav},
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
                this.selectEvent();
                this.$store.commit('SET_SHOW_MODAL_FORM', true);
            },
            selectEvent: function () {
                console.log("SelectEvent")
                this.$store.commit('SET_EVENT_SELECTED', this.event);
                this.$store.commit('SET_EVENT_ID_SELECTED', this.event.id);
                this.$store.commit('SET_EVENT_INDEX_SELECTED', this.getEventIndexById(this.event.id));
            },
            showServiceEvents: function () {
                this.selectEvent();
                this.$store.commit('SET_SHOW_MODAL_SERVICE', true);
            }
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
            },
            getFav: function () {
                if (this.event.config && this.event.config.preference) {
                    return this.event.config.preference;
                }
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
                    return 'zfc-event zfc-event-selected';
                } else {
                    return 'zfc-event';
                }
            },
            getDragStyle: function () {
                if (this.active && this.getHeight < 250) {
                    return "height:232px; z-index:15; top:" + this.getTop;
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
                let top = Math.ceil(min * this.cellHeight / 30)

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

    .v-list__tile__action {
        min-width: 35px;
    }

    .v-list__tile {
        padding: 0 5px !important;
    }

    .eventTable {
        margin: 0;
    }

    .eventTable td {
        vertical-align: middle;
        padding: 2px;

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
        -webkit-box-shadow: 3px 3px 4px 0px rgba(20, 158, 36, 1);
        -moz-box-shadow: 3px 3px 4px 0px rgba(20, 158, 36, 1);
        box-shadow: 3px 3px 4px 0px rgba(20, 158, 36, 1);
    }

    .cursorPointer {
        cursor: pointer;
    }

    .cursorHelp {
        cursor: help;
    }


</style>

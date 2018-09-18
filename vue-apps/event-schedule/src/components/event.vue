<template>
    <Drag :transfer-data="{event: event, index: index, op: 'update'}"
          :class="getMainClass" :style="getStyle">

        <div class="cursorPointer" :style="getMainStyle" @click="selectEvent" v-on:mouseover="mouseOver">

            <div :style="getStateStyle" style="padding:1px">
                <i class="material-icons btn btn-xs" style="font-size: 1em" @click="edit">edit</i>
                <span>{{event.id}}. {{event.title}}</span>
                <span class="pull-right"
                      style="padding:1px">{{getDistanceFromEventSelected(event.lat, event.lng)}} Km</span>
                <br>
            </div>


            <table class="table eventTable">
                <tbody>
                <tr class="cursorHelp" :title="event.serviceDescription"
                    v-tippy="{
             allowTitleHTML: true,
             dynamicTitle:true,
             arrow:true,
             performance:true,
             placement:'right',
             flip:true,
             followCursor: false,
             hideOnClick: true,
             trigger: 'click',
             interactive: true,
             maxWidth: '500px',
              theme: 'lulu'
             }">
                    <td><i class="material-icons" style="vertical-align: text-bottom;">account_box</i></td>
                    <td>{{getCliente}}</td>
                </tr>

                <tr>
                    <td><i class="material-icons" style="vertical-align: bottom;">business</i>
                    </td>
                    <td>{{getBranchOffice}}</td>
                </tr>

                <tr>
                    <td><i class="material-icons" style="vertical-align: text-bottom;">my_location</i>
                    </td>
                    <td>{{getLocation}}  </td>
                </tr>
                <tr>
                    <td :style="getSucColor"><i class="material-icons" style="vertical-align: bottom;">center_focus_strong</i>
                    </td>
                    <td :style="getSucColor">{{getZone}}</td>
                </tr>

                <tr>
                    <td><i class="material-icons" style="vertical-align: bottom;">today</i></td>
                    <td>
                        <availabilityDay :data="event.config.availability"></availabilityDay>
                    </td>
                </tr>

                <tr>
                    <td><i class="material-icons" style="vertical-align: bottom;">hourglass_full</i></td>
                    <td>
                        <availabilityTime :data="event.config.availability"></availabilityTime>
                    </td>
                </tr>

                </tbody>
            </table>

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

    export default {
        name:
            'event',
        props: [
            'index',
            'event',
        ],
        components: {Drag, availabilityDay, availabilityTime},
        data() {
            return {
                active: false,
            }
        },
        methods: {
            mouseOver: function () {
                this.active = !this.active;
            },
            edit: function () {
                this.selectEvent();
                this.$store.commit('SET_SHOW_MODAL_FORM', true);
            },
            selectEvent: function () {
                this.$store.commit('SET_EVENT_SELECTED', this.event);
                this.$store.commit('SET_EVENT_ID_SELECTED', this.event.id);
                this.$store.commit('SET_EVENT_INDEX_SELECTED', this.getEventIndexById(this.event.id));
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
                'getEventStateBgColor',
                'getEventStateColor',
                'getEventTypeIcon',
                'getDistanceFromEventSelected',
                'getCoordinate'
            ]),
            getMainStyle: function () {
                if (this.active) {
                    return "height:500px"
                }
                return "height:100%"
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
                    return "background-color:" + this.getZoneBgColor(this.event.zone.id);
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
            getStyle: function () {
                return 'height:' + this.getHeight + "px;";
            },
            getStateStyle: function () {
                return 'background-color:' + this.getEventStateBgColor(this.event.state) + "; color: " + this.getEventStateColor(this.event.state);
            },
            getHeight: function () {
                var height = this.cellHeight;
                if (this.event.duration > 30) {
                    height = Math.ceil(this.event.duration / 30) * this.cellHeight;
                }

                return height
            }
        }
    }
</script>


<style scoped>

    .eventTable {
        margin: 0;
    }

    .eventTable td {
        vertical-align: middle;
        padding: 1px;
        font-size: 0.95em;
    }

    .eventTable td i {
        font-size: 1em;
    }

    .zfc-event {
        position: absolute;
        overflow: hidden;
        /*display: block;*/
        font-size: .90em;
        line-height: 1.3;
        border-radius: 3px;
        /*border: 1px solid #5c6667;*/
        background-color: #ffffff;
        color: #0c0c0c;
        z-index: 12;
        min-width: 255px;
        width: 255px;
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

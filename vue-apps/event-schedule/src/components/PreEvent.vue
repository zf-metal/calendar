<template>
    <drag :transfer-data="{event: preEvent, index:index, op: 'push'}">

        <v-card class="mt-4" color="blue-grey darken-4">

            <!--Title-->
            <v-card-text class="pa-1 cursorPointer white--text">
                <span class="text-xs-left">{{preEvent.id}}. {{preEvent.title}}
                </span>
                <keep :enable="getKeep"></keep>
                <fav :preference="getFav"></fav>
                <coop :enable="coopEnable" :link="coopLink" :count="coopCount"></coop>


            </v-card-text>

            <v-card-text class="pe-card-text">
                <table class="table table-hover white">
                    <tbody>
                    <tr class="cursorHelp" :title="preEvent.serviceDescription"
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
             popperOptions: { modifiers: { hide: { enabled: false }, preventOverflow: { enabled: false}}}
        }">
                        <td><i class="material-icons" style="vertical-align: bottom;">account_box</i></td>
                        <td class="caption">{{getCliente}}</td>
                    </tr>
                    <tr>
                        <td><i class="material-icons" style="vertical-align: bottom;">business</i>
                        </td>
                        <td class="caption">{{getBranchOffice}}</td>
                    </tr>
                    <tr>
                        <td><i class="material-icons" style="vertical-align: bottom;">my_location</i>
                        </td>
                        <td class="caption">{{getLocation}}</td>
                    </tr>
                    <tr>
                        <td  :style="getSucColor" class="pa-1 pr-0">
                            <v-icon small :style="getSucColor">location_on</v-icon>
                        </td>
                        <td class="pa-1">{{getZone}}</td>
                    </tr>
                    <tr>
                        <td><i class="material-icons" style="vertical-align: bottom;">today</i></td>
                        <td class="caption">
                            <availabilityDay :data="getAvailability"></availabilityDay>
                        </td>
                    </tr>

                    <tr>
                        <td><i class="material-icons" style="vertical-align: bottom;">hourglass_full</i></td>
                        <td class="caption">
                            <span>{{preEvent.duration}} Min - </span>

                            [<availabilityTime :data="getAvailability"></availabilityTime>]
                        </td>
                    </tr>

             <!--       <tr>
                    <td><i class="material-icons" style="vertical-align: bottom;">add</i>
                    </td>
                    <td>{{getPriority}}</td>
                    </tr>-->

                    </tbody>
                </table>

            </v-card-text>
        </v-card>

    </drag>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import {Drag, Drop} from 'vue-drag-drop';
    import availabilityDay from './availabilityDay.vue';
    import availabilityTime from './availabilityTime.vue';
    import coop from './signals/coop.vue'
    import keep from './signals/keep.vue'
    import fav from './signals/fav.vue'

    export default {
        name: 'PreEvent',
        props: ['preEvent', 'index'],
        components: {Drag, Drop, availabilityDay, availabilityTime, coop, keep, fav},
        methods: {},
        computed: {
            ...mapGetters([
                'getZoneBgColor',
                'getZoneColor',
                'getEventStateBgColor',
                'getEventTypeIcon'
            ]),
            getAvailability: function(){
              if(this.preEvent.config && this.preEvent.config.availability){
                  return this.preEvent.config.availability
              }
              return null
            },
            getKeep: function () {
                if (this.preEvent.config && this.preEvent.config.preference && this.preEvent.config.preference.keep) {
                    return this.preEvent.config.preference.keep;
                }
            },
            getFav: function () {
                if (this.preEvent.config && this.preEvent.config.preference) {
                    return this.preEvent.config.preference;
                }
            },
            coopEnable: function () {
                return (this.preEvent.link) ? true : false
            },
            coopLink: function () {
                return (this.preEvent.link) ? this.preEvent.link : null
            },
            coopCount: function () {
                //TODO
                return null
            },
            getPriority: function () {
                return this.preEvent.priority;
            },
            getCliente: function () {
                if (this.preEvent.client != undefined) {
                    return this.preEvent.client;
                }
                return "";
            },
            getBranchOffice: function () {
                if (this.preEvent.branchOffice != undefined) {
                    return this.preEvent.branchOffice;
                }
                return "";
            },
            getLocation: function () {
                if (this.preEvent.location != undefined) {
                    return this.preEvent.location;
                }
                return "";
            },
            getZone: function () {
                if (this.preEvent.zone != undefined) {
                    return this.preEvent.zone.name;
                }
                return "";
            },
            getSucColor: function () {
                if (this.preEvent.zone != undefined && this.preEvent.zone.id != undefined) {
                    return "background-color:" + this.getZoneBgColor(this.preEvent.zone.id) + "; color: " + this.getZoneColor(this.preEvent.zone.id);
                }
                return "";
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
        padding: 3px;
        border-top:0;
        border-left:0;
        border-bottom: 1px solid #d9d9d9;
        border-right:0;
    }

    .card-title {
        font-size: 1.5em;
    }

    .pe-card-title {
        padding: 5px;
    }

    .pe-card-text {
        padding: 1px;
    }

    .cursorPointer {
        cursor: pointer;
    }

    .cursorHelp {
        cursor: help;
    }


</style>

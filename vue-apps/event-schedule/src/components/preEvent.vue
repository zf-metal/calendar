<template>
    <drag :transfer-data="{event: preEvent, index:index, op: 'push'}">

        <v-card class="mt-2" color="indigo">

            <!--Title-->
            <v-card-text class="pa-1 cursorPointer white--text">
                <span class="text-xs-left">{{preEvent.id}}. {{preEvent.title}}
                </span>
                <keep :enable="getKeep"></keep>
                <fav :preference="preEvent.config.preference?preEvent.config.preference:{}"></fav>
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
                        <td :style="getSucColor"><i class="material-icons" style="vertical-align: bottom;">center_focus_strong</i>
                        </td>
                        <td :style="getSucColor" class="caption">{{getZone}}</td>
                    </tr>
                    <tr>
                        <td><i class="material-icons" style="vertical-align: bottom;">today</i></td>
                        <td class="caption">
                            <availabilityDay :data="preEvent.config.availability"></availabilityDay>
                        </td>
                    </tr>

                    <tr>
                        <td><i class="material-icons" style="vertical-align: bottom;">hourglass_full</i></td>
                        <td class="caption">
                            <span>{{preEvent.duration}} Min - </span>
                            <availabilityTime :data="preEvent.config.availability"></availabilityTime>
                        </td>
                    </tr>


                    <!--<tr>-->
                    <!--<td><i class="material-icons" style="vertical-align: bottom;">add</i>-->
                    <!--</td>-->
                    <!--<td>{{getPriority}}</td>-->
                    <!--</tr>-->

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
        name: 'preEvent',
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
            getKeep: function () {
                if (this.preEvent.config && this.preEvent.config.preference && this.preEvent.config.preference.keep) {
                    return this.preEvent.config.preference.keep;
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
                    return "background-color:" + this.getZoneBgColor(this.preEvent.zone.id) + "color: " + this.getZoneColor(this.preEvent.zone.id);
                }
                return "";
            }
        }
    }
</script>

<style scoped>
    .table {
        margin: 0;
    }

    .table td {
        vertical-align: middle;
        padding: 3px;
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

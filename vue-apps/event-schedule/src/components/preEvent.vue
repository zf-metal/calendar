<template>
    <drag :transfer-data="{event: preEvent, index:index, op: 'push'}">

        <div class="card"
        >
            <div class="card-header card-header-preevent cursorPointer">
                <h4 class="card-title">{{preEvent.id}}. {{preEvent.title}}
                    <!--<i class="material-icons zfc-pre-type-icon pull-right">{{getEventTypeIcon(obj.type)}} </i>-->
                </h4>
                <coop :enable="coopEnable" :link="coopLink" :count="coopCount"></coop>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
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
                        <td>{{getCliente}}</td>
                    </tr>
                    <tr>
                        <td><i class="material-icons" style="vertical-align: bottom;">business</i>
                        </td>
                        <td>{{getBranchOffice}}</td>
                    </tr>
                    <tr>
                        <td><i class="material-icons" style="vertical-align: bottom;">my_location</i>
                        </td>
                        <td>{{getLocation}}</td>
                    </tr>
                    <tr>
                        <td :style="getSucColor"><i class="material-icons" style="vertical-align: bottom;">center_focus_strong</i>
                        </td>
                        <td :style="getSucColor">{{getZone}}</td>
                    </tr>
                    <tr>
                        <td><i class="material-icons" style="vertical-align: bottom;">today</i></td>
                        <td>
                            <availabilityDay :data="preEvent.availability"></availabilityDay>
                        </td>
                    </tr>

                    <tr>
                        <td><i class="material-icons" style="vertical-align: bottom;">hourglass_full</i></td>
                        <td>
                            <availabilityTime :data="preEvent.availability"></availabilityTime>
                        </td>
                    </tr>


                    <!--<tr>-->
                    <!--<td><i class="material-icons" style="vertical-align: bottom;">add</i>-->
                    <!--</td>-->
                    <!--<td>{{getPriority}}</td>-->
                    <!--</tr>-->

                    </tbody>
                </table>
            </div>
        </div>

    </drag>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import {Drag, Drop} from 'vue-drag-drop';
    import availabilityDay from './availabilityDay.vue';
    import availabilityTime from './availabilityTime.vue';
    import coop from './signals/coop.vue'

    export default {
        name: 'preEvent',
        props: ['preEvent', 'index'],
        components: {Drag, Drop, availabilityDay, availabilityTime, coop},
        methods: {},
        computed: {
            ...mapGetters([
                'getZoneBgColor',
                'getEventStates',
                'getEventStateBgColor',
                'getEventTypeIcon'
            ]),
            coopEnable: function(){
                return (this.preEvent.link)?true:false
            },
            coopLink: function(){
                return (this.preEvent.link)?this.preEvent.link:null
            },
            coopCount: function(){
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
                    return "background-color:" + this.getZoneBgColor(this.preEvent.zone.id);
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

    .card {
        border: 0;
        margin-bottom: 10px;
        margin-top: 10px;
        border-radius: 6px;
        color: #333;
        background: #fff;
        width: 100%;
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, .14), 0 3px 1px -2px rgba(0, 0, 0, .2), 0 1px 5px 0 rgba(0, 0, 0, .12);
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid #eee;
        border-radius: .25rem;
        font-size: .875rem;
    }

    .card-title {
        font-size: 1.5em;
    }

    .card .card-header {
        z-index: 3 !important;
        padding: 1px;
        position: relative;
        color: #fff;
        border-bottom: none;
        background: transparent;
    }

    .card .card-header-preevent {
        /*background: linear-gradient(60deg,#ab47bc,#8e24aa);*/
        background-color: #333;
    }

    .cursorPointer {
        cursor: pointer;
    }

    .cursorHelp {
        cursor: help;
    }


</style>

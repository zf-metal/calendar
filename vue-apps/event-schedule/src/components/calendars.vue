<template>
    <div class="zfc-main-container">
        <navi></navi>
        <loading :isLoading="getLoading"></loading>
        <div class="clearfix"></div>
        <div class="col-lg-2 zfc-calendars-parent" style="margin: 0; padding:0;">
            <panel v-on:forceUpdate="onForceUpdate"></panel>
        </div>

        <div class="col-lg-10 zfc-calendars-parent">


            <table class="table-bordered table-striped table-responsive zfc-header-table" :style="getStyleHeaderFix">
                <thead>
                <tr v-if="hasCalendars">
                    <th class="zfc-column-hours"></th>
                    <th class="zfc-column-calendar"
                        v-for="calendar in getVisibleCalendars"
                        :key="calendar.id">
                                <span>{{calendar.name}}
                                    <i @click="showMap(calendar.id,calendar.name)"
                                       class="material-icons cursorPointer pull-right" style="vertical-align: bottom">map</i></span>

                    </th>
                </tr>
                </thead>
            </table>
            <div class="zfc-calendars" ref="zfcCalendars" v-on:scroll="handleCalendarScroll">
                <table class="table-bordered table-striped table-responsive zfc-td" border="1">

                    <tbody>

                    <!--TODAY-->
                    <tr v-if="hasCalendars" v-for="hour in getHours" v-bind:key="getDate + hour">
                        <td class="zfc-column-hours">{{hour}}</td>
                        <calendarTd
                                v-for="calendar in getVisibleCalendars"
                                :key='getRc + getDate + calendar.id + hour' :ki="getRc + getDate + calendar.id + hour"
                                :calendarId="calendar.id" :name="calendar.name"
                                :date="getDate" :hour="hour"
                                :parentTop="top" :parentLeft="left" :rc="getRc" :isNextDay="false" :day="getDay"
                                :cellHeight="getCellHeight">
                        </calendarTd>
                    </tr>

                    <tr style="height: 3px;">
                        <th v-if="hasCalendars" class="zfc-column-hours" style="background-color: #0c0c0c ">
                        </th>

                        <td v-for="calendar in getVisibleCalendars" :key='getRc + calendar.id+"_nd"'
                            style="background-color: #0c0c0c ">
                        </td>
                    </tr>

                    <!--NEXTDAY-->
                    <tr v-if="hasCalendars" v-for="hour in getNextHours" v-bind:key="getNextDate + hour">
                        <td class="zfc-column-hours">{{hour}}</td>
                        <calendarTd
                                v-for="calendar in getVisibleCalendars"
                                :key='getRc + getNextDate + calendar.id + hour' :ki="getRc + getNextDate + calendar.id + hour"
                                :calendarId="calendar.id" :name="calendar.name"
                                :date="getNextDate" :hour="hour"
                                :parentTop="top" :parentLeft="left" :rc="getRc" :isNextDay="true" :day="getNextDay"
                                :cellHeight="getCellHeight">
                        </calendarTd>
                    </tr>

                    </tbody>
                </table>


            </div>
        </div>


        <modal :title="getModalFormTitle" :showModal="getShowModalForm" @close="closeModalForm">
            <form-event :calendars="getCalendars" v-model="getEventForm"
                        :index="getEventIndexSelected" v-on:remove="removeEvent"/>
        </modal>

        <modal :title="'Mapa: '+calendarName" :showModal="showModalMap" @close="showModalMap = false">
            <maps :calendarId="calendarId" :calendarName="calendarName"></maps>
        </modal>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import {calculateEnd} from './../utils/helpers'
    import {Drag, Drop} from 'vue-drag-drop';

    import modal from './helpers/modal.vue'
    import loading from './helpers/loading.vue'
    import vueScrollingTable from 'vue-scrolling-table'

    import navi from './navi.vue'
    import panel from './panel.vue'
    import calendarTd from './calendarTd.vue'
    import preEvent from "./preEvent.vue";
    import formEvent from './forms/form-event.vue'
    import maps from './maps.vue'

    export default {
        name: 'calendars',
        components: {calendarTd, preEvent, Drag, Drop, modal, loading, formEvent, navi, panel, maps,vueScrollingTable},
        data() {
            return {
                tds: {},
                showModal: false,
                showModalMap: false,
                titleModal: '',
                calendarId: null,
                calendarName: null,
            }
        },
        created: function () {
            console.log("v1.5");
//      this.eventStateList();
//      this.zoneList();
//      this.eventTypeList();
//      this.calendarList();
            this.startList();


            this.preEventList();
        },
        mounted() {
            this.$nextTick(function () {
                window.addEventListener('scroll', this.handleWindowScroll);
                window.addEventListener('resize', this.handleCalendarPosition);
            });
            this.handleCalendarPosition();
        },
        watch: {
        },
        computed: {
            ...mapGetters([
                'getEventForm',
                'getEventIndexSelected',
                'getCellHeight',
                'getLoading',
                'getCoordinate',
                'isVisibleCalendar',
                'hasCalendars',
                'getCalendars',
                'getVisibleCalendars',
                'getPreEventById',
                'getPreEvents',
                'getEvents',
                'getEventByKey',
                'getDate',
                'getNextDate',
                'getNextDay',
                'getDay',
                'getHours',
                'getNextHours',
                'getRc',
                'getCalendarScroll',
                'getShowModalForm'
            ]),
            getStyleHeaderFix: function () {
                var left = this.left - this.getCalendarScroll.left;
                return 'left: ' + left + 'px';
            },
            getModalFormTitle: function (){
                if(this.getEventForm){
                    return this.getEventForm.id +'. '+this.getEventForm.title;
                }
            }
        },
        methods: {
            ...mapActions([
                'startList',
                'zoneList',
                'eventStateList',
                'eventTypeList',
                'calendarList',
                'preEventList',
                'removePreEvent',
                'pushEvent'
            ]),
            closeModalForm: function(){
                this.$store.commit('SET_SHOW_MODAL_FORM', false);
            },
            showMap: function (id, name) {
                this.calendarId = id;
                this.calendarName = name;
                this.showModalMap = true;
            },
            onForceUpdate() {
                console.log("forceUpdate");
                this.$forceUpdate();
            },
            removeEvent: function () {
                //TODO
                console.log('todo');
            },
            handleCalendarPosition: function () {
                this.top = this.$refs.zfcCalendars.getBoundingClientRect().top;
                this.left = this.$refs.zfcCalendars.getBoundingClientRect().left;
                this.$store.commit('SET_CALENDAR_POSITION', {top: this.top, left: this.left});
            },
            handleCalendarScroll: function (e) {
                var target = null;
                if(e.target != undefined){
                    target = e.target;
                }else{
                    target = e.srcElement;
                }
                this.$store.commit('SET_CALENDAR_SCROLL', {top: target.scrollTop, left: target.scrollLeft});
            },
            handleWindowScroll: function (e) {
                var target = null;
                if(e.target != undefined){
                    target = e.target;
                }else{
                    target = e.srcElement;
                }
                this.$store.commit('SET_BODY_SCROLL', {
                    top: target.scrollTop || window.pageYOffset,
                    left: target.scrollLeft || window.pageXOffset
                });
            },
        }

    }
</script>

<style scoped>

    .zfc-main-container {
        height: 100vh;
        max-height: 100vh;
    }

    .zfc-calendars-parent {
        height: 88%;
        padding: 0;
    }

    .zfc-calendars {
        overflow-y: auto;
        overflow-x: auto;
        height: 95%;
        margin: 0;
        padding: 0;
        position: relative;
    }

    .zfc-column-calendar {
        width: 260px !important;
        min-width: 260px !important;
        max-width: 260px !important;
        position: relative;
    }

    .zfc-column-hours {
        width: 50px !important;
        min-width: 50px;
        max-width: 50px;
    }



    .zfc-header-table{
        position: fixed;
        z-index: 11;
    }

    .zfc-header-table th {
        background-color: #0e2c44 !important;
        color: #ffffcc;

    }

    table.zfc-td td:first-child,
    table.zfc-td th:first-child {
        position: -webkit-sticky;
        position: sticky;
        left:0;
        z-index: 30;
        background-color: #FAFAFA;
        border: 1px solid #d9d9d9;
    }

    table.zfc-td {
        margin-top: 28px;
    }

    table.zfc-td > tbody > tr > td, table.zfc-td > tbody > tr > th {
        font-size: 14px;
        padding: 0;
        margin: 0;
        border: 1px solid #d9d9d9;
        border-width: 1px !important;
    }

    .cursorPointer {
        cursor: pointer;
    }


</style>

<style>
    .lulu-theme {
        background: #ffffcc;
        background-color: #ffffcc;
        color: #0c0c0c;
        font-size: .9em;
    }

    .lulu-theme > .tippy-arrow {
        background: #ffffcc !important;
        background-color: #ffffcc !important;
        color: #ffffcc !important;
    }

    .tooltipTable {
        text-align: left;
    }

</style>

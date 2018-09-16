<template>
    <div class="zfc-main-container">
        <navi ></navi>
        <loading></loading>
        <div class="clearfix"></div>
        <div class="col-lg-2 zfc-calendars-parent" style="margin: 0; padding:0;" >
            <panel v-on:forceUpdate="onForceUpdate"></panel>
        </div>

        <div class="col-lg-10 zfc-calendars-parent">


            <table class="table-bordered table-striped table-responsive zfc-header-table" :style="getStyleHeaderFix">
                <thead>
                <tr >
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
                    <tr  v-for="hour in getHours" v-bind:key="getDate + hour">
                        <td class="zfc-column-hours">{{hour}}</td>
                        <calendarTd
                                v-for="calendar in getVisibleCalendars"
                                :key='getDate + calendar.id + hour' :ki="getDate + calendar.id + hour"
                                :calendarId="calendar.id" :name="calendar.name"
                                :date="getDate" :hour="hour"
                                :parentTop="top" :parentLeft="left"  :isNextDay="false" :day="getDay"
                                :cellHeight="cellHeight">
                        </calendarTd>
                    </tr>

                    <tr style="height: 3px;">
                        <th  class="zfc-column-hours" style="background-color: #0c0c0c ">
                        </th>

                        <td v-for="calendar in getVisibleCalendars" :key=' + calendar.id+"_nd"'
                            style="background-color: #0c0c0c ">
                        </td>
                    </tr>

                    <!--NEXTDAY-->
                    <tr  v-for="hour in getNextHours" v-bind:key="getNextDate + hour">
                        <td class="zfc-column-hours">{{hour}}</td>
                        <calendarTd
                                v-for="calendar in getVisibleCalendars"
                                :key=' getNextDate + calendar.id + hour'
                                :ki="getNextDate + calendar.id + hour"
                                :calendarId="calendar.id" :name="calendar.name"
                                :date="getNextDate" :hour="hour"
                                :parentTop="top" :parentLeft="left"  :isNextDay="true" :day="getNextDay"
                                :cellHeight="cellHeight">
                        </calendarTd>
                    </tr>

                    </tbody>
                </table>


            </div>
        </div>


        <modal :title="getModalFormTitle" :showModal="showModalForm" @close="closeModalForm">
            <form-event :calendars="getCalendars" v-model="eventSelected"
                        :index="eventIndexSelected" v-on:remove="removeEvent"/>
        </modal>

        <modal :title="'Mapa: '+calendarName" :showModal="showModalMap" @close="showModalMap = false">
            <maps :calendarId="calendarId" :calendarName="calendarName"></maps>
        </modal>
    </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';

    import {Drag, Drop} from 'vue-drag-drop';

    import modal from './../components/helpers/modal.vue'
    import loading from './../components/helpers/loading.vue'
    import vueScrollingTable from 'vue-scrolling-table'

    import navi from './../components/TheNavi'
    import panel from './../components/ThePanel.vue'
    import calendarTd from './../components/calendarTd.vue'
    import preEvent from "./../components/preEvent.vue";
    import formEvent from './../components/forms/form-event.vue'
    import maps from './../components/maps.vue'


    export default {
        name: 'calendars',
        components: {calendarTd, preEvent, Drag, Drop, modal, loading, formEvent, navi, panel, maps, vueScrollingTable},
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
            this.startList();
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
            ...mapState([
                'showModalForm',
                'eventSelected',
                'eventIndexSelected',
                'calendarScroll',
                'cellHeight',
            ]),
            ...mapGetters([
                'isVisibleCalendar',
                'hasCalendars',
                'getCalendars',
                'getVisibleCalendars',
                'getPreEventById',
                'getDate',
                'getNextDate',
                'getNextDay',
                'getDay',
                'getHours',
                'getNextHours'
            ]),
            getStyleHeaderFix: function () {
                var left = this.left - this.calendarScroll.left;
                return 'left: ' + left + 'px';
            },
            getModalFormTitle: function () {
                if (this.eventSelected) {
                    return this.eventSelected.id + '. ' + this.eventSelected.title;
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
                'pushEvent'
            ]),
            closeModalForm: function () {
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
                if (e.target != undefined) {
                    target = e.target;
                } else {
                    target = e.srcElement;
                }
                this.$store.commit('SET_CALENDAR_SCROLL', {top: target.scrollTop, left: target.scrollLeft});
            },
            handleWindowScroll: function (e) {
                var target = null;
                if (e.target != undefined) {
                    target = e.target;
                } else {
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

    .zfc-header-table {
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
        left: 0;
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

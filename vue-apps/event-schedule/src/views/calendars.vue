<template>

    <v-app>
        <loading></loading>
        <v-navigation-drawer
                persistent
                :mini-variant="miniVariant"
                :clipped="clipped"
                v-model="drawer"
                enable-resize-watcher
                fixed
                app
        >


            <panel></panel>

        </v-navigation-drawer>

        <!--TOP Menu-->
        <v-toolbar app :clipped-left="clipped" >
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title v-text="title"></v-toolbar-title>
            <!--<v-spacer></v-spacer>-->

            <day v-model="getDate"></day>

            <div class="navbar-form navbar-left">
                <div class="form-group">
                    <select-size></select-size>
                </div>
            </div>

            <div class="navbar-form navbar-left">
                <div class="form-group">
                    <select-start></select-start>
                </div>
            </div>

            <v-btn icon href="/">
                <v-icon>home</v-icon>
            </v-btn>


        </v-toolbar>


        <!--Contenido-->
        <v-content>


            <div class="zfc-main-container">

                <!--HEADER-->

                <table class="table-bordered table-striped table-responsive zfc-header-table"
                       :style="getStyleHeaderFix"
                      >
                    <thead>
                    <tr>
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
                        <tr v-for="hour in getHours" v-bind:key="getDate + hour">
                            <td class="zfc-column-hours">{{hour}}</td>
                            <calendarTd
                                    v-for="calendar in getVisibleCalendars"
                                    :key='getDate + calendar.id + hour' :ki="getDate + calendar.id + hour"
                                    :calendarId="calendar.id" :name="calendar.name" :user="calendar.user"
                                    :date="getDate" :hour="hour"
                                    :isNextDay="false" :day="getDay"
                                    :cellHeight="cellHeight">
                            </calendarTd>
                        </tr>

                        <tr style="height: 3px;">
                            <th class="zfc-column-hours" style="background-color: #0c0c0c ">
                            </th>

                            <td v-for="calendar in getVisibleCalendars" :key=' + calendar.id+"_nd"'
                                style="background-color: #0c0c0c ">
                            </td>
                        </tr>

                        <!--NEXTDAY-->
                        <tr v-for="hour in getNextHours" v-bind:key="getNextDate + hour">
                            <td class="zfc-column-hours">{{hour}}</td>
                            <calendarTd
                                    v-for="calendar in getVisibleCalendars"
                                    :key=' getNextDate + calendar.id + hour'
                                    :ki="getNextDate + calendar.id + hour"
                                    :calendarId="calendar.id" :name="calendar.name" :user="calendar.user"
                                    :date="getNextDate" :hour="hour"
                                    :isNextDay="true" :day="getNextDay"
                                    :cellHeight="cellHeight">
                            </calendarTd>
                        </tr>

                        </tbody>
                    </table>

                </div>


                <modal :title="getModalFormTitle" :showModal="showModalForm" @close="closeModalForm">
                    <form-event :calendars="getCalendars" v-model="eventSelected"
                                :index="eventIndexSelected" v-on:remove="removeEvent"/>
                </modal>

                <modal :title="'Mapa: '+calendarName" :showModal="showModalMap" @close="showModalMap = false">
                    <maps :calendarId="calendarId" :calendarName="calendarName"></maps>
                </modal>

            </div>
        </v-content>


    </v-app>


</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';

    import {Drag, Drop} from 'vue-drag-drop';

    import modal from './../components/helpers/modal.vue'
    import loading from './../components/helpers/loading.vue'
    import vueScrollingTable from 'vue-scrolling-table'

    import TheToolbar from './../components/TheToolbar'
    import panel from './../components/ThePanel.vue'
    import calendarTd from './../components/calendarTd.vue'
    import preEvent from "./../components/preEvent.vue";
    import formEvent from './../components/forms/form-event.vue'
    import maps from './../components/maps.vue'
    import day from './../components/day'

    import SelectSize from './../components/input/SelectSize.vue'

    import SelectStart from './../components/input/SelectStart.vue'

    export default {
        name: 'calendars',
        components: {
            SelectSize,
            SelectStart,
            calendarTd,
            preEvent,
            Drag,
            Drop,
            modal,
            loading,
            formEvent,
            TheToolbar,
            panel,
            maps,
            day,
            vueScrollingTable
        },
        data() {
            return {
                //Vuetify
                clipped: false,
                drawer: true,
                fixed: false,
                miniVariant: false,
                right: true,
                rightDrawer: false,
                title: '',
                //TOLBAR
                //Others
                tds: {},
                showModal: false,
                showModalMap: false,
                titleModal: '',
                calendarId: null,
                calendarName: null,

            }
        },
        created: function () {
            console.log("v2.0");
            this.startList();
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
                var left = 0 - this.calendarScroll.left;
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
            removeEvent: function () {
                //TODO
                console.log('todo');
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

        }

    }
</script>

<style scoped>

    .zfc-main-container {
        height: 90vh;
        max-height: 90vh;
        position: relative;
    }

    .zfc-header-table {
        position: absolute;
        z-index: 2;
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
        text-align: center;
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

<template>

<div >

    <form  v-if="value" method="POST" class="eventForm" name="EventForm" v-on:submit.prevent="save">
        <alert :show="h.alertShow" :msg="h.alertMsg" :type="h.alertType" v-on:close="h.alertShow = false"></alert>
        <saveStatus :isSaved="h.isSaved"></saveStatus>

        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="control-label">Estado</label>
                <select name="state" class=" form-control" v-model="value.state" @change="unsaved">
                    <option v-for="state in getEventStates"
                            v-bind:value="state.id" :key="state.id"
                            :selected="value.state == state.id">
                        {{state.name}}
                    </option>
                </select>
                <fe :errors="errors.calendar"/>
            </div>
        </div>


        <div class="form-group">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="control-label">Calendario</label>
                <select name="calendar" class=" form-control" v-model="value.calendar" @change="unsaved">
                    <option value=""></option>
                    <option v-if="hasCalendars" v-for="calendar in getCalendars"
                            v-bind:value="calendar.id" :key="calendar.id"
                            :selected="value.calendar == calendar.id">
                        {{calendar.name}}
                    </option>
                </select>
                <fe :errors="errors.calendar"/>
            </div>
        </div>


        <div class="form-group">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="control-label">Titulo</label>
                <input type="text" name="title" class=" form-control" v-model="value.title" ref="title"
                       @keydown="unsaved">
                <fe :errors="errors.title"/>
            </div>


        </div>

        <!--<div class="form-group">-->
        <!--<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">-->
        <!--<label class="control-label">Ubicación</label>-->
        <!--</div>-->


        <!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">-->
        <!--<input type="text" name="location" class=" form-control" v-model="value.location" ref="location"-->
        <!--@keydown="unsaved">-->
        <!--<fe :errors="errors.location"/>-->
        <!--</div>-->
        <!--</div>-->

        <div class="form-group">

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">
                <label class="control-label">Inicio</label>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <input type="datetime" name="start" class=" form-control" ref="start"
                       v-model="value.start" @keyup="refreshEnd" @change="refreshEnd">
                <fe :errors="errors.start"/>
            </div>

        </div>


        <div class="form-group">

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">
                <label class="control-label">Duración</label>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <input type="number" name="duration" class=" form-control" ref="duration"
                       v-model="value.duration" @keyup="refreshEnd" @change="refreshEnd">
                <fe :errors="errors.duration"/>
            </div>

        </div>

        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">
                <label class="control-label">Fin</label>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <input disabled="disabled" type="datetime" name="end" class=" form-control" ref="end"
                       v-model="value.end" @keydown="unsaved">
                <fe :errors="errors.end"/>
            </div>

        </div>

        <div class="form-group">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="control-label">Comentarios</label>
                <textarea name="comments" class=" form-control" v-model="value.comments" ref="comments"
                          @keydown="unsaved"></textarea>
                <fe :errors="errors.comments"/>
            </div>

        </div>


        <div class="col-lg-12 col-xs-12">
            <button name="submitbtn" class="btn " :class="h.submitClass" v-if="!h.isSaved"
                    :disabled="h.submitInProgress">{{h.submitValue}}
            </button>
        </div>
    </form>
    <div v-else class="text-center">
        <span>Sin evento seleccionado</span>
    </div>

</div>

</template>


<script>
    import {mapGetters, mapActions} from 'vuex';
    import {HTTP} from './../../utils/http-client'
    import {calculateEnd} from './../../utils/helpers'
    import fe from '../helpers/form-errors.vue'
    import saveStatus from '../helpers/save-status.vue'
    import alert from '../helpers/alert.vue'


    import moment from 'moment'
    import momenttz from 'moment-timezone'
    import 'moment/locale/es';


    export default {
        name: 'form-event',
        props: ['index', 'value', 'isSaved', 'calendars'],
        components: {fe, saveStatus, alert},
        data() {
            return {
                errors: [],
                h: {
                    loading: false,
                    isSaved: true,
                    submitInProgress: false,
                    alertShow: false,
                    alertMsg: '',
                    alertType: 'alert-danger',
                    submitValue: 'Guardar',
                    submitClass: 'btn-primary'
                },
                msjEventMove: ''
            }
        },
        computed: {
            ...mapGetters([
                'getEventStates',
                'getEventTypes',
                'getCalendars',
                'hasCalendars',
                'getLoading',
                'getEventIndexById'
            ]),
            getEvent: function () {
                return this.value;
            }
        },
        methods: {
            ...mapActions([
                'updateEvent'
            ]),
            unsaved: function () {
                this.h.isSaved = false
            },
            refreshEnd: function () {
                this.value.end = calculateEnd(this.value.start, this.value.duration)
                this.unsaved()
            },
            iSave: function () {
                this.h.alertShow = false
                this.h.alertMsg = ''
                this.h.submitValue = 'Guardando..'
                this.h.submitClass = 'btn-warning'
                this.errors = ''
                this.h.submitInProgress = true
            },
            fSave: function () {
                this.h.submitValue = 'Guardar'
                this.h.submitClass = 'btn-primary'
                this.h.submitInProgress = false
            },
            save: function () {
                if (this.value.id) {
                    this.update()
                } else {
                    this.create()
                }
            },
            setHour: function () {
                this.value.hour = moment(this.value.start).format("HH:mm");
            },
            update: function () {
                this.setHour();
                this.iSave();
                this.$store.commit('LOADING_PLUS');

                HTTP.put("events/" + this.value.id, this.value
                ).then((response) => {
                    this.fSave();
                    this.$store.commit('UPDATE_EVENT', {index: this.getEventIndexById(this.value.id), event: this.value});
                    this.$store.commit('LOADING_LESS');

                    if (this.value.calendar == null || this.value.calendar == undefined || this.value.calendar == "") {
                        this.$store.commit('REMOVE_EVENT', this.index);
                        this.$store.commit('ADD_PRE_EVENT', this.value);
                        this.$store.commit('SET_EVENT_SELECTED', null);
                        this.$store.commit('SET_EVENT_FORM', null);
                        this.$store.commit('SET_EVENT_INDEX', null);
                        this.$emit('closeModal');
                    }

                }).catch((error) => {
                    this.fSave()
                    this.h.alertMsg = error.response.data.message;
                    this.h.alertShow = true;
                    this.errors = error.response.data.errors;
                    this.$store.commit('LOADING_LESS');
                })
            }
        }
    }
</script>

<style scoped>
    .eventForm label {
        font-size: 12px;
        color: #1c2529;
    }
</style>
<template>

    <form v-if="value" method="POST" class="eventForm" name="EventForm" v-on:submit.prevent="save">

        <v-container grid-list-md class="pt-0">
            <v-layout row wrap>
                <v-flex xs12>
                    <alert :show="h.alertShow" :msg="h.alertMsg" :type="h.alertType"
                           v-on:close="h.alertShow = false"></alert>
                    <saveStatus :isSaved="h.isSaved"></saveStatus>
                </v-flex>
            </v-layout>

            <v-layout row wrap>

                <v-flex xs4>
                    <h5 class="caption font-weight-bold">Cliente</h5>
                    <h6 class="caption">{{value.client}}</h6>

                </v-flex>

                <v-flex xs4>
                    <h5 class="caption font-weight-bold">Sucursal</h5>
                    <h6 class="caption">{{value.branchOffice}}</h6>

                </v-flex>


                <v-flex xs4>
                    <h5 class="caption font-weight-bold">Dirección</h5>
                    <h6 class="caption">{{value.location}}</h6>

                </v-flex>

                <v-flex xs12> <v-divider class="ma-0"></v-divider></v-flex>

            </v-layout>

            <v-layout row wrap>
                <v-flex xs4>

                    <v-text-field

                            label="Titulo"
                            v-model="value.title"
                            ref="title"
                            @keydown="unsaved"
                            :error-messages="errors.title"
                    >

                    </v-text-field>

                </v-flex>

                <v-flex xs4>
                    <v-select
                            label="Estado"
                            :items="eventStates"
                            item-text="name"
                            item-value="id"
                            v-model="value.state"
                            @change="unsaved"
                    >
                    </v-select>
                </v-flex>


                <v-flex xs4>
                    <v-select
                            label="Calendario"
                            :items="getCalendars"
                            item-text="name"
                            item-value="id"
                            v-model="value.calendar"
                            @change="unsaved"
                    >
                    </v-select>
                </v-flex>





                <v-flex xs4 >

                    <v-menu
                            ref="menuStartDate"
                            :close-on-content-click="true"
                            :nudge-right="40"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                    >
                        <v-text-field
                                slot="activator"
                                v-model="startDate"
                                label="Fecha de Inicio"
                                readonly

                                :value="value.startDate"
                                ref="start"
                                :error-messages="errors.start"
                                @keyup="refreshEnd"
                                @change="refreshEnd"

                        ></v-text-field>
                        <v-date-picker v-model="startDate" ></v-date-picker>

                    </v-menu>


                </v-flex>

                <v-flex xs4>
                    <v-menu
                            ref="menuStartTime"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            max-width="290px"
                            min-width="290px"
                    >
                        <v-text-field
                                slot="activator"
                                v-model="startTime"
                                label="Hora de Inicio"
                                readonly
                        ></v-text-field>
                        <v-time-picker
                                v-model="startTime"
                                format="24hr"
                                full-width
                        >
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" @click="$refs.menuStartTime.save(startTime)">OK</v-btn>

                        </v-time-picker>
                    </v-menu>
                </v-flex>

                <v-flex xs4>

                    <v-text-field
                            v-model="value.duration"
                            ref="duration"
                            @keyup="refreshEnd"
                            @change="refreshEnd"
                            :error-messages="errors.duration"
                            label="Duración"
                    >

                    </v-text-field>

                </v-flex>


                <v-flex xs4>

                    <v-text-field
                            v-model="value.end"
                            ref="end"
                            @keydown="unsaved"
                            :error-messages="errors.end"
                            :disabled="true"
                            label="Fecha de Fin"
                    >

                    </v-text-field>

                </v-flex>


                <v-flex xs4>

                    <v-text-field
                            v-model="value.deliveryNote"
                            ref="deliveryNote"
                            @keydown="unsaved"
                            :error-messages="errors.deliveryNote"
                            label="Remito"
                    >

                    </v-text-field>

                </v-flex>

                <v-flex xs4>
                </v-flex>

                <v-flex xs12>

                    <v-textarea
                            name="comments"
                            label="Comentarios"
                            ref="comments"
                            v-model="value.comments"
                            @keydown="unsaved"
                            :error-messages="errors.comments"
                            rows="2"
                    ></v-textarea>

               </v-flex>
            </v-layout>
            <v-layout row wrap justify-end>
                <v-flex xs3 class="text-xs-right pa-0">
                    <v-btn class="text-xs-right"
                            :disabled="h.submitInProgress"
                            @click="save"
                    >
                        {{h.submitValue}}
                    </v-btn>

                </v-flex>
            </v-layout>

        </v-container>
    </form>
    <div v-else class="text-center">
        <span>Sin evento seleccionado</span>
    </div>


</template>


<script>
    import {mapGetters, mapActions, mapState} from 'vuex';
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
                startDate: '',
                startTime: '00:00',
                msjEventMove: ''
            }
        },
        mounted: function(){
            this.startDate = this.value.start.substr(0,10)
            this.startTime= this.value.start.substr(11,5)
        },
        watch: {
          startDate: function(){
              this.value.start = this.startDate+' '+this.startTime
          },
          startTime: function(){
              this.value.start = this.startDate+' '+this.startTime
          }
        },
        computed: {
            ...mapState([
                'eventStates'
            ]),
            ...mapGetters([
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

                //TODO LOADING
                this.$store.commit('LOADING_PLUS');

                HTTP.put("events/" + this.value.id, this.value
                ).then((response) => {
                    this.fSave();
                    this.$store.commit('LOADING_LESS');

                    if (this.value.calendar) {
                        this.$store.commit('UPDATE_EVENT', {
                            index: this.getEventIndexById(this.value.id),
                            event: this.value
                        });
                        this.$store.commit('SET_SHOW_MODAL_FORM', false);
                    } else {
                        this.$store.commit('REMOVE_EVENT', this.getEventIndexById(this.value.id));
                        this.$store.commit('ADD_PRE_EVENT', this.value);
                        this.$store.commit('SET_EVENT_ID_SELECTED', null);
                        this.$store.commit('SET_EVENT_SELECTED', null);
                        this.$store.commit('SET_EVENT_INDEX_SELECTED', null);
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
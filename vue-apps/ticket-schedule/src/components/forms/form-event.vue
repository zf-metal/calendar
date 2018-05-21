<template>


    <form method="POST" name="EventForm" v-on:submit.prevent="save">
        <alert :show="h.alertShow" :msg="h.alertMsg" :type="h.alertType" v-on:close="h.alertShow = false"></alert>
        <saveStatus :isSaved="h.isSaved"></saveStatus>

        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">

                    <label class="control-label">Calendario</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <select name="state" class=" form-control" v-model="entity.calendar" @change="unsaved">
                        <option v-if="calendars" v-for="calendar in calendars"
                                v-bind:value="calendar.id" :key="calendar.id"
                                :selected="entity.calendar == calendar.id">
                            {{calendar.name}}
                        </option>
                    </select>
                    <fe :errors="errors.calendar"/>
                </div>
            </div>
        </div>


        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group">

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">

                    <label class="control-label">Titulo</label>
                </div>

                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <input type="text" name="title" class=" form-control" v-model="entity.title" ref="title"
                           @keydown="unsaved">
                    <fe :errors="errors.title"/>
                </div>


            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">
                    <label class="control-label">Ubicación</label>
                </div>


                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <input type="text" name="location" class=" form-control" v-model="entity.location" ref="location"
                           @keydown="unsaved">
                    <fe :errors="errors.location"/>
                </div>


            </div>
        </div>


        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group">

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">
                    <label class="control-label">Inicio</label>
                </div>

                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <input type="datetime" name="start" class=" form-control" ref="start"
                           v-model="entity.start" @keydown="unsaved">
                    <fe :errors="errors.start"/>
                </div>

            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">
                    <label class="control-label">Fin</label>
                </div>

                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <input type="datetime" name="end" class=" form-control" ref="end"
                           v-model="entity.end" @keydown="unsaved">
                    <fe :errors="errors.end"/>
                </div>


            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label">
                    <label class="control-label">Descripcion</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <textarea name="description" class=" form-control" v-model="entity.description" ref="description"
                          @keydown="unsaved"></textarea>
                    <fe :errors="errors.description"/>
                </div>

            </div>
        </div>

        <div class="col-lg-12 col-xs-12">
            <button name="submitbtn" class="btn " :class="h.submitClass" v-if="!h.isSaved"
                    :disabled="h.submitInProgress">{{h.submitValue}}
            </button>
        </div>
    </form>
</template>


<script>
  import fe from '../helpers/form-errors.vue'
  import saveStatus from '../helpers/save-status.vue'
  import alert from '../helpers/alert.vue'
  import axios from 'axios'


  export default {
    name: 'form-event',
    props: ['value', 'isSaved','calendars'],
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
        entity: {}
      }
    },
    mounted: function () {
      this.$refs.title.focus()
    },
    methods: {
      populate: function (data) {
        this.entity.id = data.id
        this.entity.title = data.title
        this.entity.description = data.description
        this.entity.start = data.start
        this.entity.end = data.end
        this.entity.calendar = data.calendar
      },
      unsaved: function () {
        this.h.isSaved = false
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
        if (this.entity.id) {
          this.update()
        } else {
          this.create()
        }
      },
      create: function () {
        axios.post("/zfmc/api/events", this.entity
        ).then((response) => {
          this.entity.id = response.data.id
          this.h.submitInProgress = false
          this.$emit("eventCreate", this.entity)
        }).catch((error) => {
          this.h.submitInProgress = false
          this.errors = error.response.data.errors

        })
      },
      update: function () {
        this.iSave()
        axios.put("/zfmc/api/events/" + this.entity.id, this.entity
        ).then((response) => {
          this.fSave()
          this.$emit("eventUpdate", this.entity)
        }).catch((error) => {
          this.fSave()
          this.h.alertMsg = error.response.data.message
          this.h.alertShow = true
          this.errors = error.response.data.errors

        })
      }
    },
    created: function () {
      this.entity = this.value
    },
  }
</script>

<template>
    <Drag :transfer-data="{id: $vnode.key, type: 'e'}"
          :class="getMainClass" :style="getStyle" >
        <div class="" style="padding: 3px; height: 100%;" @click="selectEvent">
            <span @click="edit">
                <!--<i class="material-icons zfc-type-icon pull-left">{{getEventTypeIcon(type)}}</i>-->
                {{id}}. {{title}}</span>
            <span class="pull-right">{{getDistanceFromEventSelected(lat,lng)}} Km</span>
            <br>

            <table class="table">
                <tbody>
                <tr>
                    <td><i class="material-icons" style="vertical-align: bottom;">account_box</i></td>
                    <td>{{getCliente}}</td>
                </tr>
                <tr>
                    <td :style="getSucColor"><i class="material-icons" style="vertical-align: bottom;">business</i></td>
                    <td>{{getLocation}}  </td>
                </tr>
                </tbody>
            </table>

            <div v-html="description">
            </div>
        </div>

    </Drag>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import axios from "axios"
  import moment from 'moment'
  import 'moment/locale/es';


  import {Drag, Drop} from 'vue-drag-drop';

  export default {
    name: 'event',
    props: [
      'index',
      'id',
      'title',
      'description',
      'calendar',
      'ticketId',
      'hour',
      'top',
      'left',
      'duration',
      'start',
      'end',
      'state',
      'type',
      'lat',
      'lng',
      'zone',
      'client',
      'location',
      'serviceDescription'
    ],
    components: {Drag},
    data() {
      return {}
    },
    methods: {
      edit: function () {
        this.$emit("editEvent", this.index);
      },
      selectEvent: function(){
        this.$store.commit('SET_EVENT_SELECTED',this.index);
      }
    },
    computed: {
      ...mapGetters([
        'getCellHeight',
        'getZoneBgColor',
        'getEventStates',
        'getEventStateBgColor',
        'getEventTypeIcon',
        'getIndexEventSelected',
        'getDistanceFromEventSelected'
      ]),
      getCliente: function(){
        if(this.client != undefined){
          return this.client;
        }
        return "";
      },
      getLocation: function(){
        if(this.location != undefined){
          return this.location;
        }
        return "";
      },
      getSucColor: function (){
        if(this.zone != undefined && this.zone.id != undefined) {
          return "background-color:" + this.getZoneBgColor(this.zone.id);
        }
        return "";
      },
      getMainClass: function () {
        if(this.getIndexEventSelected == this.index) {
          return 'zfc-event zfc-event-selected';
        }else{
          return 'zfc-event';
        }
      },
      getStyle: function () {
        return 'background-color:' + this.getEventStateBgColor(this.state) + '; top: ' + this.top + 'px;' + ' left: ' + this.left + 'px;' + ' height:' + this.getHeight + "px;";
      },
      getHeight: function () {
        var height = this.getCellHeight;
        if (this.duration > 30) {
          height = Math.ceil(this.duration / 30) * this.getCellHeight;
        }

        return height
      }
    }
  }
</script>

<style scoped>

    .table{
        margin:0;
    }

    .table td{
        vertical-align: middle;
        padding: 3px;
    }


    .zfc-event {
        position: absolute;
        overflow: hidden;
        display: block;
        font-size: .85em;
        line-height: 1.3;
        border-radius: 3px;
        border: 1px solid #5c6667;
        background: #1c5c87;
        color: #FFFFFF;
        z-index: 10;
        min-width: 254px;
        width: 254px;
        min-height: 40px;
    }

    .zfc-event-selected {
        border: 3px solid #01FF70;
    }

    .zfc-edit-btn {
        font-size: 10px;
        color: #ffffff;
        padding: 1px;
    }

    .zfc-type-icon {
        font-size: 10px;
        color: #ffffff;
        padding: 1px;
    }

</style>

<template>
    <Drag :transfer-data="{id: $vnode.key, type: 'e'}"
          :class="getMainClass" :style="getStyle" >
        <div class="" style="padding: 3px; height: 100%;" @click="selectEvent">
            <!--<div class="col-lg-3">-->
            <!--<a class="btn btn-xs"> </a>-->
            <!--</div>-->
            <span @click="edit"><i class="material-icons zfc-edit-btn" @click="edit">edit</i> {{id}} - {{title}}</span>
            <i class="material-icons zfc-type-icon pull-right">{{getEventTypeIcon(type)}}</i>
            <br>
            <span>{{getDistanceFromEventSelected(lat,lng)}} Km</span>

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
      'lng'
    ],
    components: {Drag},
    data() {
      return {}
    },
    created: function () {
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
        'getEventStates',
        'getEventStateBgColor',
        'getEventTypeIcon',
        'getIndexEventSelected',
        'getDistanceFromEventSelected'
      ]),
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
        var height = 25;
        if (this.duration > 30) {
          height = Math.ceil(this.duration / 30) * 25;
        }
        if (height > 600) {
          height = 600
        }
        return height
      }
    }
  }
</script>

<style scoped>

    .zfc-event {
        position: absolute;
        display: block;
        font-size: .85em;
        line-height: 1.3;
        border-radius: 3px;
        border: 1px solid #5c6667;
        background: #1c5c87;
        color: #FFFFFF;
        z-index: 10;
        min-width: 160px;
        width: 160px;
        min-height: 25px;
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

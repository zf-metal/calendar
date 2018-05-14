<template>
    <Drag :transfer-data="{id: $vnode.key , type: 'e'}" :class="getMainClass" :style="getStyle">
        <span>{{ticketId}}</span>
    </Drag>
</template>

<script>
  import axios from "axios"
  import moment from 'moment'
  import 'moment/locale/es';


  import {Drag, Drop} from 'vue-drag-drop';

  export default {
    name: 'event',
    props: ['date', 'calendar', 'ticketId', 'hour','top','left'],
    components: {Drag},
    data() {
      return {
        id: '',
        duration: 50,
        title: '',
        description: '',
      }
    },
    created: function () {
    },
    methods: {},
    computed: {
      getMainClass: function () {
        return 'zfc-event'
      },
      getStyle: function () {
        return 'top: '+this.getTop+ 'px;' + ' left: '+this.getLeft+ 'px;' + ' height:' + this.getHeight+ "px;";
      },
      getTop: function(){
        return this.top;
      },
      getLeft: function(){
        return this.left;
      },
      start: function(){
        var start = moment(this._date.format("YYYY-MM-DD")+ " "+ this.hour);
        return start;
      },
      end: function(){
        var end = moment(this._date.format("YYYY-MM-DD")+ " "+ this.hour);
        return end.add(this.duration, "minutes");
        return end;
      },
      getHeight: function(){
        if(this.duration <= 30) {
          return 25;
        }else{
          return  Math.ceil(this.duration / 30) * 25;
        }

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
        border: 1px solid #3a87ad;
        background: #1c5c87;
        color: #FFFFFF;
        min-height: 25px;
        z-index: 10;
        min-width: 160px;
        min-height: 25px;
    }

</style>

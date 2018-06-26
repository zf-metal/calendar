<template>
    <drag :transfer-data="{obj: obj, index:index, type: 't'}" :draggable="isDraggable" >
        <div class="zfc-pre-event" :class="{'zfc-pre-event-a' : !isDraggable}">
            <span> {{obj.id}} - {{obj.title}} </span>

            <i class="material-icons zfc-pre-type-icon pull-right">{{getEventTypeIcon(obj.type)}} </i>
        </div>
    </drag>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import {Drag, Drop} from 'vue-drag-drop';

  export default {
    name: 'preEvent',
    props: ['preEvent','index'],
    components: {Drag, Drop},
    data() {
      return {
        obj: {
          id: '',
          calendar: '',
          title: '',
          location: '',
          description: '',
          state: '',
          type: '',
          time: 60
        }
      }
    },
    created: function () {
      this.obj = this.preEvent
    },
    methods: {
    },
    computed: {
      ...mapGetters([
        'getEventStates',
        'getEventStateBgColor',
        'getEventTypeIcon'
      ]),
      isDraggable: function(){
        if(this.obj.calendar == null){
          return true;
        }else{
          return false;
        }
      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .zfc-pre-event {
        border-radius: 3px;
        border: 1px solid #5c6667;
        padding: 3px;
        margin: 2px;
    }

    .zfc-type-icon {
        font-size: 10px;
        color: #000000;
        padding: 1px;
    }

</style>

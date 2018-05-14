<template>
    <drag :transfer-data="{id: obj.id,type: 't'}" :draggable="isDraggable" >
        <div class="zfc-ticket" :class="{'zfc-ticket-a' : !isDraggable}">
            {{obj.id}} - {{obj.subject}}
        </div>
    </drag>
</template>

<script>

  import {Drag, Drop} from 'vue-drag-drop';

  export default {
    name: 'ticket',
    props: ['ticket','event'],
    components: {Drag, Drop},
    data() {
      return {
        obj: {
          id: '',
          subject: '',
          time: 60
        }
      }
    },
    created: function () {
      this.obj = this.ticket;
    },
    methods: {
    },
    computed: {
      isDraggable: function(){
        if(this.event == null){
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
    .zfc-ticket {
        border-radius: 3px;
        border: 1px solid #5c6667;
        padding: 3px;
        margin: 2px;
    }

    .zfc-ticket-a{
        background: #5c6667;
    }

</style>

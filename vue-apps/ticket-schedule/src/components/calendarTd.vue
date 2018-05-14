<template>
    <td class="zfc-column-calendar">
        <drop @drop="handleDrop" class="zfc-dropcell">
        </drop>
    </td>
</template>

<script>
  import {Drag, Drop} from 'vue-drag-drop';

  export default {
    name: 'calnedarTd',
    props: ['id', 'name', 'hour', 'parentTop', 'parentLeft'],
    components: {Drag, Drop},
    data() {
      return {}
    },
    methods: {
      handleDrop: function (data) {
        var top = this.$el.getBoundingClientRect().top - this.parentTop;
        var left = this.$el.getBoundingClientRect().left - this.parentLeft + 10;
        if (data.type != undefined && data.type == 't') {
          this.$emit("dropForNewEvent",  {id: this.id, name: this.name}, data.id, this.hour, top, left);
        }
        if (data.type != undefined && data.type == 'e') {
          this.$emit("dropForChangeEvent", {id: this.id, name: this.name}, data.id, this.hour, top, left);
        }
      }
      ,
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .zfc-dropcell {
        height: 100%;
    }
</style>

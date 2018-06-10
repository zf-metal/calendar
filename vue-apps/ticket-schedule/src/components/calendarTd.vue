<template>
    <td class="zfc-column-calendar" :id="tid">
        <drop @drop="handleDrop" class="zfc-dropcell">
        </drop>
    </td>
</template>

<script>
  import {Drag, Drop} from 'vue-drag-drop';

  export default {
    name: 'calnedarTd',
    props: ['calendarId', 'tid', 'name', 'hour', 'parentTop', 'parentLeft'],
    components: {Drag, Drop},
    data() {
      return {}
    },
    mounted: function () {
    },
    methods: {
      handleDrop: function (data) {
        if (data.type != undefined && data.type == 't') {
          data.obj.calendar = this.calendarId;
          data.obj.hour = this.hour;
          this.$emit("dropForNewEvent", data.obj,data.index, this.getTop, this.getLeft);
        }
        if (data.type != undefined && data.type == 'e') {
          this.$emit("dropForChangeEvent", this.calendarId, data.id,  this.hour, this.getTop, this.getLeft);
        }
      },
    },
    computed: {
      getTop: function () {
        return this.$el.getBoundingClientRect().top - this.parentTop;
      },
      getLeft: function () {
        return this.$el.getBoundingClientRect().left - this.parentLeft + 10;
      },
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .zfc-dropcell {
        height: 100%;
    }
</style>

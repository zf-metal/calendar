<template>
    <td class="zfc-column-calendar" :id="tid">
        <drop @drop="handleDrop" class="zfc-dropcell">
        </drop>
    </td>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex';
  import {Drag, Drop} from 'vue-drag-drop';

  export default {
    name: 'calnedarTd',
    props: ['calendarId', 'tid', 'name', 'hour', 'parentTop', 'parentLeft','rc'],
    components: {Drag, Drop},
    data() {
      return {
        top: 0,
        left: 0,
      }
    },
    mounted: function () {
      this.calculateTop();
      this.calculateLeft();
    },
    methods: {
      handleDrop: function (data) {
        if (data.type != undefined && data.type == 't') {
          data.obj.calendar = this.calendarId;
          data.obj.hour = this.hour;
          this.$emit("dropForNewEvent", data.obj,data.index);
        }
        if (data.type != undefined && data.type == 'e') {
          this.$emit("dropForChangeEvent", this.calendarId, data.id,  this.hour);
        }
      },
      calculateTop() {
        this.top = this.$el.getBoundingClientRect().top - this.parentTop;
        this.$store.commit('SET_COORDINATE',{calendar: this.calendarId,hour:this.hour,type:'top',value:this.top});
      },
      calculateLeft() {
        this.left = this.$el.getBoundingClientRect().left - this.parentLeft + 10;
        this.$store.commit('SET_COORDINATE',{calendar: this.calendarId,hour:this.hour,type:'left',value:this.left});
      }
    },
    watch: {
      rc: function(){
        this.calculateTop()
        this.calculateLeft()
      },
      parentTop: function(){
        this.calculateTop()
      },
      parentLeft: function(){
        this.calculateLeft()
      }
    },
    computed: {
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .zfc-dropcell {
        height: 100%;
    }
</style>

<template>
    <div class="form-group">
        <input type="checkbox" :name='id' v-on:change="toggleCalendar" v-model="active"/>
        <label>{{name}}</label>
    </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';

  export default {
    name: 'checkCalendar',
    props: ['index', 'id', 'name','hidden'],
    components: {},
    data() {
      return {
        active: true,
      }
    },
    watch: {
      hidden: function(h){
        if(h == true){
          this.active = false;
        }else{
          this.active = true;
        }

      }
    },
    computed: {
      ...mapGetters([
        'getCalendars',
      ]),
    },
    methods: {
      ...mapActions([
        'showCalendar',
        'hideCalendar',
      ]),
      toggleCalendar: function () {
        if (this.hidden) {
          this.showCalendar(this.index);
        } else {
          this.hideCalendar(this.index);
        }
      }
    }
  }
</script>

<style scoped>

</style>

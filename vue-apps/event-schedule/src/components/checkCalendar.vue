<template>
    <div class="">
        <label>{{name}}</label>
        <input type="checkbox" :name='id' v-on:change="toggleCalendar" v-model="active" />
    </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';

  export default {
    name: 'checkCalendar',
    props: ['index', 'id', 'name'],
    components: {},
    data() {
      return {
        active: true,
      }
    },
    created: function () {
    },
    methods: {
      ...mapActions([
        'showCalendar',
        'hideCalendar',
      ]),
      toggleCalendar: function () {
        if(this.active){
          this.showCalendar(this.index);
        }else{
          this.hideCalendar(this.index);
        }
      }
    }
    ,
    computed: {}
  }
</script>

<style scoped>

</style>

<template>
    <div class="">
        <label>{{name}}</label>
        <input type="checkbox" :name='id' v-on:change="toggleCalendar" v-model="active" />
    </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';

  export default {
    name: 'checkZone',
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
        'showZone',
        'hideZone',
      ]),
      toggleCalendar: function () {
        if(this.active){
          this.showZone(this.index);
        }else{
          this.hideZone(this.index);
        }
      }
    }
  }
</script>

<style scoped>

</style>

<template>
  <div>

  </div>
</template>

<script>
  import helpers from '../utils/helpers'

  export default {
    name: 'calendar',
    props: ['calendar'],
    data() {
      return {
      obj:{
        id: '',
        name: '',
        schedules: [],
        events: []
      }
      }
    },
    created: function () {
      this.obj.id = this.calendar.id;

    },
    methods: {

    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>

<template>
  <div>

  </div>
</template>

<script>
import helpers from '../utils/helpers'

  export default {
    name: 'schedule',
    props: ['schedule'],
    data() {
      return {
      obj:{
        id: '',
        calendar: '',
        day: '',
        start: '',
        end: '',
        startBreak: '',
        endBreak: ''
      }
      }
    },
    created: function () {
      helperMergeStrict(this.obj,this.schedule)
    },
    methods: {

    }
  }
</script>


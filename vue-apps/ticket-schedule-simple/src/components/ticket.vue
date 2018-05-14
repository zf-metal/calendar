<template>
    <li>
       {{obj.id}} - {{obj.subject}}

    </li>
</template>

<script>

  export default {
    name: 'ticket',
    props: ['ticket'],
    data() {
      return {
      obj:{
        id: '',
        subject: ''
      }
      }
    },
    created: function () {
      this.obj = this.ticket;
    },
    methods: {

    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>

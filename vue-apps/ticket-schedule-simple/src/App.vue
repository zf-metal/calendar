<template>
    <div class="rows">
        <div class="col-lg-3">
            <tickets></tickets>
        </div>
        <div class="col-lg-9">
            <calendars></calendars>
        </div>
    </div>
</template>

<script>
  import tickets from './components/tickets.vue'
  import calendars from './components/calendars.vue'

  export default {
    name: 'App',

    components: {
      tickets,
      calendars,
    },
    created: function () {
    }
  }
</script>

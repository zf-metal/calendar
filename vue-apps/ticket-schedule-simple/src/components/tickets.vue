<template>
    <div id="tickets">
        <ul v-if="tickets" class="table">
            <ticket  v-for="ticket in tickets" :ticket="ticket" :key="ticket.id">
            </ticket>

        </ul>
    </div>
</template>

<script>

  import Ticket from "./ticket.vue";
  import axios from 'axios'

  const http = axios.create({
    baseURL: '/zfmapi/',
    timeout: 5000,
    headers: {
      accept: 'application/json'
    }
  });


  export default {
    components: {Ticket},
    name: 'tickets',
    data() {
      return {
        tickets:[]
      }
    },
    created: function () {
      this.list();
    },
    methods: {
      list: function(){
        http.get('list/ticket').then((response) => { this.tickets = response.data.data;})
      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>

<template>
  <div>
      {{service}}
  </div>
</template>

<script>
    import axios from "axios"

    export default {
        name: 'service',
        props:['service'],
        components: {},
        methods: {
          getV: function(a){
            if(this.service[a] != undefined){
              return this.service[a];
            }
            return "";
          }
        },
        computed: {}
    }
</script>

<style scoped>

    .zfc-service-ul{
        list-style: none;
        padding: 2px;
        font-size: 12px;
    }
</style>

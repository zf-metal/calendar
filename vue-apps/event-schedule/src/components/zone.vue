<template>
    <div class="card"  v-if="getPreEventsByZone(zone.id).length > 0">
        <h4 class="card-header"><i :style="getStyleColor" class="material-icons" style="vertical-align: bottom;">business</i> {{zone.name}}
            <span class="pull-right">{{getPreEventsByZone(zone.id).length}}</span>
        </h4>
        <div v-if="!zone.hidden" class="card-content">
        <preEvent v-for="(preEvent,index) in getPreEventsByZone(zone.id)" :preEvent="preEvent"
                  :key="preEvent.id" :index="index">
        </preEvent>
        </div>
    </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import preEvent from "./preEvent.vue";

  export default {
    name: 'zone',
    props: ['zone'],
    components: {preEvent},
    methods: {
    },
    computed: {
      getStyleColor: function(){
        if(this.zone.bgColor != undefined){
          return "background-color:"+this.zone.bgColor;
        }
      },
      ...mapGetters([
        'getZones',
        'getPreEventsByZone',
      ]),
    },
  }
</script>

<style scoped>
    .card {
        border: 0;
        margin-bottom: 30px;
        margin-top: 30px;
        border-radius: 6px;
        color: #333;
        background: #fff;
        width: 100%;
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, .14), 0 3px 1px -2px rgba(0, 0, 0, .2), 0 1px 5px 0 rgba(0, 0, 0, .12);
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid #eee;
        border-radius: .25rem;
    }

    .card .card-header {
        z-index: 3!important;
        padding: 1px;
        position: relative;
        border-bottom: none;
        margin: 0;
    }
</style>

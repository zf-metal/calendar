<template>

        <nav class="navbar navbar-default" style="margin: 0;">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/"><i class="material-icons">home</i>
                    </a>
                </div>




                <day v-model="getDate"></day>
                <ul class="nav navbar-nav ">
                    <li>
                    </li>
                </ul>

                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <button  class="btn btn-default material-icons">refresh</button>
                    </div>
                </form>

                <div class="navbar-form navbar-left">
                    <div class="form-group">
                        <select class="form-control" v-model="myCellHeight" v-on:change="applyCellHeight">
                            <option value="30">Min</option>
                            <option value="60">Mid</option>
                            <option value="90">Max</option>
                        </select>
                    </div>
                </div>

            </div>
        </nav>

</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import day from './day.vue'
  import loading from './helpers/loading.vue'

  export default {
    name: 'navi',
    components: {day, loading},
    data() {
      return {
        myCellHeight: 60
      }
    },
    created: function () {
      this.myCellHeight = this.getCellHeight;
    },
    methods: {
      applyCellHeight: function(){
        this.$store.commit('SET_CELL_HEIGHT',this.myCellHeight);
      }
    },
    computed: {
      ...mapGetters([
        'getCellHeight',
        'getDayName',
        'getDate',
        'getLoading'
      ]),
    },
  }
</script>
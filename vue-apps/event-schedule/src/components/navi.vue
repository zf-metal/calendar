<template>
    <div>
        <nav class="navbar navbar-default ">
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
                        <button  class="btn btn-default material-icons">calendar_today</button>
                    </div>
                </div>

            </div>
        </nav>
    </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import day from './day.vue'
  import loading from './helpers/loading.vue'

  export default {
    name: 'navi',
    components: {day, loading},
    computed: {
      ...mapGetters([
        'getDayName',
        'getDate',
        'getLoading'
      ]),
    },
  }
</script>
<template>
    <div>
        <nav class="navbar navbar-default ">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">
                        AGENDA
                    </a>
                </div>


                <ul class="nav navbar-nav ">
                    <li>

                    </li>
                </ul>

                <day v-model="getDate"></day>


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
        'getDate',
        'getLoading'
      ]),
    },
  }
</script>
<template>
    <div>
        <select class="form-control" id="filterCalendarGroup" v-on:change="changeFilterGroup" v-model="groupId">
            <option value="">Filtrar por Grupo</option>
            <template v-for="group in getCalendarsGroups">
                <option :value="group.id" :key="group.id">
                    {{group.name}}
                </option>
            </template>


        </select>
    </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';

  export default {
    name: 'filterGroupCalendar',
    props: [],
    components: {},
    data() {
      return {
        groupId: "",
      }
    },
    created: function () {
    },
    watch: {
      getGroupSelected: function (gs) {
        this.groupId = gs;
      }
    },
    methods: {
      ...mapActions([
        'setVisibleCalendarByGroup'
      ]),
      changeFilterGroup: function () {
        this.setVisibleCalendarByGroup(this.groupId);
      }
    },
    computed: {
      ...mapGetters([
        'getGroupSelected',
        'getLoading',
        'getCalendarsGroups'
      ]),
    },
  }
</script>

<style scoped>

</style>

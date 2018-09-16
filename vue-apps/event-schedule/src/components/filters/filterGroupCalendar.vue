<template>
    <div>
        <select class="form-control" id="filterCalendarGroup" v-on:change="changeFilterGroup" v-model="groupId">
            <option value="">Filtrar por Grupo</option>
            <template v-for="group in calendarGroups">
                <option :value="group.id" :key="group.id">
                    {{group.name}}
                </option>
            </template>
        </select>
    </div>
</template>

<script>
    import {mapState} from 'vuex';

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
            calendarGroupSelected: function (gs) {
                this.groupId = gs;
            }
        },
        methods: {
            setVisibleCalendarByGroup(groupSelected) {
                this.$store.commit('SET_CALENDAR_GROUP_SELECTED', groupSelected);
                for (var i = 0; i < this.calendars.length; i++) {
                    if (this.calendars[i].groups && this.calendars[i].groups.find(group => group.id == groupSelected)) {
                        this.$store.commit('SHOW_CALENDAR', i);
                    } else {
                        this.$store.commit('HIDE_CALENDAR', i);
                    }
                }
            },
            changeFilterGroup: function () {
                this.setVisibleCalendarByGroup(this.groupId);
            }
        },
        computed: {
            ...mapState([
                'calendarGroupSelected',
                'calendarGroups',
                'calendars'
            ])
        },
    }
</script>

<style scoped>

</style>

<template>

    <v-select class="pa-0" v-model="groupId" v-on:change="changeFilterGroup" :items="getItems"
              prepend-icon="filter_list">
    </v-select>

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
            getItems: function () {
                var items = []
                if(this.calendarGroups.length) {
                    this.calendarGroups.forEach(function (group) {
                        items.push({value: group.id, text: group.name})
                    })
                }
                return items
            },
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

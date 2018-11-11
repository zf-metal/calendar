<template>
    <div>
        <mini-event v-for="(event,index) in events" :index="index" :event="event" :key="index" ></mini-event>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import MiniEvent from './MiniEvent'

    export default {
        name: 'MiniCalendarCell',
        props:{
            events: {type: Array, default: null}
        },
        components: {MiniEvent},
        methods: {},
        computed: {
            ...mapGetters([
            ]),
        },
    }
</script>

<style scoped>

</style>

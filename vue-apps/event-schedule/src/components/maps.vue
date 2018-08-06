<template>
    <div id="map">

        <GmapMap
                :center="getCenter"
                :zoom="12"
                map-type-id="terrain"
                style="width: 580px; height: 250px; margin: 0 auto;"
        >

            <GmapMarker
                    :key="index"
                    v-for="(e, index) in getEventsByCalendar(calendarId)"
                    :position="getPosition(e)"
                    :clickable="true"
                    :draggable="true"
                    :title="e.start + ' - ' + e.client "
                    @click="center=m.position"
            />

        </GmapMap>

    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';


    export default {
        name: 'maps',
        props:['calendarId','calendarName'],
        components: {},
        data() {
            return {
                markers: [
                    {lat: -25.363, lng: 131.044}
                ]
            }
        },
        created: function () {
        },
        methods: {
            getPosition: function(e){
                return {lat: parseFloat(e.lat), lng: parseFloat(e.lng)};
            }

        },
        computed: {
            ...mapGetters([
                'getEventsByCalendar',
                'getEvents'
            ]),
            getCenter: function(){
                var first = this.getEventsByCalendar(this.calendarId)[0];
                if(first != undefined){
                    return {lat: parseFloat(first.lat), lng: parseFloat(first.lng)};
                }
                return {lat:-34.6037345,lng:-58.3837591};
            }

        },
    }
</script>

<style scoped>



</style>

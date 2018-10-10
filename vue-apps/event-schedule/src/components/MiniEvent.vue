<template>
    <Drag :transfer-data="{event: event, index: index, op: 'update'}" class="drago"
           :style="getDragStyle">

        <div @click="selectEvent">
            <v-card class="cursorPointer" :style="getMainStyle">

                <v-card-text class="indigo dark pa-1" >
                    {{event.id}}. {{event.title}}
                </v-card-text>

                <v-card-text class="pe-card-text pa-0">

                </v-card-text>

            </v-card>
        </div>
    </Drag>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import axios from "axios"
    import moment from 'moment'
    import 'moment/locale/es';
    import {Drag, Drop} from 'vue-drag-drop';
    import availabilityDay from './availabilityDay.vue';
    import availabilityTime from './availabilityTime.vue';
    import coop from './signals/coop.vue'
    import keep from './signals/keep.vue'
    import fav from './signals/fav.vue'

    export default {
        name:
            'MiniEvent',
        props: {
            index: Number,
            event: Object
        },
        components: {Drag, availabilityDay, availabilityTime, coop, keep, fav},
        data() {
            return {
                active: false,
            }
        },
        methods: {

        },
        computed: {

        }
    }
</script>


<style scoped>



</style>

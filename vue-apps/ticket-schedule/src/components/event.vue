<template>
    <Drag :transfer-data="{id: $vnode.key, type: 'e'}" :class="getMainClass" :style="getStyle">
        <div class="row">
            <div class="col-lg-3">
                <a class="btn btn-xs"> <i class="material-icons" @click="edit">edit</i></a>
            </div>
            <div class="col-lg-9">
                <span> {{id}} - {{title}}</span><br>

            </div>
        </div>


    </Drag>
</template>

<script>
    import axios from "axios"
    import moment from 'moment'
    import 'moment/locale/es';


    import {Drag, Drop} from 'vue-drag-drop';

    export default {
        name: 'event',
        props: [
            'index',
            'id',
            'title',
            'description',
            'calendar',
            'ticketId',
            'hour',
            'top',
            'left',
            'duration',
            'start',
            'end'
            ],
        components: {Drag},
        data() {
            return {
            }
        },
        created: function () {
        },
        methods: {
            edit: function () {
                this.$emit("editEvent", this.index);
            }
        },
        computed: {
            getMainClass: function () {
                return 'zfc-event'
            },
            getStyle: function () {
                return 'top: ' + this.getTop + 'px;' + ' left: ' + this.getLeft + 'px;' + ' height:' + this.getHeight + "px;";
            },
            getTop: function () {
                return this.top;
            },
            getLeft: function () {
                return this.left;
            },
            getHeight: function () {
              var height = 25;
                if (this.duration > 30) {
                    height =  Math.ceil(this.duration / 30) * 25;
                }
                if(height > 600){
                  height = 600
                }
                return height

            }
        }
    }
</script>

<style scoped>

    .zfc-event {
        position: absolute;
        display: block;
        font-size: .85em;
        line-height: 1.3;
        border-radius: 3px;
        border: 1px solid #3a87ad;
        background: #1c5c87;
        color: #FFFFFF;
        min-height: 25px;
        z-index: 10;
        min-width: 160px;
        min-height: 25px;
    }

</style>

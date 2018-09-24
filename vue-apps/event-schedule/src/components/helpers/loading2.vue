<template>
    <div class="load-bar" v-if="isLoading">
        <v-progress-linear :indeterminate="true" class="pa-0 ma-0"></v-progress-linear>
    </div>
</template>

<script>

    import {ai} from './../../resource/HttpRequest'


    export default {
        name: 'loading',
        props: [],
        data: function () {
            return {
                load: 0
            }
        },
        computed: {
            isLoading: function () {
                return this.load ? true : false
            }
        },
        mounted: function () {
            ai.interceptors.request.use(
                (config) => {
                    this.load++;
                    return config;
                },
            );
            ai.interceptors.response.use(
                (response) => {
                    this.load--
                    return response;
                },
            );
        }

    }
</script>


<style scoped>
    .load-bar {
        position: absolute;
        top: 0px;
        width: 100%;
        height: 3px;
        /*background-color: #fdba2c;*/
        z-index: 3;

    }
</style>
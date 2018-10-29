<template>
    <div class="load-bar" v-if="isLoading">
        <v-progress-linear :indeterminate="true" class="pa-0 ma-0"></v-progress-linear>
    </div>
</template>

<script>

    import {ai} from './../../resource/HttpRequest'
    import {mapState} from 'vuex';

    export default {
        name: 'loading',
        props: [],
        computed: {
            ...mapState([
                'loading',
            ]),
            isLoading: function () {
                return this.loading ? true : false
            }
        },
        mounted: function () {
            ai.interceptors.request.use(
                (config) => {
                    this.$store.commit('LOADING_PLUS')
                    return config;
                },
            );
            ai.interceptors.response.use(
                (response) => {
                    this.$store.commit('LOADING_LESS')
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
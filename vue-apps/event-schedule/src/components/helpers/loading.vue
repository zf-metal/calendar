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

    .bar {
        content: "";
        display: inline;
        position: absolute;
        width: 0;
        height: 100%;
        left: 50%;
        text-align: center;
    }

    .bar:nth-child(1) {
        background-color: #da4733;
        animation: loading 3s linear infinite;
    }

    .bar:nth-child(2) {
        background-color: #3b78e7;
        animation: loading 3s linear 1s infinite;
    }

    .bar:nth-child(3) {
        background-color: #fdba2c;
        animation: loading 3s linear 2s infinite;
    }

    @keyframes loading {
        from {
            left: 50%;
            width: 0;
            z-index: 100;
        }
        33.3333% {
            left: 0;
            width: 100%;
            z-index: 10;
        }
        to {
            left: 0;
            width: 100%;
        }
    }
</style>
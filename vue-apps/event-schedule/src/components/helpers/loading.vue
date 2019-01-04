<template>
    <div class="load-bar" v-if="isLoading">
        <v-progress-linear :indeterminate="true" class="pa-0 ma-0"></v-progress-linear>
    </div>
</template>

<script>

    import {ai} from './../../resource/HttpRequest'
    import {mapGetters,mapActions} from 'vuex';

    export default {
        name: 'loading',
        props: [],
        computed: {
            ...mapGetters([
                'getLoading',
            ]),
            isLoading: function () {
                return this.getLoading ? true : false
            }
        },
        methods: {
            ...mapActions([
                'loadingPlus',
                'loadingLess',
            ])
        },
        mounted: function () {
            ai.interceptors.request.use(
                (config) => {
                    this.loadingPlus()
                    return config;
                }
            );
            ai.interceptors.response.use(
                (response) => {
                    this.loadingLess()
                    return response;
                },
                (error) => {
                    this.loadingLess()
                    return Promise.reject(error)
                }
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
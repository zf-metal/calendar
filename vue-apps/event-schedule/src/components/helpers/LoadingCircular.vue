<template>
    <div class="load-circle" v-if="isLoading">
        <v-progress-circular
                :size="35"
                color="primary"
                indeterminate
        ></v-progress-circular>
    </div>
</template>

<script>

    import {ai} from './../../resource/HttpRequest'
    import {mapState} from 'vuex';

    export default {
        name: 'LoadingCircular',
        props: [],
        computed: {
            ...mapState([
                'loading',
            ]),
            isLoading: function () {
                return this.loading ? true : false
            }
        },

    }
</script>

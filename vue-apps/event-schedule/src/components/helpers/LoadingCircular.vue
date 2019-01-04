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

    import {mapGetters} from 'vuex';

    export default {
        name: 'LoadingCircular',
        props: [],
        computed: {
            ...mapGetters([
                'getLoading',
            ]),
            isLoading: function () {
                return this.getLoading ? true : false
            }
        },

    }
</script>

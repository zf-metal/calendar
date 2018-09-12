<template>
    <i v-if="enable" @click="goFav"
       class="material-icons" :class="getSignalKeepClass"
       data-toggle="tooltip"
       :title="getTitle">
        face
    </i>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: 'fav',
        props: {
            enable: Boolean,
            keep: Number,
        },
        methods: {
            goFav: function () {
                //TODO
            }
        },
        computed: {
            ...mapState([
                'filterCoop',
            ]),
            getTitle: function () {
                return "Tecnico Favorito";
            },
            getSignalKeepClass: function () {

                if (this.keep) {
                    return "signal-fav-keep"
                } else {
                    return "signal-fav"
                }

            }

        },
    }
</script>

<style scoped>
    .signal-fav-keep {
        color: red;
    }

    .signal-fav {
        color: yellow;
    }
</style>

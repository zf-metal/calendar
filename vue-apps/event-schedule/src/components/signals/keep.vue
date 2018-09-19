<template>
    <i v-if="enable"
       class="material-icons pull-right" :class="getSignalKeepClass"
       data-toggle="tooltip"
       :title="getTitle">
        lock
    </i>
</template>

<script>
    export default {
        name: 'keep',
        props: {
            enable: Boolean,
        },
        computed: {
            getTitle: function () {
                return "Mantener Técnico";
            },
            getSignalKeepClass: function () {

                return "signal-keep"

            }

        },
    }
</script>

<style scoped>
    .signal-keep {
        color: yellow;
    }
</style>


<template>

    <i v-if="enable"  style="font-size: 20px"
       class="material-icons pull-left" :class="getSignalCoopClass"
       data-toggle="tooltip"
       title='Fuera de Servicio'>
        airplanemode_active
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
                return "Fuera de Servicio";
            },
            getSignalCoopClass: function () {
                return "signal-oof"
            }

        },
    }
</script>

<style scoped>
    .signal-oof {
        color: yellow;
        cursor: help;
    }

</style>

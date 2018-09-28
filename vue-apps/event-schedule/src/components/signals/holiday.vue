
<template>

    <i v-if="enable"  style="font-size: 20px"
       class="material-icons pull-right" :class="getSignalClass"
       data-toggle="tooltip"
       title='Feriado'>
        local_cafe
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
                return "Feriado";
            },
            getSignalClass: function () {
                return "signal-holiday"
            }

        },
    }
</script>

<style scoped>
    .signal-holiday {
        color: red;
        cursor: help;
    }

</style>

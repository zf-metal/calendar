
<template>

    <v-btn
           v-if="enable"
           small
           dark icon
           class="ma-1"
           v-tippy="{
                            dynamicTitle:true,
                            arrow:true,
                            performance:true,
                            placement:'top',
                            flip:true,
                            interactive: true,
                            animation: 'scale'
                        }"
           :title='getTitle'
    >
        <v-icon
                color="amber">
            airplanemode_active
        </v-icon>
    </v-btn>

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


        },
    }
</script>


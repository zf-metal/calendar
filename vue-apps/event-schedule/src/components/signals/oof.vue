
<template>

    <v-btn small dark icon class="ma-1"  v-if="enable">
        <v-icon
                v-tippy="{   dynamicTitle:true, arrow:true, performance:true, placement:'top', flip:true, interactive: true,
         animation: 'scale'}"
                :title='getTitle' color="amber">
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


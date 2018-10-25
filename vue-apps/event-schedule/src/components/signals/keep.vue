<template>

    <v-btn small
           dark
           icon
           class="ma-0"
           v-if="enable"
           v-tippy="{
                            dynamicTitle:true,
                            arrow:true,
                            performance:true,
                            placement:'top',
                            flip:true,
                            interactive: true,
                             animation: 'scale'
                        }"
           :title="getTitle"
    >
        <v-icon>
            lock
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
                return "Mantener Técnico";
            },


        },
    }
</script>

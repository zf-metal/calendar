<template>

    <v-btn small
           dark
           icon
           class="ma-0"
           v-tippy="{
                            dynamicTitle:true,
                            arrow:true,
                            performance:true,
                            placement:'top',
                            flip:true,
                            interactive: true,
                             animation: 'scale'
                        }"
           :title="comment"
    >
        <v-icon>
            feedback
        </v-icon>
    </v-btn>

</template>

<script>

    export default {
        name: 'comment',
        props: {
            comment: String
        },
    }
</script>

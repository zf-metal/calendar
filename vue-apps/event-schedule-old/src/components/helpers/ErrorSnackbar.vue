<template>
    <v-snackbar
            v-model="getShowError"
            top
    >
        {{ getTextError }}
        <v-btn
                color="pink"
                flat
                @click="hideError"
        >
            Cerrar
        </v-btn>
    </v-snackbar>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: 'ErrorSnackbar',
        props:[],
        components: {},
        created: function () {
        },
        methods: {
            ...mapActions([
                'hideError'
            ]),
        },
        computed: {
            ...mapGetters([
                'getShowError',
                'getTextError'
            ]),
        },
    }
</script>

<style scoped>

</style>

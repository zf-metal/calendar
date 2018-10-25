<template>

    <v-text-field
            class="pa-0"
            @keyup="changeFilterString"
            placeholder="Filtrar por cliente/dirección"
            v-model="filterString"
            clearable
            hide-details
            prepend-icon="search"
    >
    </v-text-field>
</template>

<script>
import delay from './../../functions/delay'

    export default {
        name: 'filterString',
        data() {
            return {
                filterString: ""
            }
        },
        created: function () {
        },
        methods: {
            changeFilterString: function(){

                delay(() => {
                    this.$store.commit("SET_FILTER_STRING",this.filterString.toLowerCase());
                }, 1200 );


            }
        },
        computed: {
        },
    }
</script>

<style scoped>

</style>

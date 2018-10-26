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
        watch: {
            filterString: function(fs){
                if(!fs){
                    this.$store.commit("SET_FILTER_STRING",this.filterString);
                }
            }
        },
        methods: {
            changeFilterString: function(){

                delay(() => {
                    if (typeof this.filterString === 'string' || this.filterString instanceof String) {
                        this.$store.commit("SET_FILTER_STRING", this.filterString.toLowerCase())
                    }
                }, 1000 );


            }
        },
        computed: {
        },
    }
</script>

<style scoped>

</style>

<template>

    <v-text-field
            class="pa-0"
            @keyup="changeFilterString"
            placeholder="Filtrar por cliente/dirección"
            v-model="filterString"
            clearable
            hide-details
            prepend-icon="search"
            @click:clear="updateFilterOnClear"
    >
    </v-text-field>
</template>

<script>
import delay from '../../helpers/delay'

    export default {
        name: 'filterString',
        data() {
            return {
                filterString: ""
            }
        },
        methods: {
            updateFilterOnClear: function(){
                console.log("update",this.filterString)
                this.$store.commit("SET_FILTER_STRING","");
            },
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

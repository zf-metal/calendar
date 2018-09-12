<template>
    <div>
        <input type="text" placeholder="Filtrar por cliente/dirección" class="form-control" id="filterString"  @keyup="changeFilterString" v-model="filterString" />
    </div>
</template>

<script>

    export default {
        name: 'filterString',
        props:[],
        components: {},
        data() {
            return {
                filterString: ""
            }
        },
        created: function () {
        },
        methods: {
            changeFilterString: function(){
                this.$store.commit("SET_FILTER_STRING",this.filterString.toLowerCase());
            }
        },
        computed: {
        },
    }
</script>

<style scoped>

</style>

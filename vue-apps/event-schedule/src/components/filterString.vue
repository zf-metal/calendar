<template>
    <div>
        <input type="text" placeholder="Filtrar por cliente/dir" class="form-control" id="filterString"  @keyup="changeFilterString" v-model="filterString" />
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

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
            ...mapGetters([
                'getFilterString',
            ]),
        },
    }
</script>

<style scoped>

</style>

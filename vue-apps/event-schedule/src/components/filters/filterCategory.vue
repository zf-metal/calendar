<template>

    <v-select class="pa-0"
              v-model="categoryId"
              v-on:change="onChange"
              :items="getItemByCategories"
              hide-details
              clearable
              placeholder="Filtro por rubro"
              @click:clear="updateFilterOnClear"
    prepend-icon="filter_list"
    >
    </v-select>

</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: 'filterCategory',
        props: [],
        components: {},
        data() {
            return {
              categoryId: null
            }
        },
        created: function () {
        },
        methods: {
            updateFilterOnClear: function(){
                this.$store.commit("SET_FILTER_CATEGORY",null);
            },
          onChange: function () {
                this.$store.commit("SET_FILTER_CATEGORY", this.categoryId);
            }
        },
        computed: {
            ...mapGetters([
                'getCategories',
                'getPreEventsByCategory'
            ]),
            getItemByCategories: function () {
                let items = []
                for (var key in this.getCategories) {
                    var category = this.getCategories[key];
                    items.push({value: category.id, text: category.name + " (" + this.getPreEventsByCategory(category.id).length + ")"})
                }
                return items
            }
        },
    }
</script>

<style scoped>

</style>

<template>
    <v-select style="width:60px" class="pl-1" v-model="size" v-on:change="applySize" :items="items">
    </v-select>
</template>

<script>
    export default {
        name: 'SelectSize',
        data() {
            return {
                size: "60",
                items: [
                    {value: "15", text: "15"},
                    {value: "30", text: "30"},
                    {value: "60", text: "60"},
                    {value: "90", text: "90"},
                    {value: "120", text: "120"},
                    ]
            }
        },
        methods: {
            applySize: function () {
                this.$store.commit('SET_CELL_HEIGHT', this.size);
            },
        }
    }
</script>

<style scoped>

</style>

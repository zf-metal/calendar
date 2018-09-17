<template>
    <select class="form-control" v-model="size" v-on:change="applySize">
        <option value="30">Min</option>
        <option value="60">Mid</option>
        <option value="90">Max</option>
    </select>
</template>

<script>
    export default {
        name: 'SelectSize',
        data() {
            return {
                size: 60,
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

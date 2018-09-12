<template>
    <div v-if="getPreEventsByZone(id).length > 0" class="col-lg-6">
        <input type="checkbox" :name='id' v-on:change="toggleZone" v-model="active"/>
        <label>{{name}} ({{getPreEventsByZone(id).length}})</label>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: 'checkZone',
        props: ['index', 'id', 'name'],
        components: {},
        data() {
            return {
                active: true,
            }
        },
        computed: {
            ...mapGetters([
                'getPreEventsByZone',
            ]),
        },
        methods: {
            ...mapActions([
                'showZone',
                'hideZone',
            ]),
            toggleZone: function () {
                if (this.active) {
                    this.$store.commit('SHOW_ZONE', this.index);
                } else {
                    this.$store.commit('HIDE_ZONE', this.index);
                }
            }
        }
    }
</script>

<style scoped>

</style>

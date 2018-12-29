<template>
    <v-container fluid grid-list-md>
        <v-data-iterator
                :items="items"

                :pagination.sync="pagination"
                content-tag="v-layout"
                row
                wrap
        >
            <v-flex
                    slot="item"
                    slot-scope="props"
                    xs12
            >
                <v-card>
                    <v-card-title><h4>{{ props.item.id }} {{ props.item.name }}</h4></v-card-title>
                    <v-divider></v-divider>
                    <v-list dense>
                        <v-list-tile>
                            <v-list-tile-content>Cliente:</v-list-tile-content>
                            <v-list-tile-content class="align-end">{{ props.item.client }}</v-list-tile-content>
                        </v-list-tile>
                        <v-list-tile>
                            <v-list-tile-content>Sucursal:</v-list-tile-content>
                            <v-list-tile-content class="align-end">{{ props.item.branchOffice }}</v-list-tile-content>
                        </v-list-tile>

                        <v-list-tile>
                            <v-list-tile-content>Direccion:</v-list-tile-content>
                            <v-list-tile-content class="align-end">{{ props.item.location }}</v-list-tile-content>
                        </v-list-tile>
                        <v-divider></v-divider>
                        <v-card-text class="text-xs-center pa-0">
                            <v-btn small color="info" @click="showServiceEvents(props.item.id)" >Programación</v-btn>
                        </v-card-text>
                    </v-list>
                </v-card>
            </v-flex>


        </v-data-iterator>
    </v-container>
</template>

<script>
    import {mapGetters,mapActions} from 'vuex';

    export default {
        name: 'ServiceItems',
        props: {
            items: {type: Array},
        },
        data() {
            return {
                pagination: {
                    rowsPerPage: 4
                },
            }
        },
        components: {},
        methods: {
            showServiceEvents: function (id) {
                this.selectService(id);
                this.$store.commit('SET_SHOW_MODAL_SERVICE', true);
            },
            ...mapActions([
                'selectService'
            ])
        },
        computed: {
            ...mapGetters([]),
        },
    }
</script>

<style scoped>

</style>

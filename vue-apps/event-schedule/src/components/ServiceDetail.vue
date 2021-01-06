<template>
    <v-layout row wrap v-if="serviceSelected">
        <v-flex lg3 md3 sm6 xs12>
            <v-list subheader>
                <v-list-tile>

                    <v-list-tile-avatar>
                        <v-icon class="primary white--text">account_box</v-icon>
                    </v-list-tile-avatar>
                    <v-list-tile-content>
                        <v-list-tile-sub-title>Cliente </v-list-tile-sub-title>
                        <v-list-tile-title  v-if="serviceSelected && serviceSelected.client && serviceSelected.client.name" >{{ serviceSelected.client.name }}</v-list-tile-title>

                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-flex>

        <v-flex lg3 md3 sm6 xs12>
            <v-list subheader>
                <v-list-tile>

                    <v-list-tile-avatar>
                        <v-icon class="primary white--text">shop</v-icon>
                    </v-list-tile-avatar>
                    <v-list-tile-content>
                        <v-list-tile-sub-title>Titulo </v-list-tile-sub-title>
                        <v-list-tile-title  v-if="serviceSelected && serviceSelected.name" >{{ serviceSelected.name }}</v-list-tile-title>

                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-flex>

        <v-flex lg3 md3 sm6 xs12>
            <v-list subheader>
                <v-list-tile>
                    <v-list-tile-avatar>
                        <v-icon class="primary white--text">location_on</v-icon>
                    </v-list-tile-avatar>
                    <v-list-tile-content>
                        <v-list-tile-sub-title>Sucursal</v-list-tile-sub-title>
                        <v-list-tile-title  v-if="serviceSelected && serviceSelected.branchOffice && serviceSelected.branchOffice.name"> {{ serviceSelected.branchOffice.name }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-flex>

        <v-flex lg3 md3 sm6 xs12>
            <v-list subheader>
                <v-list-tile>
                    <v-list-tile-avatar>
                        <v-icon class="primary white--text">my_location</v-icon>
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                        <v-list-tile-sub-title> Dirección</v-list-tile-sub-title>
                        <v-list-tile-title v-if="serviceSelected && serviceSelected.branchOffice && serviceSelected.branchOffice.location">{{ serviceSelected.branchOffice.location }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-flex>
        <v-flex  xs12>
            <v-divider></v-divider>
        </v-flex>
    </v-layout>

</template>

<script>
    import { mapState} from 'vuex';

    export default {
        name: 'ServiceDetail',
        data() {
            return {
                service: null,
            }
        },
        components: {},
        methods: {},
        computed: {
            ...mapState([
                'serviceIdSelected',
                'serviceSelected',
            ]),
        },
    }
</script>

<style scoped>

</style>

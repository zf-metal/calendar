<template>
    <v-layout row wrap v-if="eventSelected">
        <v-flex lg3 md3 sm6 xs12>
            <v-list subheader>
                <v-list-tile>

                    <v-list-tile-avatar>
                        <v-icon class="primary white--text">account_box</v-icon>
                    </v-list-tile-avatar>
                    <v-list-tile-content>
                        <v-list-tile-sub-title>Cliente </v-list-tile-sub-title>
                        <v-list-tile-title>{{ eventSelected.client }}</v-list-tile-title>

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
                        <v-list-tile-title>{{ eventSelected.title }}</v-list-tile-title>

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
                        <v-list-tile-title> {{ eventSelected.branchOffice }}</v-list-tile-title>
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
                        <v-list-tile-title>{{ eventSelected.location }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-flex>
    </v-layout>

</template>

<script>
    import {mapGetters, mapState} from 'vuex';

    export default {
        name: 'ServiceDetail',
        props:[],
        components: {},
        methods: {},
        computed: {
            ...mapState([
                'eventSelected',
            ]),
        },
    }
</script>

<style scoped>

</style>

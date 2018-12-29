<template>
    <v-layout row wrap>
        <v-form @submit.prevent="serviceSearch" @keyup.native.enter="serviceSearch">
            <v-flex xs12>
                <v-text-field
                        class="pa-0"
                        placeholder="Filtrar por ID Servicio"
                        v-model="serviceId"
                        clearable
                        hide-details
                        prepend-icon="vpn_key"
                >
                </v-text-field>
            </v-flex>

            <v-flex xs12>
                <v-text-field
                        class="pa-0"
                        placeholder="Filtrar por Cliente"
                        v-model="client"
                        clearable
                        hide-details
                        prepend-icon="account_box"
                >
                </v-text-field>
            </v-flex>
            <v-flex xs12>
                <v-text-field
                        class="pa-0"
                        placeholder="Filtrar por Sucursal"
                        v-model="branchOffice"
                        clearable
                        hide-details
                        prepend-icon="business"
                >
                </v-text-field>
            </v-flex>

            <v-flex xs12>
                <v-text-field
                        class="pa-0"
                        placeholder="Filtrar por Dirección"
                        v-model="location"
                        clearable
                        hide-details
                        prepend-icon="my_location"
                >
                </v-text-field>
            </v-flex>
            <v-flex xs12 class="text-xs-center">
                <v-btn color="primary" @click="serviceSearch">Buscar Servicios</v-btn>
            </v-flex>
        </v-form>

        <v-flex xs12>
            <service-items :items="serviceItems"></service-items>
        </v-flex>
    </v-layout>

</template>

<script>
    import delay from '../helpers/delay'
    import {ServiceService} from '../resource/index'
    import ServiceItems from './ServiceItems.vue'

    export default {
        name: 'ServiceSearch',
        components: {ServiceItems},
        data() {
            return {
                serviceId: "",
                client: "",
                branchOffice: "",
                location: "",
                serviceItems: []
            }
        },
        methods: {
            serviceSearch: function () {
                ServiceService.serviceSearch(this.serviceId, this.client, this.branchOffice, this.location).then(
                    (response) => {
                        console.log(response.data)
                        this.serviceItems = response.data;
                    }
                )
            }
        },
        computed: {},
    }
</script>

<style scoped>

</style>

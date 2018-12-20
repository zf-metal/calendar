<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-text-field
                    class="pa-0"
                    @keyup="keyUp"
                    placeholder="Filtrar por ID Servicio"
                    v-model="serviceId"
                    clearable
                    hide-details
                    prepend-icon="vpn_key"
                    @click:clear="clear"
            >
            </v-text-field>
        </v-flex>

        <v-flex xs12>
            <v-text-field
                    class="pa-0"
                    @keyup="keyUp"
                    placeholder="Filtrar por Cliente"
                    v-model="client"
                    clearable
                    hide-details
                    prepend-icon="account_box"
                    @click:clear="clear"
            >
            </v-text-field>
        </v-flex>
        <v-flex xs12>
            <v-text-field
                    class="pa-0"
                    @keyup="keyUp"
                    placeholder="Filtrar por Sucursal"
                    v-model="branchOffice"
                    clearable
                    hide-details
                    prepend-icon="business"
                    @click:clear="clear"
            >
            </v-text-field>
        </v-flex>

        <v-flex xs12>
            <v-text-field
                    class="pa-0"
                    @keyup="keyUp"
                    placeholder="Filtrar por Dirección"
                    v-model="location"
                    clearable
                    hide-details
                    prepend-icon="my_location"
                    @click:clear="clear"
            >
            </v-text-field>
        </v-flex>
        <v-flex xs12 class="text-xs-center">
            <v-btn color="primary">Buscar Servicios</v-btn>
        </v-flex>
    </v-layout>

</template>

<script>
    import delay from '../../helpers/delay'

    export default {
        name: 'filterService',
        data() {
            return {
                serviceId: "",
                client: "",
                branchOffice: "",
                location: ""
            }
        },
        methods: {
            clear: function () {
                //TODO search
            },
            keyUp: function () {
                delay(() => {
                    if (typeof this.client === 'string' || this.client instanceof String) {
                        //TODO search
                    }
                }, 1000);


            }
        },
        computed: {},
    }
</script>

<style scoped>

</style>

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
                    v-model="account"
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
            <v-btn color="primary" @click="serviceSearch">Buscar Servicios</v-btn>
        </v-flex>
    </v-layout>

</template>

<script>
    import delay from '../../helpers/delay'
    import {ServiceService} from '../../resource'

    export default {
        name: 'filterService',
        data() {
            return {
                serviceId: "",
                account: "",
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
            },
          serviceSearch: function () {

            ServiceService.serviceSearch(this.serviceId,this.account,this.branchOffice,this.location).then(
              (response) => {
               console.log(response.data)
                for (let i = 0; i < response.data.length; i++) {
                  let service = response.data[i];

                }

              }
            )
          },
        },
        computed: {},
    }
</script>

<style scoped>

</style>

<template>
    <v-menu bottom left>
        <v-btn
                slot="activator"
                dark
                icon
                small
                class="ma-0"
        >
            <v-icon>more_vert</v-icon>
        </v-btn>

        <v-list>
            <v-list-tile @click="$emit('edit')">
                <v-list-tile-title >Editar</v-list-tile-title>
            </v-list-tile>
            <v-list-tile @click="$emit('showServiceEvents')">
                <v-list-tile-title>Servicio</v-list-tile-title>
            </v-list-tile>
        </v-list>
    </v-menu>
</template>

<script>
    export default {
        name: 'EventMenu',
    }
</script>

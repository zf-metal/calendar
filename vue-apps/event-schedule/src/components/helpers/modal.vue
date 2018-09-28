<template>
<div v-on:keyup.esc="$emit('close')">
        <v-dialog
                v-model="showModal"

                max-width="800"
                persistent
        >
            <v-card>
                <v-card-title class="headline">{{title}}</v-card-title>

                <v-card-text class="text-lg-center text-xs-center">
                    <slot v-on:closeModal="closeModal"></slot>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            color="primary"
                            flat
                            @click="$emit('close')"
                    >
                        Cerrar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
</div>
</template>

<script>
    export default {
        name: 'modal',
        props: ['showModal', 'modalId', 'modalClass', 'modalSize', 'title'],
        data: function () {
            return {}
        },
        methods: {
            closeModal: function () {
                console.log("Close Modal");
                this.$emit('close');
            },
            onEscapeClose: function (key) {

            }
        }
    }
</script>


<style scoped>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-body {
        padding: 2px 15px;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-dialog {
        z-index: 9999;
    }
</style>
<template>
    <v-dialog
            persistent
            v-model="show"
            max-width="290"
    >
        <v-card>
            <v-card-title class="headline">{{title}}</v-card-title>

            <v-card-text>
                {{description}}
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>


                <v-btn
                        color="red darken-1"
                        flat="flat"
                        @click="ok"
                >
                    Ok
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

    export default {
        name: 'dialogAlert',
        props: {
            dialog: {type: Boolean, default:false},
            title: String,
            description: String,
        },
        mounted: function(){
          this.show = this.dialog
        },
        watch: {
          dialog: function(){
              this.show = this.dialog;
          }
        },
        data: function(){
            return {
                  show: false
            }
        },
        methods: {
            ok: function () {
                this.$emit("ok")
            }
        }
    }
</script>

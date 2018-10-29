<template>
    <div class="MiniCalendar">
        <v-container>
            <v-layout fluid>
                <v-flex xs-12>
                    <table class="table-calendar">
                        <thead>
                        <tr>
                            <th>Lun</th>
                            <th>Mar</th>
                            <th>Mie</th>
                            <th>Jue</th>
                            <th>Vie</th>
                            <th>Sab</th>
                            <th>Dom</th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr v-for="(range,index) in getCalendar" :key="index">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        </tbody>


                    </table>
                </v-flex>

            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import {mapGetters, maState} from 'vuex';

    export default {
        name: 'MiniCalendar',
        props: [],
        components: {},
        data() {
            return {
                asd: {}
            }
        },
        created: function () {
        },
        methods: {},
        computed: {
            ...mapGetters([
                'getYear',
                'getMonth',
                'getCalendar',
                'getWeeks'
            ]),
        },
    }
</script>

<style scoped>
    .table-calendar {
        border: 1px solid #8B8986;
        border-spacing: 1px;
        width: 100%;
    }

    .table-calendar th {
        padding: 3px;
        border: 1px solid #8B8986;
    }
</style>

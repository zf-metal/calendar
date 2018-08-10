<template>

    <nav class="navbar navbar-default" style="margin: 0;">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/"><i class="material-icons">home</i>
                </a>
            </div>


            <day v-model="getDate"></day>
            <ul class="nav navbar-nav ">
                <li>
                </li>
            </ul>

            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <button class="btn btn-default btn-sm material-icons">refresh</button>
                </div>
            </form>

            <div class="navbar-form navbar-left">
                <div class="form-group">
                    <select class="form-control" v-model="myCellHeight" v-on:change="applyCellHeight">
                        <option value="30">Min</option>
                        <option value="60">Mid</option>
                        <option value="90">Max</option>
                    </select>
                </div>
            </div>

            <div class="navbar-form navbar-left">
                <div class="form-group">
                    <select class="form-control" v-model="start" v-on:change="changeCalendarStart">
                        <option value="00:00" selected="selected">00:00</option>
                        <option value="01:00">01:00</option>
                        <option value="02:00">02:00</option>
                        <option value="03:00">03:00</option>
                        <option value="04:00">04:00</option>
                        <option value="05:00">05:00</option>
                        <option value="06:00">06:00</option>
                        <option value="07:00">07:00</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                        <option value="20:00">20:00</option>
                        <option value="21:00">21:00</option>
                        <option value="22:00">22:00</option>
                        <option value="23:00">23:00</option>
                    </select>
                </div>
            </div>

        </div>
    </nav>

</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import day from './day.vue'
    import loading from './helpers/loading.vue'

    export default {
        name: 'navi',
        components: {day, loading},
        data() {
            return {
                myCellHeight: 60,
                start: '00:00'
            }
        },
        created: function () {
            this.myCellHeight = this.getCellHeight;
            this.start = this.getCalendarStart;
        },
        methods: {
            applyCellHeight: function () {
                this.$store.commit('SET_CELL_HEIGHT', this.myCellHeight);
            },
            changeCalendarStart: function () {
                this.$store.commit('SET_CALENDAR_START', this.start);
            }
        },
        computed: {
            ...mapGetters([
                'getCellHeight',
                'getDayName',
                'getDate',
                'getLoading',
                'getCalendarStart'
            ]),
        },
    }
</script>
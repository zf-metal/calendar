<template>
    <v-btn small dark icon class="ma-1" v-if="hasFav">
        <v-icon  @click="goFav"
                v-tippy="{   dynamicTitle:true, arrow:true, performance:true, placement:'top', flip:true, interactive: true,
         animation: 'scale'}"
                :title="getTitle">
            face
        </v-icon>
    </v-btn>
</template>

<script>

    export default {
        name: 'fav',
        props: {
            preference: Object,
        },
        methods: {
            goFav: function () {
                //TODO
            }
        },
        computed: {
            hasFav: function () {
                if (this.preference && (this.preference.pref1 || this.preference.pref2 || this.preference.pref3)) {
                    return true
                }
                return false
            },
            getTitle: function () {
                return "Tecnicos Preferidos: " + this.getNamePref1 + " " + this.getNamePref2 + " " + this.getNamePref3;
            },
            getNamePref1: function () {
                if (this.preference && this.preference.pref1 && this.preference.pref1.name) {
                    return this.preference.pref1.name
                }

                return ""
            },
            getNamePref2: function () {
                if (this.preference && this.preference.pref2 && this.preference.pref2.name) {
                    return this.preference.pref2.name
                }
                return ""
            },
            getNamePref3: function () {
                if (this.preference && this.preference.pref3 && this.preference.pref3.name) {
                    return this.preference.pref3.name
                }

                return ""
            }
        },
    }
</script>

<style scoped>

</style>

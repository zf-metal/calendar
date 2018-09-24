<template>
    <i v-if="hasFav" @click="goFav" style="font-size: 20px"
       class="material-icons pull-right" :class="getSignalFavClass"
       data-toggle="tooltip"
       :title="getTitle">
        face
    </i>
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
                return "Tecnicos Preferidos: "+ this.getNamePref1 + " " + this.getNamePref2 + " " + this.getNamePref3;
            },
            getNamePref1: function(){
                if (this.preference && this.preference.pref1 && this.preference.pref1.name){
                    return this.preference.pref1.name
                }

                return ""
            },
            getNamePref2: function(){
                if (this.preference &&this.preference.pref2 && this.preference.pref2.name){
                    return this.preference.pref2.name
                }
                return ""
            },
            getNamePref3: function(){
                if (this.preference && this.preference.pref3 && this.preference.pref3.name){
                    return this.preference.pref3.name
                }

                return ""
            },
            getSignalFavClass: function () {
                return "signal-fav"
            }

        },
    }
</script>

<style scoped>
    .signal-fav {
        color: orange;
    }
</style>

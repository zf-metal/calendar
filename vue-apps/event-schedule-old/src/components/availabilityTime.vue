<template>
        <span><span v-if="getFrom && getTo">{{getFrom}} - {{getTo}}</span><span v-else-if="getFrom">{{getFrom}}</span><span v-if="getFrom && getFrom2"> & </span><span v-if="getFrom2 && getTo2">{{getFrom2}} - {{getTo2}}</span><span v-else-if="getFrom2">{{getFrom2}}</span>
        </span>
</template>

<script>


    export default {
        name: 'availabilityTime',
        props: ['data'],
        components: {},
        created: function () {
        },
        methods: {},
        computed: {
            getFrom: function () {
                if (this.data != undefined && this.data.timeRange != undefined && this.data.timeRange.from != undefined) {
                    return this.data.timeRange.from;
                }
                return false;
            },
            getTo: function () {
                if (this.data != undefined && this.data.timeRange != undefined && this.data.timeRange.to != undefined) {
                    return this.data.timeRange.to;
                }
                return false;
            },
            getFrom2: function () {
                if (this.data != undefined && this.data.timeRange2 != undefined && this.data.timeRange2.from != undefined) {
                    return this.data.timeRange2.from;
                }
                return false;
            },
            getTo2: function () {
                if (this.data != undefined && this.data.timeRange2 != undefined && this.data.timeRange2.to != undefined) {
                    return this.data.timeRange2.to;
                }
                return false;
            },

        }
    }
</script>


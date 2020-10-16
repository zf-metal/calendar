<template>
    <div>
        <calendars></calendars>
    </div>
</template>

<script>
    import calendars from './views/calendars.vue'

    export default {
        name: 'App',
        components: {
            calendars,
        },
        created: function () {
        }
    }
</script>

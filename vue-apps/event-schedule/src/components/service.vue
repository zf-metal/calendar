<template>
    <div >
        <ul id="v-for-object" class="demo" style="list-style: none; padding: 2px;">
            <li v-for="(value,index) in service" :key="index">
                <b>{{ index }}</b> : {{ value }}
            </li>
        </ul>
    </div>
</template>

<script>
    import axios from "axios"

    export default {
        name: 'service',
        props:['service'],
        components: {},
        methods: {},
        computed: {}
    }
</script>

<style scoped>

</style>

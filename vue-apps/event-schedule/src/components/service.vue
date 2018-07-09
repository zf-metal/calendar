<template>
    <div >
        <ul id="v-for-object" class="zfc-service-ul">
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

    .zfc-service-ul{
        list-style: none;
        padding: 2px;
        font-size: 12px;
    }
</style>

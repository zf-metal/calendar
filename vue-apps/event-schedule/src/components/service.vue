<template>
    <div >
        <ul id="v-for-object" class="demo">
            <li v-for="(value,index) in service" :key="index">
                {{ index }} : {{ value }}
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

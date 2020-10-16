<template>
    <section v-if="errors">
        <span class="text-danger help-block " v-for="(error, index) in errors" :key="index">
            {{error}}
        </span>
    </section>
</template>

<script>
    export default {
        name: 'form-errors',
        props: ['errors']
    }
</script>
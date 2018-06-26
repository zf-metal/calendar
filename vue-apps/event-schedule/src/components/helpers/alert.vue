<template>
    <div v-if="show"  class="alert alert-dismissible" :class="type" >
        <button type="button" class="close"  v-on:click="$emit('close')">×</button>
        {{msg}}
    </div>
</template>

<script>
export default {
  name: 'alert',
  props: [ 'type', 'msg','show'
  ]
}
</script>

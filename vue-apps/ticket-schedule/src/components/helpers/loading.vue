<template>
   <div class="pull-left" v-if="isLoading">
       <img src="../../assets/blocks-loading.gif" />
   </div>
</template>

<script>
export default {
  name: 'loading',
  props: ['isLoading']
}
</script>

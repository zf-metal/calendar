<template>
   <div class="zfc-loading" v-if="isLoading">
       <img src="../../assets/blocks-loading.gif" />
   </div>
</template>

<script>
export default {
  name: 'loading',
  props: ['isLoading']
}
</script>


<style scoped>
    .zfc-loading{
        position:absolute;
        top:-4px;
        left:25px;
        z-index: 100;
    }
</style>
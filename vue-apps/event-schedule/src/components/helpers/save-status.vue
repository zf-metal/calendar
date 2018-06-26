<template>
   <div class="pull-right" v-if="!isSaved">
       <span class="text-danger fa fa-save"></span>
   </div>
</template>

<script>
export default {
  name: 'unsaved',
  props: [ 'isSaved'
  ]
}
</script>

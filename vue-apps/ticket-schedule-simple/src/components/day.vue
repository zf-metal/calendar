<template>
    <div>
       <button class="btb btn-default"><</button>
        <input type="date" v-model="day">
        <button class="btb btn-default">></button>
    </div>
</template>

<script>

  export default {
    name: 'day',
    props: ['value'],
    data() {
      return {
        day: ''
      }
    },
    created: function(){
      console.log( this.value);
      this.day = this.value;
    }
  }
</script>


<template>
    <div class="col-lg-6 col-lg-offset-3">
        <div class="row">
            <div class="col-xs-2">
                <a class="btn material-icons">   <i class="material-icons">navigate_before</i></a>
            </div>

            <div class="col-xs-8">
            <input type="date" class="form-control" v-model="day">
            </div>
            <div class="col-xs-2">
                <a class="btn material-icons"><i class="material-icons">navigate_next</i></a>
            </div>
        </div>
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


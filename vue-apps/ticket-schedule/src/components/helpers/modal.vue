<template>
    <div v-if="showModal" v-on:keyup.esc="$emit('close')">
        <transition name="modal">
            <div class="modal-mask"  >
                <div class="modal-wrapper">
                    <div class="modal-dialog" :class="[ modalSize ? modalSize : '' ]" role="document"
                         ref="modal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" @click="$emit('close')"  class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">{{ title }}

                                </h4>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <slot></slot>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
  export default {
    name: 'modal',
    props: ['showModal','modalId', 'modalClass', 'modalSize', 'title'],
    data: function () {
      return {}
    },
    methods:{
      onEscapeClose: function(key){

      }
    }
  }
</script>


<style scoped>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-dialog{
        z-index: 9999;
    }
</style>
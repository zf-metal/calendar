<template>
    <drag :transfer-data="{obj: obj, index:index, type: 't'}" :draggable="isDraggable">

        <div class="card" :title="obj.serviceDescription"
             v-tippy="{
             allowTitleHTML: true,
             dynamicTitle:true,
             arrow:true,
             placement:'right',
             performance:true,
             flip:false,
             followCursor: false,
             hideOnClick: true,
             trigger: 'click',
             popperOptions: { modifiers: { preventOverflow: { enabled: false}}}
        }"
        >
            <div class="card-header card-header-preevent">
                <h4 class="card-title">{{obj.id}}. {{obj.title}}
                    <!--<i class="material-icons zfc-pre-type-icon pull-right">{{getEventTypeIcon(obj.type)}} </i>-->
                </h4>

            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td><i class="material-icons" style="vertical-align: bottom;">account_box</i></td>
                        <td>{{getCliente}}</td>
                    </tr>
                    <tr>
                        <td :style="getSucColor"><i class="material-icons" style="vertical-align: bottom;">business</i>
                        </td>
                        <td>{{getLocation}}</td>
                    </tr>
                    <tr>
                        <td><i class="material-icons" style="vertical-align: bottom;">today</i></td>
                        <td>
                            <availabilityDay :data="obj.availability"></availabilityDay>
                        </td>
                    </tr>

                    <tr>
                        <td><i class="material-icons" style="vertical-align: bottom;">hourglass_full</i></td>
                        <td>
                            <availabilityTime :data="obj.availability"></availabilityTime>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </drag>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import {Drag, Drop} from 'vue-drag-drop';
  import availabilityDay from './availabilityDay.vue';
  import availabilityTime from './availabilityTime.vue';

  export default {
    name: 'preEvent',
    props: ['preEvent', 'index'],
    components: {Drag, Drop, availabilityDay, availabilityTime},
    data() {
      return {
        obj: {
          id: '',
          calendar: '',
          title: '',
          location: '',
          description: '',
          state: '',
          type: '',
          time: 60
        }
      }
    },
    created: function () {
      this.obj = this.preEvent
    },
    methods: {},
    computed: {
      ...mapGetters([
        'getZoneBgColor',
        'getEventStates',
        'getEventStateBgColor',
        'getEventTypeIcon'
      ]),
      getCliente: function () {
        if (this.obj.client != undefined) {
          return this.obj.client;
        }
        return "";
      },
      getLocation: function () {
        if (this.obj.location != undefined) {
          return this.obj.location;
        }
        return "";
      },
      getSucColor: function () {
        if (this.obj.zone.id != undefined) {
          return "background-color:" + this.getZoneBgColor(this.obj.zone.id);
        }
        return "";
      },
      isDraggable: function () {
        if (this.obj.calendar == null) {
          return true;
        } else {
          return false;
        }
      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .table {
        margin: 0;
    }

    .table td {
        vertical-align: middle;
        padding: 3px;
    }

    .card {
        border: 0;
        margin-bottom: 10px;
        margin-top: 10px;
        border-radius: 6px;
        color: #333;
        background: #fff;
        width: 100%;
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, .14), 0 3px 1px -2px rgba(0, 0, 0, .2), 0 1px 5px 0 rgba(0, 0, 0, .12);
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid #eee;
        border-radius: .25rem;
        font-size: .875rem;
    }

    .card-title {
        font-size: 1.5em;
    }

    .card .card-header {
        z-index: 3 !important;
        padding: 1px;
        position: relative;
        color: #fff;
        border-bottom: none;
        background: transparent;
    }

    .card .card-header-preevent {
        /*background: linear-gradient(60deg,#ab47bc,#8e24aa);*/
        background-color: #333;
    }


</style>

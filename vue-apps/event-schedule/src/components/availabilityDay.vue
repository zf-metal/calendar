<template>
    <div>
        <div v-if="getEspecificDays" >
                <span class="especificDays" v-for="(item,index) in getEspecificDays" :key="index">
                    {{item.description}}
                </span>
        </div>


        <table v-if="!getEspecificDays" class="daysTable">
            <td :class="getDayClass(1)">Lun</td>
            <td :class="getDayClass(2)">Mar</td>
            <td :class="getDayClass(3)">Mie</td>
            <td :class="getDayClass(4)">Jue</td>
            <td :class="getDayClass(5)">Vie</td>
            <td :class="getDayClass(6)">Sab</td>
            <td :class="getDayClass(7)">Dom</td>
        </table>


    </div>
</template>

<script>


  export default {
    name: 'availabilityDay',
    props: ['data'],
    components: {},
    created: function () {
    },
    methods: {
      getDayClass: function (day) {
        if (this.data != undefined && this.data.days[day] == true) {
          return "dayOk";
        } else {
          return "dayNo";
        }
      }
    },
    computed: {
      getEspecificDays: function () {
        if (this.data != undefined && this.data.especificDays != undefined) {
          return this.data.especificDays;
        }
        return false;
      },
      getDays: function () {
        if (this.data != undefined && this.data.days != undefined) {
          return this.data.days;
        }
        return false;
      },

    }
  }
</script>

<style scoped>

    .daysTable table {
    }

    .daysTable td {
        border: 1px solid #5c6667;
        font-size: 1em;
        padding: 1px;

    }

    .especificDays{
        color: #004a43;
        background-color: #7EFC7E;
        font-weight: bold;
    }

    .dayOk {
        color: #004a43;
        background-color: #7EFC7E;
        font-weight: bold;
    }

    .dayNo {
        background-color: #cccccc;
    }

</style>

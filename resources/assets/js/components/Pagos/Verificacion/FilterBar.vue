<template>
    <div class="filter-bar">
      <form class="form-inline">
        <div class="input-group mb-3">
          <label>Buscar Por:</label>&nbsp;
          <date-picker v-model="date" :config="options" @dp-hide="fecha"></date-picker>&nbsp;
          <select class="form-control" v-model="selected" @change="grupo">
            <option disabled value="">Por Favor Seleccione</option>
            <option v-for="option in optionsA" v-bind:value="option">
              {{ option }}
            </option>
          </select>&nbsp;
          <select class="form-control" v-model="selected2" @change="doFilter">
            <option disabled value="">Por Favor Seleccione</option>
            <option v-for="option in optionsB" v-bind:value="option">
              {{ option }}
            </option>
          </select>&nbsp;
          <button class="btn" @click.prevent="resetFilter">Reset</button>
        </div>
      </form>
    </div>
</template>

<script>
  import datePicker from 'vue-bootstrap-datetimepicker';
  import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
  export default {
    data () {
      return {
        filterText: {},
        optionsA: '',
        optionsB: '',
        selected: '',
        selected2: '',
        date: new Date(),
        options: {
          format: 'YYYY-MM-DD',
          useCurrent: false,
          locale: 'es',
          showTodayButton: true,
          showClose: true
        }   
      }
    },
    methods: {
      doFilter () {
        this.filterText = {
          date: this.date,
          group: this.selected,
          group_t: this.selected2,
        }
        this.$events.fire('filter-set', this.filterText)
      },
      resetFilter () {
        this.filterText = {}
        this.optionsA = ''
        this.optionsB = ''
        this.selected2 = ''
        this.selected = ''
        this.$events.fire('filter-reset')
      },
      fecha (){
        axios.get('/admin/pagos/getverificat?'+'date='+this.date).then((response) => {
          this.optionsA = response.data
        })
        this.resetFilter()
        this.$events.fire('changeDate')
      },
      grupo (){
        axios.get('/admin/pagos/getverificat?'+'dat='+this.date+'&group='+this.selected).then((response) => {
          this.optionsB = response.data
        })
      }
    },
    components: {
      datePicker
    }
  }
</script>
<style>
.filter-bar {
  padding: 10px;
}
</style>

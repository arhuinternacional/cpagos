<template>
    <div class="filter-bar">
      <form class="form-inline">
        <div class="input-group mb-3">
          <label>Buscar Por:</label>&nbsp;
          <select class="form-control" v-model="selected">
            <option disabled value="">Por Favor Seleccione</option>
            <option :value="1">Company ID</option>
            <option :value="2">Company Name</option>
            <option :value="3">Tax Code</option>
          </select>&nbsp;
          <input width="100px" type="text" v-model="filterText" class="form-control" @keyup.enter="doFilter" >&nbsp;
          <div class="input-group-append">
            <button class="btn btn-primary" placeholder="Ingrese el parametro a buscar" @click.prevent="doFilter">Buscar</button>
          </div>&nbsp;
          <button class="btn" @click.prevent="resetFilter">Reset</button>
        </div>
      </form>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        filterText: '',
        selected: ''
      }
    },
    methods: {
      doFilter () {
        this.$events.fire('filter-set', this.selected, this.filterText)
      },
      resetFilter () {
        this.filterText = ''
        this.selected = ''
        this.$events.fire('filter-reset')
      }
    }
  }
</script>
<style>
.filter-bar {
  padding: 10px;
}
</style>

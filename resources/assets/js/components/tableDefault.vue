<template>
  <div class="container">
      <button class="btn btn-primary float-right" v-if="processing == false" :disabled="btnHab" @click="aprovacion">Aprobar</button>
      <div class="mx-auto" style="width: 100px;" v-if="processing == true">
          <i class="fa fa-spinner fa-spin" style="font-size:20px"></i>
      </div>
      <br><br>
      <hr>
      <code>Query: {{ query }}</code>
      <Datatable v-bind="$data"></Datatable>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      columns: [
        { title: 'id', field: 'id', visible: false},
        { title: 'Company ID', field: 'proveedors_id', sortable: true},
        { title: 'Driver ID', field: 'drivers_id', sortable: true},
        { title: 'Costo', field: 'costo', sortable: true},
        { title: 'Monto Total a Facturar (calculado)', field: 'total_factura', sortable: true},
        { title: 'Monto Total a Pagar (calculado)', field: 'total_pay', sortable: true},
        { title: 'Semana', field: 'week', sortable: true},
        { title: 'Año', field: 'year', sortable: true},
        { title: 'Estado', field: 'c_status', sortable: true},
        { title: 'Fecha', field: 'fecha_upload', sortable: true},  
      ],
      data: [], // no data
      btnHab: false,
      processing: false,
      total: 0,
      supportNested: true,
      Pagination: true,
      query: {},
      HeaderSettings: false,
      selection: [],
      pageSizeOptions: [5, 10, 15, 20],
      tblClass: 'display table-bordered dt-responsive',
      tblStyle: 'color: #666',
    }
  },
  created (){
    this.dataQuery()
  }, 
  methods: {
    dataQuery(){

      axios.get('/admin/costos/gethistoric', {
          limit: 10,
          type: 'ob'
      })
           .then((response) => {
              this.data = response.data.data
              this.total = response.data.recordsTotal

              //$('#selector').material_select();
      });
    },
    alerta(){

      alert(this.selection.map(({ id }) => id))
    },
    aprovacion(){
      this.btnHab = true
      this.processing = true
      axios.post('/admin/costos/aprovar', {
          data: this.selection
      })
           .then((response) => {
              //this.total = response.data.recordsTotal
              this.dataQuery()              
              this.btnHab = false
              this.processing = false
              //$('#selector').material_select();
      });
    },
  },
  watch: {
    query: {
      handler () {
        this.dataQuery()
      },
      deep: true
    }
  },
}
</script>
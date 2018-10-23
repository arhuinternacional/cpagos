<template>
  <div class="container-fluid">
    <div class="row col-12">
      <div class="col-8">
        <filter-bar-verp></filter-bar-verp>
        <div v-show="showTable" class="table-responsive">
          <vuetable ref="vuetable"
            api-url="/admin/pagos/getverificat"
            track-by="_id"
            :fields="fields"
            pagination-path=""
            :css="css.table"
            :sort-order="sortOrder"
            :multi-sort="true"
            detail-row-component="my-detail-row"
            :append-params="moreParams"
            @vuetable:cell-clicked="onCellClicked"
            @vuetable:checkbox-toggled="onToggle"
            @vuetable:pagination-data="onPaginationData"
          ></vuetable>
          <div class="vuetable-pagination">
            <vuetable-pagination-info ref="paginationInfo"
              info-class="pagination-info"
            ></vuetable-pagination-info>
            <vuetable-pagination ref="pagination"
              :css="css.pagination"
              @vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <input class="form-control" v-model="nro_oper" placeholder="Ingrese Numero de Operacion">
          <br>
          <div class="mx-auto" v-if="processing == false">
          <button class="btn btn-primary" v-if="processing == false" :disabled="btnHab" @click="aprobacion">Proceder</button>
          </div>
          <div v-else="processing == true">
              <i class="fa fa-spinner fa-spin" style="font-size:20px"></i>
          </div>&nbsp;
        </div>
        <vuetable ref="vuetable2"
          :apiMode="true"
          :data="dataObject"
          :fields="fields2"
          track-by="_id"
          pagination-path=""
          :css="css.table"
          :sort-order="sortOrder"
          :multi-sort="true"
          :append-params="moreParams"
          detail-row-component="my-detail-rows"
          @vuetable:cell-clicked="onCellClicked2"
          @vuetable:pagination-data="onPaginationData"
        ></vuetable>
      </div>
    </div>
  </div>
</template>

<script>
import accounting from 'accounting'
import moment from 'moment'
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import Vue from 'vue'
import VueEvents from 'vue-events'
import CustomActions from './CustomActions'
import DetailRowPV from './DetailRowPV'
import DetailRowPVD from './DetailRowPVD'
import FilterBar from './FilterBar'

Vue.use(VueEvents)
Vue.component('custom-actions', CustomActions)
Vue.component('my-detail-row', DetailRowPV)
Vue.component('my-detail-rows', DetailRowPVD)
Vue.component('filter-bar-verp', FilterBar)

export default {
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo,
  },
  data () {
    return {
      nro_oper: '',
      showTable: false,
      pending: [],
      processing: false,
      completed: [],
      btnHab: false,
      fields: [
        {
          name: '__sequence',
          title: '#',
          titleClass: 'text-right',
          dataClass: 'text-right'
        },
        {
          name: '__checkbox',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'proveedors.company_id',
          title: 'Company ID',
          sortField: 'proveedors.company_id',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'nombre',
          sortField: 'nombre',
          title: 'Nombre',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'importe',
          title: 'Importe',
          sortField: 'importe',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'transaction_emit',
          title: 'Fecha de Emision',
          sortField: 'transaction_emit',
          titleClass: 'text-center',
          dataClass: 'text-center',
          callback: 'formatDate|DD-MM-YYYY'
        },
        {
          name: 'status',
          sortField: 'status',
          title: 'Estado',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        /*{
          name: '__component:custom-actions',
          title: 'Acciones',
          titleClass: 'text-center',
          dataClass: 'text-center'
        }*/
      ],
      css: {
        table: {
          tableClass: 'table table-bordered table-striped table-hover', 
          ascendingIcon: 'glyphicon glyphicon-chevron-up',
          descendingIcon: 'glyphicon glyphicon-chevron-down',
        },
        pagination: {
          wrapperClass: 'pagination',
          activeClass: 'active',
          disabledClass: 'disabled',
          pageClass: 'page',
          linkClass: 'link',
          icons: {
            first: '',
            prev: '',
            next: '',
            last: '',
          },
        },
        icons: {
          first: 'glyphicon glyphicon-step-backward',
          prev: 'glyphicon glyphicon-chevron-left',
          next: 'glyphicon glyphicon-chevron-right',
          last: 'glyphicon glyphicon-step-forward',
        },
      },
      sortOrder: [
        { field: 'email', sortField: 'email', direction: 'asc'}
      ],
      moreParams: {},
      query: '',
      dataObject: [],
      fields2: [
        {
          name: 'proveedors.company_id',
          title: 'Company ID',
          sortField: 'proveedors.company_id',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'nombre',
          sortField: 'nombre',
          title: 'Nombre',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'importe',
          title: 'Importe',
          sortField: 'importe',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
      ],
    }
  },
  methods: {
    allcap (value) {
      return value.toUpperCase()
    },
    verificationLbl (value) {
      return value === 1
        ? '<span class="label label-success"><i class="glyphicon glyphicon-star"></i> Verificado</span>'
        : '<span class="label label-danger"><i class="glyphicon glyphicon-heart"></i> No Verificado</span>'
    },
    formatNumber (value) {
      return accounting.formatNumber(value, 2)
    },
    formatDate (value, fmt = 'D MMM YYYY') {
      return (value == null)
        ? ''
        : moment(value, 'YYYY-MM-DD').format(fmt)
    },
    onPaginationData (paginationData) {
      this.$refs.pagination.setPaginationData(paginationData)
      this.$refs.paginationInfo.setPaginationData(paginationData)
    },
    onChangePage (page) {
      this.$refs.vuetable.changePage(page)
    },
    onCellClicked(data, field, event){
      this.$refs.vuetable.toggleDetailRow(data._id)
    },
    onCellClicked2(data, field, event){
      this.$refs.vuetable2.toggleDetailRow(data._id)
    },
    onToggle (checked, data) {
      if (checked == true) {
        console.log('cellClicked: ', checked)
        this.dataObject.push(data)
      }else{
        for (var i =0; i < this.dataObject.length; i++)
         if (this.dataObject[i]._id === data._id) {
            this.dataObject.splice(i,1);
            break;
        }
      }
    },
    passData(){
      this.$refs.vuetable2.setData(this.dataObject)
    },
    aprobacion(){
        this.btnHab = true
        this.processing = true
       axios.post('/admin/pagos/getverificat',{
        data: this.$refs.vuetable2.data,
        nro: this.nro_oper,
        params: this.moreParams
       }).then((response) => {
        if (response.data.error_id == 1001) {
            this.btnHab = false
            this.processing = false
            this.nro_oper = ''
            this.$events.fire('filter-reset')
          }else{
            this.btnHab = false
            this.processing = false
            this.nro_oper = ''
            this.$events.fire('filter-reset')
          }
        })
    }
  },
  events: {
    'filter-set' (filterText) {
      this.moreParams = filterText
      this.showTable = true
      Vue.nextTick( () => this.$refs.vuetable.refresh() )
    },
    'filter-reset' () {
      this.moreParams = {}
      this.showTable = false
      this.selectedTo = []
      this.dataObject = []
      Vue.nextTick( () => this.$refs.vuetable.refresh() )
    },
    'changeDate'(){
      this.moreParams = {}
      this.showTable = false
      this.selectedTo = []
      this.dataObject = []
      Vue.nextTick( () => this.$refs.vuetable.refresh() )
    }
  },
  computed:{

  }
}
</script>
<style>
.pagination {
  margin: 0;
  float: right;
}
.pagination a.page {
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 10px;
  margin-right: 2px;
}
.pagination a.page.active {
  color: white;
  background-color: #337ab7;
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 10px;
  margin-right: 2px;
}
.pagination a.btn-nav {
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 7px;
  margin-right: 2px;
}
.pagination a.btn-nav.disabled {
  color: lightgray;
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 7px;
  margin-right: 2px;
  cursor: not-allowed;
}
.pagination-info {
  float: left;
}
</style>

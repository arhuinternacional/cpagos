<template>
  <div class="content">
    <div class="float-left">
    <filter-bar-prov></filter-bar-prov>
    </div>
    <div class="form-inline float-right">
      <div v-if="processing == false">
      <button class="btn btn-primary float-right" v-if="processing == false" v-text="texto" :disabled="btnHab" @click="aprobacion"></button>
      </div>
      <div class="float-right" v-else="processing == true">
          <i class="fa fa-spinner fa-spin" style="font-size:20px"></i>
      </div>&nbsp;
      <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-import">
        Importar Proveedores
      </button>
    </div>
    <div class="table-responsive">
      <vuetable ref="vuetable"
        api-url="/admin/proveedor/proveedorget"
        track-by="_id"
        :fields="fields"
        pagination-path=""
        :css="css.table"
        :sort-order="sortOrder"
        :multi-sort="true"
        detail-row-component="my-detail-rowprov"
        :append-params="moreParams"
        @vuetable:cell-clicked="onCellClicked"
        @vuetable:pagination-data="onPaginationData"
      ></vuetable>
    </div>
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
import DetailRow from './DetailRow'
import FilterBar from './FilterBar'

Vue.use(VueEvents)
Vue.component('custom-actionsprov', CustomActions)
Vue.component('my-detail-rowprov', DetailRow)
Vue.component('filter-bar-prov', FilterBar)

export default {
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo,
  },
  data () {
    return {
      pending: [],
      processing: false,
      completed: [],
      btnHab: false,
      texto: 'Sincronizar',
      fields: [
        {
          name: '__sequence',
          title: '#',
          titleClass: 'text-right',
          dataClass: 'text-right'
        },
        {
          name: 'company_id',
          title: 'Company ID',
          sortField: 'company_id',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'company_name',
          title: 'Company Name',
          sortField: 'company_name',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'company_email',
          sortField: 'company_email',
          title: 'Company Email',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'tax_code',
          title: 'Tax Code',
          sortField: 'tax_code',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'company_notes',
          title: 'Close2U',
          titleClass: 'text-center',
          dataClass: 'text-center',
          callback: 'verificationLbl'
        },
        {
          name: 'company_phone',
          sortField: 'company_phone',
          title: 'Telefono',
          titleClass: 'text-center',
          dataClass: 'text-right',
        },
        {
          name: '__component:custom-actionsprov',
          title: 'Acciones',
          titleClass: 'text-center',
          dataClass: 'text-center'
        }
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
        { field: 'company_id', sortField: 'company_id', direction: 'asc'}
      ],
      moreParams: {}
    }
  },
  methods: {
    allcap (value) {
      return value.toUpperCase()
    },
    verificationLbl (value) {
      return value === true
        ? '<span class="label label-success rounded"> &nbsp; Verificado &nbsp; </span>'
        : '<span class="label label-danger rounded"> &nbsp; No Verificado &nbsp; </span>'
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
    onCellClicked (data, field, event) {
      console.log('cellClicked: ', field.name)
      this.$refs.vuetable.toggleDetailRow(data._id)
    },
    dataQuery(){
      this.btnHab = true
      this.processing = true
      axios.get('/admin/proveedorclose', {
          listado: true
      }).then((response) => {
        this.pending = response.data
        this.btnHab = false
        this.processing = false
        Vue.nextTick( () => this.$refs.vuetable.refresh() )
        toastr.success('Sincronizacion Completada', 'Success Alert', {timeOut: 5000});
      })
    },
    aprobacion(){
      this.dataQuery()
    }
  },
  events: {
    'filter-set' (filterCrit, filterText) {
      this.moreParams = {
        crit: filterCrit,
        filter: filterText
      }
      Vue.nextTick( () => this.$refs.vuetable.refresh() )
    },
    'filter-reset' () {
      this.moreParams = {}
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

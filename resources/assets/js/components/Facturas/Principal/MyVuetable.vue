<template>
  <div class="container-fluid">
    <div class="row col-12">
      <div class="col-sm-10 float-left">
        <filter-factprinci></filter-factprinci>
      </div>
      <div class="col-sm-2">
        <div class="form-group">
          
        </div>
      </div>
    </div>
    <div class="row">
      <div class="table-responsive">
        <vuetable ref="vuetable"
          api-url="/admin/facturas/getfacturas"
          track-by="_id"
          :fields="fields"
          pagination-path=""
          :css="css.table"
          :sort-order="sortOrder"
          :multi-sort="true"
          :append-params="moreParams"
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
Vue.component('custom-actions', CustomActions)
Vue.component('my-detail-row', DetailRow)
Vue.component('filter-factprinci', FilterBar)

export default {
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo,
  },
  data () {
    return {
      processing: false,
      btnHab: false,
      fields: [
        {
          name: '__sequence',
          title: '#',
          titleClass: 'text-right',
          dataClass: 'text-right'
        },
        {
          name: 'year',
          title: 'Año',
          sortField: 'year',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'week',
          title: 'Semana',
          sortField: 'week',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'proveedors.company_id',
          title: 'Company ID',
          //sortField: 'proveedores.company_id',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'proveedors.company_name',
          title: 'Company Name',
          //sortField: 'drivers.driver',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'proveedors.tax_code',
          //sortField: 'proveedors.tax_code',
          title: 'RUC',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'total_fact',
          sortField: 'total_fact',
          title: 'Total Factura',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'total_pay',
          sortField: 'total_pay',
          title: 'Total Pagar',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'status',
          sortField: 'status',
          title: 'Estado',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'fact_day',
          sortField: 'fact_day',
          title: 'Fecha de Factura',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'fact_type',
          sortField: 'fact_type',
          title: 'Tipo de Factura',
          titleClass: 'text-center',
          dataClass: 'text-center',
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
        { field: 'proveedors.company_id', sortField: 'proveedors.company_id', direction: 'asc'}
      ],
      moreParams: {}
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
    onCellClicked (data, field, event) {
      console.log('cellClicked: ', field.name)
      this.$refs.vuetable.toggleDetailRow(data._id)
    },
    aprobar (){
      console.log('hola')
      this.btnHab = true
      this.processing = true
      axios.post('/admin/costos/aprobar', {
        data: this.$refs.vuetable.selectedTo
      }).then((response) => {
        console.log(response.data)
        this.btnHab = false
        this.processing = false
        Vue.nextTick( () => this.$refs.vuetable.refresh() )
      })
    },
  },
  events: {
    'filter-set' (filterText, critSelected) {
      this.moreParams = {
        filter: filterText,
        crit: critSelected
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

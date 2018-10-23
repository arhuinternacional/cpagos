<template>
  <div class="content">
    
    <div class="table-responsive">
      <vuetable ref="vuetable"
        api-url="/admin/proveedor/proveedorget"
        :fields="fields"
        pagination-path=""
        :css="css.table"
        :sort-order="sortOrder"
        :multi-sort="true"
        :table-height="height"
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

Vue.use(VueEvents)

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
      height: '300px',
      fields: [
        {
          name: 'company_id',
          title: 'Company ID',
          sortField: 'company_id',
          titleClass: 'text-center',
          dataClass: 'text-center',
          width: '100px'
        },
        {
          name: 'company_name',
          title: 'Company Name',
          sortField: 'company_name',
          titleClass: 'text-center',
          dataClass: 'text-center',
          width: '100px'
        },
        {
          name: 'company_email',
          sortField: 'company_email',
          title: 'Company Email',
          titleClass: 'text-center',
          dataClass: 'text-center',
          width: '100px'
        },
        {
          name: 'tax_code',
          title: 'Tax Code',
          sortField: 'tax_code',
          titleClass: 'text-center',
          dataClass: 'text-center',
          width: '100px'
        },
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
      this.$refs.vuetable.toggleDetailRow(data.id)
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

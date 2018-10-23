<template>
  <div class="content">
    <section class="content-header">
      <h1>
        Administrar usuarios
      </h1>
    </section>
    <hr>
    <div class="float-left">
    <filter-bar-user></filter-bar-user>
    </div>
    <div class="form-inline float-right">
      <b-btn v-b-modal.modal1>Launch demo modal</b-btn>

      <!-- Modal Component -->
      <b-modal id="modal1"
             ref="modalCreate"
             title="Usuario"
             size="lg"
             @ok="handleOk"
             @shown="clearName">
        <b-row class="ml-3">
          <b-col md="1"><label class="mt-2" :for="name">Nombre</label><b-form-input :id="name" :type="type"></b-form-input></b-col>
          <b-col md="11"><label class="mt-2" :for="name">Nombre</label><b-form-input :id="name" :type="type"></b-form-input></b-col>
        </b-row>
      </b-modal>
    </div>
    <div class="table-responsive">
      <vuetable ref="vuetable"
        api-url="/admin/getusers"
        track-by="_id"
        :fields="fields"
        pagination-path=""
        :css="css.table"
        :sort-order="sortOrder"
        :multi-sort="true"
        detail-row-component="my-detail-rowuser"
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
import { Modal } from 'bootstrap-vue/es/components';
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

Vue.use(Modal);
Vue.use(VueEvents)
Vue.component('custom-actionsprov', CustomActions)
Vue.component('my-detail-rowuser', DetailRow)
Vue.component('filter-bar-user', FilterBar)

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
          name: 'name',
          title: 'Nombre',
          sortField: 'name',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'email',
          title: 'Correo Electronico',
          sortField: 'email',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'username',
          sortField: 'username',
          title: 'Nombre de Usuario',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'perfil',
          title: 'Perfil',
          sortField: 'perfil',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        {
          name: 'estado',
          sortField: 'estado',
          title: 'Estado',
          titleClass: 'text-center',
          dataClass: 'text-center',
          callback: 'verificationLbl'
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
        ? '<span class="label label-success rounded"> &nbsp; Habilitado &nbsp; </span>'
        : '<span class="label label-danger rounded"> &nbsp; No Habilitado &nbsp; </span>'
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

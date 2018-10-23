
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.moment = require('moment')

import bFormFile from 'bootstrap-vue/es/components/form-file/form-file';
import Datatable from 'vue2-datatable-component'

window.dt = require( 'datatables.net' )

window.BootstrapVue = require('bootstrap-vue');

Vue.use(Datatable)
Vue.use(BootstrapVue);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('b-form-file', bFormFile);
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('Costo', require('./components/Costo.vue'));
Vue.component('costo-principal', require('./components/Costos/Principal/MyVuetable.vue'));
Vue.component('costo-historico', require('./components/Costos/Historial/MyVuetable.vue'));
Vue.component('costo-incident-principal', require('./components/CostoIncidents/Principal/MyVuetable.vue'));
Vue.component('costos', require('./components/CostoAlerts.vue'));
Vue.component('Facturas', require('./components/Factura.vue'));
Vue.component('facturas-listado', require('./components/Facturas/Principal/MyVuetable.vue'));
Vue.component('facturas-close', require('./components/Facturas/Close2u/MyVuetable.vue'));
Vue.component('Facturasupload', require('./components/FacturaUpload.vue'));
Vue.component('Facturasmanual', require('./components/FacturaManual.vue'));
Vue.component('Facturagenerate', require('./components/FacturaGenerate.vue'));
Vue.component('facturachecker', require('./components/FacturaChecker.vue'));
Vue.component('Pagogenerate', require('./components/PagoGenerate.vue'));
Vue.component('proveedorupload', require('./components/Proveedores/Proveedorupload.vue'));
Vue.component('tablefault', require('./components/tableDefault.vue'));
Vue.component('proveedorindex', require('./components/Proveedores/ProveedorListado.vue'));
Vue.component('my-vuetable', require('./components/Proveedores/MyVuetable.vue'));
//pagos
Vue.component('pagos', require('./components/Pagos/General/MyVuetable.vue'));
Vue.component('verificacionpago', require('./components/Pagos/Verificacion/MyVuetable.vue'));
Vue.component('incidentepagos', require('./components/Pagos/Incidentes/MyVuetable.vue'));
Vue.component('costoaprovacion', require('./components/Costos/Aprobacion/MyVuetable.vue'));
//Dashboard
Vue.component('logusuarios', require('./components/Dashboard/LogsTable.vue'));
Vue.component('usuarios', require('./components/Usuarios/MyVuetable.vue'));

const app = new Vue({
    el: '#app',
    data: {
        costos: {
            progress: 0,
            max: 100,
            messages: []
        },
        messages2: [],
        facturas: {
            progress: 0,
            max: 100,
            messages: []
        },
        close2:{},
        pagos: {
            progress: 0,
            max: 100,
            messages: []
        },
        proveedores: {
            progress: 0,
            messages: [],
            max: 100
        },
        
    },
    mounted(){
        //this.fetchMessages();
        Echo.private('chat')
            .listen('CostoProgress', (e) => {   
                if (e.message.close) {
                    this.costos.max = 100
                    this.costos.progress = 100
                    return
                }
                if (e.message.alerts) {
                    this.costos.messages.push({   message: e.message})
                }
                if (e.message.max) {
                    this.costos.max = e.message.max
                    this.costos.progress = 0
                    return
                }
                if (e.message.current){
                    this.costos.progress = e.message.current
                }  
            })
            .listen('CostoEvent', (e) => {  this.messages2.push({   message: e.message  })})
            .listen('Facturas.FacturaProgress', (e) => { 
                if (e.message.close) {
                    this.facturas.max = 100
                    this.facturas.progress = 100
                    return
                }
                if (e.message.alerts) {
                    this.facturas.messages.push({   message: e.message})
                }
                if (e.message.max) {
                    this.facturas.max = e.message.max
                    this.facturas.progress = 0
                    return
                }
                if (e.message.current){
                    this.facturas.progress = e.message.current
                }
            })
            .listen('ProveedorEvent', (e) => { 
                if (e.message.close) {
                    this.proveedores.max = 100
                    this.proveedores.progress = 100
                    return
                }
                if (e.message.alerts) {
                    this.proveedores.messages.push({   message: e.message})
                }
                if (e.message.max) {
                    this.proveedores.max = e.message.max
                    this.proveedores.progress = 0
                    return
                }
                if (e.message.current) {
                    this.proveedores.progress = e.message.current
                }
                if (e.message.error) {
                    this.proveedores.messages.push({   message: e.message})
                    return
                }
            })
            .listen('Pago.PagoGenerateProgress', (e) => { 
                if (e.message.close) {
                    this.pagos.max = 100
                    this.pagos.progress = 100
                    return
                }
                if (e.message.alerts) {
                    this.pagos.messages.push({   message: e.message})
                }
                if (e.message.max) {
                    this.pagos.max = e.message.max
                    this.pagos.progress = 0
                    return
                }
                if (e.message.current) {
                    this.pagos.progress = e.message.current
                }
                if (e.message.error) {
                    this.pagos.messages.push({   message: e.message})
                    return
                }
            })
    },
    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages.messages = response.data
                //console.log(this.messages)
            })
        },

    }

});


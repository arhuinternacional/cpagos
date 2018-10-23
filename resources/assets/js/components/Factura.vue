<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <select class="form-control col-6" v-model="selecteds" id="selector">
                        <option 
                            v-for="item in items" 
                            :value="item" 
                            >{{ item }}
                        </option>
                    </select>
                </div>
                    <hr>
                    <button class="btn btn-primary" :disabled="btnHab" @click="generate">Generar</button>
                    <button class="btn btn-secondary" :disabled="btnHab" @click="generateAll">Generar Todos</button>
                    <div class="mx-auto" style="width: 100px;" v-if="loading == true">
                        <i class="fa fa-spinner fa-spin" style="font-size:20px"></i>
                    </div>
                    <hr>
                    <b-progress class="mb-3" height="60px" :max="facturas.max" show-progress animated>
                     
                        <b-progress-bar :value="facturas.progress"></b-progress-bar>
                    </b-progress>
                    <div v-if="url">
                        <a class="btn btn-success" :href="url">Descargar</a>
                    </div>
                    <hr>
                    <div class="row" v-for="alert in facturas.messages">
                    <div class="col">
                       <b-alert variant="success" show>
                            <span>Completados: {{ alert.message.success }}</span>                       
                       </b-alert> 
                    </div>
                    <div class="col">
                        <b-alert variant="warning" show>
                            <span>Incidentes: {{ alert.message.warnings }}</span>
                            <br> 
                            <a class="btn btn-secondary" v-if="alert.message.warnings > 0" :href="alert.message.urlWarning">Descargar Reporte</a> 
                       </b-alert> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['facturas'],
        data () {
        return {
                items: [],
                selecteds: null,
                url: null,
                btnHab : false,
                loading: false
            }
        },
        created () {
            this.list()
        },
        methods: {
            generate(){
                this.btnHab = true
                this.loading = true
                axios.post('/admin/facturas/generate', {
                    fecha: this.selecteds,
                    listGen: true
                })
                     .then((response) => {
                        this.loading = false 
                        this.btnHab = false
                        this.selecteds = null

                        //$('#selector').material_select();
                });
                this.list()
            },
            list(){
                axios.post('/admin/facturas/getlist', {
                    listCost: true
                })
                     .then((response) => {
                        this.items = response.data 

                        //$('#selector').material_select();
                });
            },
            generateAll(){
                this.btnHab = true
                this.loading = true
                this.list()
                this.selecteds = null
                axios.post('/admin/facturas/generate', {
                    listAll: true
                })
                     .then((response) => {
                        this.loading = false 
                        this.btnHab = false

                        //$('#selector').material_select();
                });

                this.list()
            }
        }    
    }
</script>
<style scoped>
    .panel{
        margin-bottom: 0;
    }
    
</style>
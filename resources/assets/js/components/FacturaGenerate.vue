<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row" v-for="alert in facturas.messages">
                    <div class="col">
                       <b-alert variant="success" show>
                            <span>{{ alert }}</span>                       
                       </b-alert> 
                    </div>
                    <div class="col">
                        <b-alert variant="warning" show>
                            <span>{{ alert }}</span>
                            <br> 
                            <!-- <a class="btn btn-secondary" :href="alert.message.urlWarning">Descargar Reporte</a> -->
                       </b-alert> 
                    </div>
                    <div class="col">
                        <b-alert variant="danger" show>
                            <span>{{ alert }}</span>
                            <br> 
                            <!-- <a class="btn btn-secondary" :href="alert.message.urlFails">Descargar Reporte</a> -->
                       </b-alert> 
                    </div>
                </div>
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
                    <button class="btn btn-primary" @click="generate">Generar</button>
                    <hr>
                    <div v-if="url">
                        <a class="btn btn-success" :href="url">Descargar</a>
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
                url: null
            }
        },
        created () {
        axios.post('/admin/facturas/getlist', {
            listGen: true
        })
             .then((response) => {
                this.items = response.data 

                //$('#selector').material_select();
        });
        },
        methods: {
            generate(){
                axios.post('/admin/facturas/downloadfact', {
                    data: this.selecteds
                })
                     .then((response) => {
                        this.url = response.data 

                        //$('#selector').material_select();
                });
            }
        }    
    }
</script>
<style scoped>
    .panel{
        margin-bottom: 0;
    }
    
</style>
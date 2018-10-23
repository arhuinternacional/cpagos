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
                    <div class="mx-auto" style="width: 100px;" v-if="loading == true">
                        <i class="fa fa-spinner fa-spin" style="font-size:20px"></i>
                    </div>
                    <hr>
                    <b-progress class="mb-3" height="60px" :max="pagos.max" show-progress animated>
                     
                        <b-progress-bar :value="pagos.progress"></b-progress-bar>
                    </b-progress>
                    <hr>
                    <div class="row" style="width: 100%;" v-for="alert in pagos.messages">
                        <a class="btn btn-success mx-auto" v-if="alert.message.url" :href="alert.message.url">Descargar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['pagos'],
        data () {
        return {
                items: [],
                selecteds: null,
                url: null,
                btnHab : false,
                loading: false
            }
        },
        
        methods: {
            generate(){
                this.btnHab = true
                this.loading = true
                axios.post('/admin/pagos/generate', {
                    data: this.selecteds
                })
                     .then((response) => {
                        this.loading = false 
                        this.btnHab = false
                        this.selecteds = null
                        this.url = response.data 

                        //$('#selector').material_select();
                });
                this.list()
            },
            list(){
                axios.get('/admin/pagos/getlist')
                     .then((response) => {
                        this.items = response.data 

                        //$('#selector').material_select();
                });
            },
        },
        created () {
            this.list()
        },    
    }
</script>
<style scoped>
    .panel{
        margin-bottom: 0;
    }
    
</style>
<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <b-form-group id="fieldsetHorizontal"
                horizontal
                :label-cols="1"
                breakpoint="md"
                description="Archivo de Costos"
                label="Archivo"
                label-for="inputHorizontal">
                <b-form-file v-model="file" :state="Boolean(file)" id="file" @change="handleFileUpload" placeholder="Seleccione un archivo..."></b-form-file>
                </b-form-group>
                
                <hr>
                <div style="width: 100%">
                    <button class="btn btn-primary" style="margin-left: 40%;" :disabled="btnHab" v-if="processing == false" v-on:click="submitFile()">Enviar</button>
                    <div class="mx-auto" style="width: 100px;" v-if="processing == true">
                        <i class="fa fa-spinner fa-spin" style="font-size:20px"></i>
                    </div>
                </div>
                
                <hr>
                <b-progress class="mb-3" height="60px" :max="costos.max" show-progress animated>
                     
                    <b-progress-bar :value="costos.progress" :label="costos.progress+' %'"></b-progress-bar>
                </b-progress>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['costos'],
        data () {
        return {
                max: 100,
                file: false,
                processing: false,
                btnHab: false
            }
        },
        mounted() {
            console.log(this.costos.progress)
        },
        methods: {
            submitFile(){
                if (this.processing == true) {
                    alert('ya esta subiendo');
                    return;
                }

                if (this.file == false) {
                    alert('no hay imagen');
                    return;
                }

                this.processing = true
                this.btnHab = true

            /*
                    Initialize the form data
                */
                let formData = new FormData();

                /*
                    Add the form data we need to submit
                */
                formData.append('file', this.file);

            /*
              Make the request to the POST /single-file URL
            */
                axios.post( '/admin/costos/setcostos',
                    formData,
                    {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                  }
                ).then((response) => {
                        this.processing = false 
                        this.btnHab = false

                        //$('#selector').material_select();
                });

            //this.file = false;

            
          },
          handleFileUpload(){
            this.file = this.$refs.file;
            //console.log(file)
          }
        }
    }
</script>
<style scoped>
    .panel{
        margin-bottom: 0;
    }
    
</style>
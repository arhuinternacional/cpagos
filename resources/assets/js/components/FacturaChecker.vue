<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <b-form-group id="fieldsetHorizontal"
                horizontal
                :label-cols="1"
                breakpoint="md"
                description="Archivo de Factura para Verificar"
                label="Archivo"
                label-for="inputHorizontal">
                <b-form-file v-model="file" :state="Boolean(file)" id="file" @change="handleFileUpload" placeholder="Seleccione un archivo..."></b-form-file>
                </b-form-group>
                
                <hr>
                <div style="width: 100%">
                    <button class="btn btn-primary" style="margin-left: 40%;" v-on:click="submitFile()">Enviar</button>
                </div>
                
                <hr>
                <b-progress class="mb-3" height="60px" :max="facturas.max" show-progress animated>
                     
                        <b-progress-bar :value="facturas.progress" :label="facturas.progress+' %'"></b-progress-bar>
                    </b-progress>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['facturas'],
        data () {
        return {
                max: 100,
                file: false,
                processing: false
            }
        },
        mounted() {
            //console.log(this.messages.variable)
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

                //this.processing = true;

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
                axios.post( '/admin/facturas/importclose',
                    formData,
                    {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                  }
                ).then(function(){
              console.log('SUCCESS!!');
            })
            .catch(function(){
              console.log('FAILURE!!');
            });

            this.processing = false

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
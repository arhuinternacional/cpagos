<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row" v-for="alert in messages2">
                    <div class="col">
                       <b-alert variant="success" show>
                            <span>{{ alert.message.success }}</span>                       
                       </b-alert> 
                    </div>
                    <div class="col">
                        <b-alert variant="warning" show>
                            <span>{{ alert.message.warnings }}</span>
                            <br> 
                            <a class="btn btn-secondary" v-if="alert.message.warnings > 0" :href="alert.message.urlWarning">Descargar Reporte</a>
                       </b-alert> 
                    </div>
                    <div class="col">
                        <b-alert variant="danger" show>
                            <span>{{ alert.message.fails }}</span>
                            <br> 
                            <a class="btn btn-secondary" v-if="alert.message.fails > 0" :href="alert.message.urlFails">Descargar Reporte</a>
                       </b-alert> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['messages2'],
        
        mounted() {
            //console.log(this.messages.variable)
        },        
    }
</script>
<style scoped>
    .panel{
        margin-bottom: 0;
    }
    
</style>
  <template>
    <div class="custom-actions">
      <a class="btn btn-sm" :href="'/admin/proveedor/'+rowData.company_id"><i class="fa fa-search"></i></a>
      <!-- <button class="btn btn-sm" @click="itemAction('view-item', rowData, rowIndex)"><i class="fa fa-search"></i></button> -->
      <!-- <button class="btn btn-sm" @click="itemAction('edit-item', rowData, rowIndex)"></button> -->
      <button class="btn btn-sm" data-toggle="modal" data-target="#mails_modal"><i class="fa fa-envelope"></i></button>

      <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="mails_modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Envio de Correo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4 center-block">
                <p style="text-align: center">Problemas Clavesol.</p>
                <p style="text-align: center"><span style="font-size: 110px;" class="fa fa-id-card"></span></p>
                <br>
                <p style="text-align: center; padding-top: 40px">
                  <button class="btn btn-primary" @click="mail(rowData, 1)">Enviar Correo</button>
                </p>
              </div>
              <div class="col-md-4 center-block">
                <p style="text-align: center;">Problemas Cuenta Bancaria.</p>
                <p style="text-align: center"><span style="font-size: 110px;" class="fa fa-university"></span></p>
                <br>
                <p style="text-align: center; padding-top: 40px">
                  
                  <button class="btn btn-primary" @click="mail(rowData, 2)">Enviar Correo</button>
                </p>
              </div>
              <div class="col-md-4 center-block">
                <p style="text-align: center;">Ingrese el mensaje personalizado</p>
                <p style="text-align: center; padding-top: 10px">
                  <textarea class="form-control" v-model="textMail" cols="25" rows="5"></textarea>
                  <br><br>
                  <button class="btn btn-primary" @click="mail(rowData, 3)">Enviar Correo</button>
                </p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" @click="clear" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div>
    </div>
    </div>


  </template>

  <script>
  export default {
    data (){
      return {
        textMail: ''
      }
    },
    props: {
      rowData: {
        type: Object,
        required: true
      },
      rowIndex: {
        type: Number
      },
    },
    methods: {
      itemAction (action, data, index) {
        console.log('custom-actions: ' + action, data.name, index)
      },
      clear(){
        this.textMail = ''
      },
      mail (data, type){
        axios.post('/admin/proveedor/mail', {
          data: this.textMail,
          tipo: type,
          to: data.id
        }).then((response) => {
          console.log(response.data)
          console.log(data)
          toastr.success('Correo Enviado', 'Success Alert', {timeOut: 5000});
        })
      }
    }
  }
  </script>

  <style>
    .custom-actions button.ui.button {
      padding: 8px 8px;
    }
    .custom-actions button.ui.button > i.icon {
      margin: auto !important;
    }
  </style>

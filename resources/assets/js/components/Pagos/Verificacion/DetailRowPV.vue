<template>
  <div @click="onClick">
    <div class="inline field">
      <label>Company ID: </label>
      <span>{{rowData.company_id}}</span>
    </div>
    <div class="inline field">
      <label>Company Name: </label>
      <span>{{rowData.company_name}}</span>
    </div>
    <div class="inline field">
      <label>Email: </label>
      <span>{{rowData.company_email}}</span>
    </div>
    <div class="inline field">
      <label>Tax Code: </label>
      <span>{{rowData.tax_code}}</span>
    </div>
    <div class="inline field">
      <label>Nombre de Propietario de Cuenta Bancaria: </label>
      <span>{{rowData.bank_account_holder_name}}</span>
    </div>
    <div class="inline field">
      <label>Tipo Documento Banco Registrado : </label>
      <span>{{rowData.bank_tax_code_name}}</span>
    </div>
    <div class="inline field">
      <label>Numero de Documento Banco: </label>
      <span>{{rowData.bank_tax_code}}</span>
    </div>
    <div class="inline field">
      <label>Numero de Cuenta Bancario: </label>
      <span>{{rowData.bank_account_number}}</span>
    </div>
    <div class="inline field">
      <label>Registro Close2U: </label>
      <span>{{rowData.company_notes}}</span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    rowData: {
      type: Object,
      required: true
    },
    rowIndex: {
      type: Number
    }
  },
  methods: {
    onClick (event) {
      console.log('my-detail-row: on-click', event.target)
    }
  },
}
</script>

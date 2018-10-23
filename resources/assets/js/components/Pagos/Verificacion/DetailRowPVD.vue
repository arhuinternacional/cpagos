<template>
  <div>
    <div class="inline field">
      <label>Observacion: </label>
      <input class="form-control" v-model="rowData.observacion">
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
      //console.log('my-detail-row: on-click', event.target)
    }
  },
}
</script>

<template>
  <vue-excel-xlsx
      :data="items"
      :columns="columns"
      :file-name="reportName"
      :file-type="'xlsx'"
      :sheet-name="'sheet'"
  >
    <v-btn tile dark depressed color="#1d6f42">
      Excel
      <v-icon size="25" right>mdi-file-excel-outline</v-icon>
    </v-btn>
  </vue-excel-xlsx>
</template>
<script>
export default {
  props: ['items'],
  methods: {
    priceFormat(value){
      return '$ ' + value;
    }
  },
  computed: {
    reportName(){
      return this.items[0]?.report || 'report';
    },
    columns(){
      return Object.keys(this.items[0]).map(el => {
        return {
          label: el.toUpperCase(),
          field: el,
        }
      });
    }
  }
}
</script>
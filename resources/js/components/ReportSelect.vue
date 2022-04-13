<template>
  <v-select v-bind="$attrs" clearable @change="emitValues" v-model="selectedItem" :items="reports" item-value="id" item-text="name"/>
</template>
<script>
export default {
  props: ['value'],
  data() {
    return {
      selectedItem: null,
      loading: false,
    }
  },
  methods: {
    initItem() {
      this.selectedItem = this.value || null;
    },
    emitValues(val) {
      this.$emit('input', val);
      this.$emit('change', val);
    },
  },
  watch: {
    value() {
      this.initItem();
    }
  },
  mounted() {
    this.initItem();
  }
}
</script>
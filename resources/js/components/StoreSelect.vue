<template>
  <v-select v-bind="$attrs" v-model="selectedItem" @change="emitChange" :items="stores" item-value="id" item-text="name"/>
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
    emitChange(){
      this.$nextTick(() => this.$emit('change'));
    },

    initItem() {
      this.selectedItem = this.value || null;
    }
  },
  watch: {
    selectedItem(val) {
      this.$emit('input', val);
    },
    value() {
      this.initItem();
    }
  },
  mounted() {
    this.initItem();
  }
}
</script>
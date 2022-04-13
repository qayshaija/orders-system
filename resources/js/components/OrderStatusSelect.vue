<template>
  <v-select v-bind="$attrs" :color="selectColor" @change="emitChange" v-model="selectedItem" :items="orderStatuses" item-value="id" item-text="name">
    <template v-slot:item="{item}">
      <div :style="`color:${item.color};`">{{ item.name }}</div>
    </template>
    <template v-slot:selection="{item}">
      <div :style="`color:${item.color};`">{{ item.name }}</div>
    </template>
  </v-select>
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
    emitChange() {
      this.$nextTick(() => this.$emit('change'));
    },
    initItem() {
      this.selectedItem = this.value ? Number.parseInt(this.value) : null;
    }
  },
  computed: {
    selectColor() {
      if (this.selectedItem) {
        return this.orderStatuses.find(el => el.id === this.selectedItem).color;
      }
      return 'primary';
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
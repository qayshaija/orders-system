<template>
  <v-select v-bind="$attrs" :color="selectColor" @change="emitChange" v-model="selectedItem" :items="items" item-value="id" item-text="name">
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
      items: [
        {id: 1, name: 'Preparing', color: 'black'},
        {id: 2, name: 'Out for delivery', color: 'blue'},
        {id: 3, name: 'Partially Completed', color: 'orange'},
        {id: 4, name: 'Completed', color: 'green'},
      ],
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
        return this.items.find(el => el.id === this.selectedItem).color;
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
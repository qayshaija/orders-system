<template>
  <v-sheet outlined class="px-2 py-1">
    <div v-for="(item, i) in items" class="d-flex align-end justify-space-between">
      <v-text-field dense class="mr-2 pt-0" placeholder="Title" v-model="item.title" hide-details/>
      <v-text-field dense class="mr-2 pt-0" style="max-width: 80px"
                    placeholder="Price" v-model="item.price" type="number" hide-details/>
      <v-checkbox color="green" dense label="MAIN" class="mt-0 pt-0 mr-2" hide-details v-model="item.isPrimary"/>
      <delete-dialog @confirm="removeItem(item)">
        <v-icon size="22">mdi-delete</v-icon>
      </delete-dialog>
    </div>

    <v-btn block text depressed small @click="newItem" :class="items.length ? 'mt-2' : ''">
      <v-icon left>mdi-plus</v-icon>
      Add Product
    </v-btn>
  </v-sheet>
</template>
<script>
export default {
  props: ['order'],
  data() {
    return {
      items: [],
    }
  },
  methods: {
    removeItem(item) {
      let index = this.items.indexOf(item);
      this.items.splice(index, 1);
    },
    newItem() {
      this.items.push({
        title: '',
        price: '',
        isPrimary: true
      })
    },
    initValues() {
      this.items = _.cloneDeep(this.order.orderItems) || [];
    }
  },
  watch: {
    items: {
      deep: true,
      handler() {
        this.order.orderItems = _.cloneDeep(this.items);
      }
    }
  },
  mounted() {
    this.initValues();
  }
}
</script>
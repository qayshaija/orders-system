<template>
  <v-dialog v-model="dialog" max-width="500">
    <template v-slot:activator="{on}">
      <div v-on="on">
        <slot/>
      </div>
    </template>
    <v-card v-if="dialog">
      <v-card-title>Order Data</v-card-title>
      <v-card-text>
        <v-form ref="orderForm">
          <v-row no-gutters>
            <v-col>
              <v-text-field hide-details placeholder="Name" label="Name" v-model="tmpOrder.fullName"/>
            </v-col>
            <v-col>
              <v-text-field hide-details placeholder="Address" label="Address" v-model="tmpOrder.address"/>
            </v-col>
          </v-row>
          <v-row no-gutters>
            <v-col>
              <v-text-field hide-details placeholder="Phone1" label="Phone1" v-model="tmpOrder.phone1"/>
            </v-col>
            <v-col>
              <v-text-field hide-details placeholder="Phone2" label="Phone2" v-model="tmpOrder.phone2"/>
            </v-col>
          </v-row>
          <v-row no-gutters>
            <v-col>
              <v-text-field hide-details type="number" placeholder="Total" label="Total" v-model="tmpOrder.amount"/>
            </v-col>
            <v-col>
              <store-select hide-details placeholder="Store" label="Store" v-model="tmpOrder.storeId"/>
            </v-col>
          </v-row>

          <v-text-field hide-details placeholder="Comments" label="Comments" v-model="tmpOrder.comments"/>

          <order-items :order="tmpOrder" class="mt-2"/>

        </v-form>
      </v-card-text>
      <v-card-actions class="d-flex justify-end">
        <v-btn depressed color="primary" @click="saveOrder">Save</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
import StoreSelect from "../../components/StoreSelect";
import OrderItems from "./order-items";

export default {
  props: ['order'],
  components: {OrderItems, StoreSelect},
  data() {
    return {
      dialog: false,
      loading: false,
      tmpOrder: null,
    }
  },
  watch: {
    dialog(val) {
      if (val) {
        this.initValues();
      }
    }
  },
  methods: {
    initOrderFields() {
      this.tmpOrder = {
        fullName: '',
        phone1: '',
        phone2: '',
        address: '',
        amount: '',
        comments: '',
        storeId: null,
        reportId: null,
      };
    },
    saveOrder() {
      this.loading = true;
      axios.post(this.postEndpoint, this.tmpOrder).then(res => {
        this.emitOrder(res.data);
        this.dialog = false;
      }).finally(() => this.loading = false)
    },
    emitOrder(order) {
      this.$emit('orderSaved', order)
    },
    initValues() {
      if (this.order) {
        this.tmpOrder = _.cloneDeep(this.order);
      } else {
        this.initOrderFields();
      }
    }
  },
  computed: {
    postEndpoint() {
      if (this.order) {
        return this.apis.updateOrder(this.order.id);
      }
      return this.apis.storeOrder;
    }
  },
  mounted() {
    this.initValues();
  }
}
</script>
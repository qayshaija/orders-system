<template>
  <v-card :loading="loading" outlined class="d-flex align-center pa-2">
    <div class="shrink mr-2">
      <report-select @change="bulkUpdate('reportId', selectedReport)" outlined dense hide-details label="Change Report" placeholder="Change Report" v-model="selectedReport"/>
    </div>
    <div class="shrink mr-2">
      <order-status-select @change="bulkUpdate('status', selectedStatus)" outlined dense hide-details label="Change Status" placeholder="Change Status" v-model="selectedStatus"/>
    </div>

    <div class="shrink mr-2">
      <v-btn tile depressed @click="copy" color="primary">
        <v-icon>mdi-content-copy</v-icon>
      </v-btn>
    </div>
    <div class="shrink mr-2">
      <export-to-excel :items="stringifiedOrder"/>
    </div>
    <div class="shrink">
      <delete-dialog @confirm="bulkDelete">
        <v-btn tile color="red" dark depressed>({{selected.length}}) <v-icon right size="25">mdi-delete</v-icon> </v-btn>
      </delete-dialog>
    </div>

  </v-card>
</template>
<script>
import ReportSelect from "../../components/ReportSelect";
import OrderStatusSelect from "../../components/OrderStatusSelect";
import ExportToExcel from "./export-to-excel";

export default {
  components: {OrderStatusSelect, ReportSelect, ExportToExcel},
  props: ['orders', 'selected'],
  data() {
    return {
      loading: false,
      selectedReport: null,
      selectedStatus: null,
    }
  },
  computed: {
    selectedOrders() {
      return this.orders.filter(el => this.selected.includes(el.id));
    },
    stringifiedOrder(){
      return this.selectedOrders.map(el => {
        let report = this.reportById(el.reportId);
        return {
          report: report.name || '',
          fullName: el.fullName,
          phone1: el.phone1,
          phone2: el.phone2,
          address: el.address,
          items: el.orderItems.map(o => o.title).join(" + "),
          amount: el.amount,
          comments: el.comments,
        }
      });
    },
  },
  methods: {
    hasSameValue(key) {
      return [...new Set(this.selectedOrders.map(el => el[key]))].length === 1;
    },
    copy() {
      let text = this.stringifiedOrder.map(order => {
        return Object.values(order).filter(el => !!el || typeof el === 'number').join("\n")
      }).join("\n__\n");
      this.$copyText(text);
    },
    initSelections() {
      this.selectedStatus = this.hasSameValue('status') ? this.selectedOrders[0].status : null;
      this.selectedReport = this.hasSameValue('reportId') ? this.selectedOrders[0].reportId : null;
    },
    removeSelectedOrders() {
      this.selected.forEach(id => {
        let index = this.orders.findIndex(el => el.id === id);
        this.orders.splice(index, 1);
      })
    },
    bulkDelete() {
      this.loading = true;
      axios.post(this.apis.bulkDeleteOrders, {orderIds: this.selected}).then(() => {
        this.removeSelectedOrders();
      }).finally(() => {
        this.loading = false;
        this.removeSelected();
      });
    },
    bulkUpdate(key, value) {
      this.loading = true;
      axios.post(this.apis.bulkUpdateOrders, {
        orderIds: this.selected,
        [key]: value
      }).then(res => {
        res.data.forEach(val => this.orderSplice(val));
      }).finally(() => {
        this.loading = false;
        this.removeSelected();
      });
    },
    orderSplice(newOrder) {
      let orderIndex = this.orders.findIndex(el => el.id === newOrder.id);
      this.orders.splice(orderIndex, 1, newOrder);
    },
    removeSelected() {
      this.$emit('removeSelected');
    }
  },
  watch: {
    selected() {
      this.initSelections();
    }
  },
  mounted() {
    this.initSelections();
  }
}
</script>
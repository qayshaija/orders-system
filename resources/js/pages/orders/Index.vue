<template>
  <div class="pa-2">
    <div class="d-flex justify-end mb-2">
      <v-btn depressed color="primary" small @click="toggleAnalytics" class="mr-2">{{ toggleAnalyticsText }}</v-btn>

      <add-edit-order-dialog @orderSaved="saveOrder">
        <v-btn depressed color="primary" small>Add Order</v-btn>
      </add-edit-order-dialog>

    </div>

    <orders-analytics :report-id="selectedReport" :orders="orders" v-if="showAnalytics" class="mb-2"/>


    <v-text-field clearable outlined dense class="mb-2" v-model="search" append-icon="mdi-magnify" label="Search" placeholder="Search" single-line hide-details></v-text-field>

    <report-chips class="mb-2" v-model="selectedReport"/>

    <v-data-table v-if="stores.length" :items-per-page="30" :search="search" :items="filteredOrders" :headers="headers" :loading="loading.getOrders">
      <template v-slot:item.report="{item}">
        {{ reportById(item.reportId).name }}
      </template>
      <template v-slot:item.store="{item}">
        {{ storeById(item.storeId).name }}
      </template>
      <template v-slot:item.status="{item}">
        <colored-order-status :order-status-id="item.status"/>
      </template>
      <template v-slot:item.phone1="{item}">
        <div><strong>{{ item.phone1 }}</strong></div>
        <div><strong>{{ item.phone2 }}</strong></div>
      </template>

      <template v-slot:item.orderItems="{item}">
        <div style="max-width: 300px">
          <v-sheet outlined pill v-for="(orderItem, i) in item.orderItems" :key="i" class="d-inline-block mr-1 align-center">
            <div class="d-flex align-center">
              <v-sheet tile left class="pa-1 white--text" :color="orderItem.isPrimary ? 'green' : 'primary'">
                {{ orderItem.price.toFixed(2) }}
              </v-sheet>
              <div class="pa-1"> {{ orderItem.title }}</div>
            </div>
          </v-sheet>
        </div>
      </template>

      <template v-slot:item.amount="{item}">
        {{ item.amount.toFixed(2) }}
      </template>

      <template v-slot:item.checkbox="{item}">
        <v-checkbox :value="item.id" v-model="selectedOrders"></v-checkbox>
      </template>

      <template v-slot:item.actions="{item}">
        <div class="d-flex align-center">
          <add-edit-order-dialog :order="item" @orderSaved="saveOrder">
            <v-btn icon depressed small>
              <v-icon color="primary">mdi-pencil</v-icon>
            </v-btn>
          </add-edit-order-dialog>
        </div>
      </template>
    </v-data-table>

    <bulk-select @removeSelected="removeSelected" v-if="selectedOrders.length" class="mt-2" :orders="orders" :selected="selectedOrders"></bulk-select>
  </div>
</template>

<script>
import ReportChips from "./report-chips";
import ReportSelect from "../../components/ReportSelect";
import StoreSelect from "../../components/StoreSelect";
import AddEditOrderDialog from "./add-edit-order-dialog";
import OrderStatusSelect from "../../components/OrderStatusSelect";
import OrdersAnalytics from "./orders-analytics";
import BulkSelect from "./bulk-select";
import ColoredOrderStatus from "../../components/ColoredOrderStatus";

export default {
  components: {ColoredOrderStatus, BulkSelect, OrdersAnalytics, OrderStatusSelect, AddEditOrderDialog, StoreSelect, ReportSelect, ReportChips},
  data() {
    return {
      search: '',
      showAnalytics: false,
      orders: [],
      selectedOrders: [],
      selectedReport: null,
      headers: [
        {text: '#', value: 'checkbox'},
        {text: 'Full name', value: 'fullName'},
        {text: 'Phones', value: 'phone1'},
        {text: 'Address', value: 'address'},
        {text: 'Items', value: 'orderItems'},
        {text: 'Total', value: 'amount'},
        {text: 'Comments', value: 'comments'},
        {text: 'Store', value: 'store'},
        {text: 'Report', value: 'report'},
        {text: 'Source', value: 'source'},
        {text: 'Status', value: 'status'},
        {text: 'Actions', value: 'actions'},
      ],
      loading: {
        getOrders: false,
        orders: {}
      },
    }
  },
  methods: {
    toggleAnalytics() {
      this.showAnalytics = !this.showAnalytics;
    },
    orderIndex(order) {
      return this.orders.findIndex(el => el.id === order.id);
    },
    updateOrderValue(order, key) {
      let requestFields = {}
      requestFields[key] = order[key];
      this.$set(this.loading.orders, order.id, true);
      axios.post(this.apis.updateOrder(order.id), requestFields).finally(() => this.$set(this.loading.orders, order.id, false));
    },
    getOrders() {
      this.loading.getOrders = true;
      this.orders = [];
      this.selectedOrders = [];
      let endpoint = this.selectedReport ? this.apis.getReportOrders(this.selectedReport) : this.apis.getOrders;
      axios.get(endpoint).then(res => {
        this.orders = res.data;
      }).finally(() => this.loading.getOrders = false);
    },
    saveOrder(order) {
      let orderIndex = this.orderIndex(order);
      if (orderIndex >= 0) {
        this.orders.splice(orderIndex, 1, order);
      } else {
        this.orders.unshift(order);
      }
    },
    initReportFromRoute() {
      this.selectedReport = this.routeReportId;
    },
    removeSelected() {
      this.selectedOrders = [];
    }
  },
  watch: {
    selectedReport() {
      this.getOrders();
    }
  },
  computed: {
    toggleAnalyticsText() {
      return this.showAnalytics ? 'Hide Analytics' : 'Show Analytics';
    },
    filteredOrders() {
      if (this.selectedReport) {
        return this.orders.filter(el => el.reportId === this.selectedReport);
      }
      return this.orders;
    },
    routeReportId() {
      let routeReportId = this.$route.params.reportId;
      return routeReportId ? Number.parseInt(routeReportId) : null;
    },
  },
  mounted() {
    this.removeSelected();
    this.initReportFromRoute();
    if (!this.routeReportId) {
      this.getOrders();
    }
  }
}
</script>
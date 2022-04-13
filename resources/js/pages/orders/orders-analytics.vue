<template>
  <v-sheet>
    <div class="d-flex justify-space-around" style="font-size: 18px">
      <v-sheet outlined class="pa-1 grow" v-if="analyzeGroup(orderByStatus).length">
        <v-row no-gutters v-for="(statusTotalGroup, i) of analyzeGroup(orderByStatus)" :key="i" class="pa-2">
          <v-col><strong>{{ orderStatusById(statusTotalGroup.ref).name }}</strong> ({{ statusTotalGroup.length }})</v-col>
          <v-col>{{ statusTotalGroup.total }}JD</v-col>
        </v-row>
      </v-sheet>
      <v-sheet outlined class="pa-1 grow" v-if="analyzeGroup(orderByStore).length">
        <v-row no-gutters v-for="(storesTotalGroup, i) of analyzeGroup(orderByStore)" class="pa-2" :key="i">
          <v-col><strong>{{ storeById(storesTotalGroup.ref).name }}</strong> ({{ storesTotalGroup.length }})</v-col>
          <v-col>{{ storesTotalGroup.total }}JD</v-col>
        </v-row>
      </v-sheet>
    </div>
    <v-sheet class="mt-1 px-2 py-2 d-flex justify-space-between align-center" outlined v-if="reportData.name">
      <strong class="mr-2">{{ reportData.name }}</strong>
      <report-status-select hide-details disabled :value="reportData.status" class="shrink mt-0 pt-0 mr-2" style="max-width: 140px"/>
      <strong class="mr-2">Received: {{ reportData.cashReceived }}JD</strong>
      <v-text-field dense hide-details v-model="deliveryCostAvg" type="number" placeholder="Delivery AVG" class="mr-2 shrink mt-0 pt-0"
                    style="max-width: 150px"/>
      <strong class="mr-2">
        Expected: {{ confirmedOrdersTotal }} - ({{ confirmedOrders.length }} * {{ deliveryCostAvg }}) = {{ expectedCash }}JD
      </strong>
    </v-sheet>
  </v-sheet>
</template>
<script>
import ReportStatusSelect from "../../components/ReportStatusSelect";

export default {
  components: {ReportStatusSelect},
  props: ['orders', 'reportId'],
  data() {
    return {
      deliveryCostAvg: 2.5,
    }
  },
  methods: {
    calculateTotal(orders) {
      return orders.reduce((a, b) => {
        return a + Number.parseFloat(b.amount);
      }, 0);
    },
    analyzeGroup(group) {
      let response = [];
      for (let [key, value] of Object.entries(group)) {
        response.push({
          ref: key,
          total: this.calculateTotal(value),
          length: value.length
        })
      }
      return response;
    }
  },
  computed: {
    confirmedOrdersTotal() {
      return this.calculateTotal(this.confirmedOrders);
    },
    confirmedOrders() {
      return this.orders.filter(el => Number.parseInt(el.status) === 2);
    },
    deliveryTotal() {
      return ((Number.parseFloat(this.deliveryCostAvg) || 0) * this.confirmedOrders.length).toFixed(2);
    },
    expectedCash() {
      return (this.confirmedOrdersTotal - this.deliveryTotal).toFixed(2);
    },
    orderByStatus() {
      return _.groupBy(this.orders, 'status');
    },
    orderByStore() {
      return _.groupBy(this.orders, 'storeId');
    },
    reportData() {
      return this.reportById(this.reportId);
    }
  }
}
</script>
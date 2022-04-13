<template>
  <div class="pa-2">
    <div class="d-flex justify-end">
      <add-report @addReport="addReport"/>
    </div>

    <v-data-table :items="reports" :headers="headers">
      <template v-slot:item.actions="{item}">
        <delete-dialog @confirm="deleteReport(item.id)">
          <v-btn icon small depressed color="red" dark class="mr-2">
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </delete-dialog>
      </template>

      <template v-slot:item.name="{item}">
        <v-btn text :to="`orders/report/${item.id}`">
          {{ item.name }}
          <v-chip small outlined class="ml-1">
            <strong>
              {{ item.ordersCount }}
            </strong>
            <v-icon right small>
              mdi-package-variant-closed
            </v-icon>
          </v-chip>
        </v-btn>
      </template>

      <template v-slot:item.status="{item}">
        <div class="d-flex" style="max-width: 250px">
          <report-status-select hide-details class="shrink mt-0" dense v-model="item.status"
                                @change="updateReportValue(item, 'status')"/>
        </div>
      </template>

      <template v-slot:item.cashReceived="{item}">
        <savable-text style="max-width: 90px" type="number" v-model="item.cashReceived"
                      @change="updateReportValue(item, 'cashReceived')"/>
      </template>

      <template v-slot:item.comments="{item}">
        <savable-text v-model="item.comments"
                      @change="updateReportValue(item, 'comments')"/>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import AddReport from "./add-report";
import ReportStatusSelect from "../../components/ReportStatusSelect";
import SavableText from "../../components/SavableText";

export default {
  components: {SavableText, ReportStatusSelect, AddReport},
  data() {
    return {
      headers: [
        {text: 'Name', value: 'name'},
        {text: 'Status', value: 'status'},
        {text: 'Comments', value: 'comments'},
        {text: 'Received Cash', value: 'cashReceived'},
        {text: 'Actions', value: 'actions'},
      ],
    }
  },
  methods: {
    addReport(report) {
      this.$store.state.reports.unshift(report);
    },
    deleteReport(reportId) {
      axios.delete(this.apis.deleteReport(reportId)).then(() => {
        let reportIndex = this.reports.findIndex(el => el.id === reportId);
        this.$store.state.reports.splice(reportIndex, 1);
      });
    },
    updateReportValue(report, key) {
      let requestFields = {}
      requestFields[key] = report[key];
      axios.post(this.apis.updateReport(report.id), requestFields);
    }
  },
  mounted() {
    this.getReports();
  }
}
</script>

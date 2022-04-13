<template>
  <v-dialog v-model="dialog" max-width="500">
    <template v-slot:activator="{on}">
      <v-btn depressed small v-on="on" color="primary" class="shrink">
        <v-icon left>
          mdi-plus
        </v-icon>
        New
      </v-btn>
    </template>
    <v-card :loading="loading">
      <v-card-title>Report</v-card-title>
      <v-card-text>
        <v-form ref="reportForm">
          <v-text-field :prefix="`${reportPrefix} - `" label="Name" placeholder="Name" v-model="report.name" hide-details/>
          <v-text-field label="Comments" placeholder="Comments" v-model="report.comments" hide-details/>
        </v-form>
      </v-card-text>
      <v-card-actions class="d-flex justify-end">
        <v-btn depressed color="primary" @click="saveReport">Save</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  data() {
    return {
      dialog: false,
      loading: false,
      report: {
        name: '',
        comments: '',
      }
    }
  },
  methods: {
    saveReport() {
      this.loading = false;
      this.report.name = this.reportPrefix + "-" + this.report.name;
      axios.post(this.apis.storeReport, this.report).then(res => {
        this.$emit('addReport', res.data);
        this.dialog = false;
      }).finally(() => this.loading = false);
    },
    numberToText(number) {
      return `${number}`.split("").map(el => {
        return String.fromCharCode(el.charCodeAt(0) + 16);
      }).join("");
    }
  },
  watch: {
    dialog() {
      this.$refs?.reportForm?.reset();
    }
  },
  computed: {
    dayNumber() {
      let today = new Date();
      return today.getDate();
    },
    reportPrefix() {
      return this.numberToText(this.dayNumber);
    }
  },
  mounted() {
  }
}
</script>
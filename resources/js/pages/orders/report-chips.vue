<template>
  <v-sheet tile outlined class="py-0 px-2 d-flex justify-space-between align-center">
    <v-chip-group v-model="selectedReport" mandatory active-class="primary--text">
      <v-chip :value="null">
        All
      </v-chip>
      <v-chip v-for="report in reports" :value="report.id" :key="report.id">
        {{ report.name }}
      </v-chip>
    </v-chip-group>
  </v-sheet>
</template>
<script>
export default {
  props: ['value'],
  data() {
    return {
      selectedReport: null,
    }
  },
  methods: {
    initValue() {
      this.selectedReport = Number.parseInt(this.value) || null;
    }
  },
  watch: {
    selectedReport(val) {
      this.$emit('input', val);
    },
    value() {
      this.initValue();
    }
  },
  mounted() {
    this.getReports();
    this.initValue();
  }
}
</script>
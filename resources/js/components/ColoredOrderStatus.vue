<template>
  <span v-if="statusObject" :style="`color: ${statusObject.color}`">
    {{ statusObject.name }}
  </span>
</template>
<script>
export default {
  props: ['orderStatusId'],
  data() {
    return {
      statusObject: null,
    }
  },
  methods: {
    initValue() {
      this.statusObject = this.orderStatusId >= 0 ? this.orderStatusById(this.orderStatusId) : null;
    }
  },
  watch: {
    orderStatusId(){
      this.initValue();
    }
  },
  mounted() {
    this.initValue();
  }
}
</script>
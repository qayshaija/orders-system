<template>
  <div class="d-flex align-center" style="position: relative">
    <div @click="showButton" class="shrink">
      <v-text-field class="shrink" v-model="tmpText" v-bind="$attrs" :disabled="disabled" @click="showButton"/>
    </div>
    <v-icon size="20" class="ml-n1" color="primary" @click="prependClick" v-if="!disabled">
      mdi-content-save
    </v-icon>
  </div>
</template>
<script>
export default {
  props: ['value'],
  data() {
    return {
      tmpText: '',
      disabled: true,
    }
  },
  methods: {
    showButton() {
      this.disabled = false;
    },
    initValue() {
      this.tmpText = typeof this.value === 'number' ? this.value : (this.value || '');
    },
    toggleDisable() {
      this.disabled = !this.disabled;
    },
    emitValue(val) {
      if (val !== this.value) {
        this.$emit('input', val);
        this.$emit('change');
      }
    },
    prependClick() {
      if (!this.disabled) {
        this.emitValue(this.tmpText);
      }
      this.toggleDisable();
    }
  },
  watch: {
    currentText() {
      this.initValue();
    }
  },

  mounted() {
    this.initValue();
  }
}
</script>

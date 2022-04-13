<template>
  <v-dialog v-model="dialog" width="500">
    <template v-slot:activator="{ on, attrs }">
      <span v-bind="attrs" v-on="on">
        <slot></slot>
      </span>
    </template>
    <v-card v-if="dialog">
      <v-card-title class="red white--text text-h5">
        Confirm Deletion
      </v-card-title>
      <v-divider></v-divider>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary" text @click="dialog = false">
          Cancel
        </v-btn>
        <v-btn color="red" text @click="confirm()">
          Confirm
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  data() {
    return {
      dialog: false,
    }
  },
  methods: {
    confirm() {
      this.dialog = false;
      this.$emit('confirm');
    }
  }
}
</script>

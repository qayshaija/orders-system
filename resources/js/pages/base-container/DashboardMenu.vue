<template>
  <v-list>
    <div v-for="(page, key) in $store.state.userPages" :key="key">
      <v-list-item link :to="page.route">
        <v-list-item-icon>
          <v-icon>{{ page.icon }}</v-icon>
        </v-list-item-icon>
        <v-list-item-title>{{ page.name }}</v-list-item-title>
      </v-list-item>
    </div>
  </v-list>
</template>

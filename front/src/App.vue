<template>
  <v-app>
    <core-app-bar v-if="['Login'].indexOf($route.name)"/>

    <core-drawer v-if="['Login'].indexOf($route.name)"/>

    <core-view />

    <!--<core-footer />-->
  </v-app>
</template>

<script>
  export default {
    components: {
      CoreDrawer: () => import('@/components/core/Drawer'),
      CoreFooter: () => import('@/components/core/Footer'),
      CoreAppBar: () => import('@/components/core/AppBar'),
      CoreView: () => import('@/components/core/View')
    },
  }
</script>

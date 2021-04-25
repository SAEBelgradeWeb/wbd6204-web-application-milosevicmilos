<template>
  <layout-horizontal>

    <router-view />

    <template #navbar="{ toggleVerticalMenuActive }">
      <app-navbar-horizontal-layout-brand />
      <navbar :toggle-vertical-menu-active="toggleVerticalMenuActive" />
    </template>

  </layout-horizontal>
</template>

<script>
import LayoutHorizontal from '@core/layouts/layout-horizontal/LayoutHorizontal.vue'
import AppNavbarHorizontalLayoutBrand from '@core/layouts/components/app-navbar/AppNavbarHorizontalLayoutBrand.vue'
import Navbar from '../components/Navbar.vue'

export default {
  components: {
    LayoutHorizontal,
    Navbar,
    AppNavbarHorizontalLayoutBrand,
  }
}
</script>
